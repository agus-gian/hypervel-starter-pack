<x-email.layout>
    <h1>Verify Your Email Address</h1>

    <p>Thanks for signing up! To get started, please click the button below to confirm your email address.</p>

    <p class="button-container"><a href="{{$verificationUrl}}" target="_blank" class="button">Verify Email</a></p>

    <p style="font-size: 12px;">If the button above doesn't work, copy and paste this link into your browser:</p>
    <p style="font-size: 12px;"><a href="{{ $verificationUrl }}" target="_blank" style="color: #007bff; text-decoration: underline;">{{ $verificationUrl }}</a></p>
    <br>
    <p>Best Regards,</p>
    <p>{{ config('app.name') }} Team</p>
</x-email.layout>