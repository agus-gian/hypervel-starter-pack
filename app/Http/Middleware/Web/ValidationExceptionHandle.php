<?php

declare(strict_types=1);

namespace App\Http\Middleware\Web;

use Hyperf\Contract\MessageBag as MessageBagContract;
use Hyperf\Contract\MessageProvider;
use Hyperf\Support\MessageBag;
use Hyperf\ViewEngine\Contract\FactoryInterface;
use Hyperf\ViewEngine\ViewErrorBag;
use Hypervel\Session\Contracts\Session as SessionContract;
use Hypervel\Validation\ValidationException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class ValidationExceptionHandle implements MiddlewareInterface
{
    public function __construct(
        protected ContainerInterface $container,
        protected SessionContract $session,
        protected FactoryInterface $view
    ) {
    }

    /**
     * Process an incoming server request.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Clear old flash data at the start of each request
        $this->clearFlashData();
        
        try {
            $response = $handler->handle($request);
        } catch (Throwable $throwable) {
            if ($throwable instanceof ValidationException) {
                /* @var ValidationException $throwable */
                $this->withErrors($throwable->errors(), $throwable->errorBag);

                // Store old input data for form repopulation
                $this->flashInputForForm($request);

                // Try to get previous URL, if not available use referer, if not available use current URL
                $previousUrl = $this->session->previousUrl()
                    ?? $request->getHeaderLine('Referer')
                    ?? (string) $request->getUri();

                /* @phpstan-ignore-next-line */
                return response()->redirect($previousUrl);
            }

            throw $throwable;
        }

        return $response;
    }

    public function withErrors($provider, $key = 'default'): static
    {
        $value = $this->parseErrors($provider);

        $errors = $this->session->get('errors', new ViewErrorBag());

        if (! $errors instanceof ViewErrorBag) {
            $errors = new ViewErrorBag();
        }

        /* @phpstan-ignore-next-line */
        $this->session->put(
            'errors',
            $errors->put($key, $value)
        );

        return $this;
    }

    protected function parseErrors($provider): MessageBagContract
    {
        if ($provider instanceof MessageProvider) {
            return $provider->getMessageBag();
        }

        return new MessageBag((array) $provider);
    }

    protected function flashInputForForm(ServerRequestInterface $request): void
    {
        $input = [];

        // Get parsed body (form data)
        $parsedBody = $request->getParsedBody();
        if (is_array($parsedBody)) {
            // Filter out sensitive data like passwords for security
            foreach ($parsedBody as $key => $value) {
                // Don't flash password fields for security
                if (!in_array($key, ['password', 'password_confirmation', '_token'])) {
                    $input[$key] = $value;
                }
            }
        }

        // Get query params
        $queryParams = $request->getQueryParams();
        if (is_array($queryParams)) {
            $input = array_merge($input, $queryParams);
        }

        // Store old input data as flash data (will be deleted after next request)
        if (!empty($input)) {
            // Use a temporary session key that gets cleared
            $this->session->put('_flash_old_input', $input);
        }
    }

    protected function clearFlashData(): void
    {
        // Clear previous flash data
        $this->session->forget('_flash_old_input');
        
        // Also clear old errors if they exist
        $this->session->forget('errors');
    }
}
