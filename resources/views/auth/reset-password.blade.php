<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') }} | Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    {{--<link rel="shortcut icon" href="{{ env('APP_FE_URL') }}/favicon.ico">--}}
    <style>
        html, body {
            font-family: "Nunito", sans-serif;
            height: 100%;
        }

        .title {
            font-size: 15px;
            font-weight: 700;
            line-height: 22px;
            text-align: center;
        }

        .password-input {
            padding: 12px 15px;
            border-radius: 5px;
        }

        .btn {
            padding: 12px 15px; border-radius: 5px;
        }

        .btn.btn-confirm {
            background: #689CFF;
        }

        .btn.btn-inactive {
            background: #ACACAC;
        }

        .btn span {
            font-size: 15px;
            font-weight: 700;
            line-height: 22px;
            text-align: center;
            color: white;
        }

        .rule-text {
            font-size: 13px;
            font-weight: 400;
            line-height: 20px;
            color: #3A3A3A;
        }

        input::placeholder {
            font-size: 15px;
            font-weight: 400;
            line-height: 20px;
            color: #ACACAC;
        }

        input::-webkit-input-placeholder {
            font-size: 15px;
            font-weight: 400;
            line-height: 20px;
            color: #ACACAC;
        }

        input:-ms-input-placeholder {
            font-size: 15px;
            font-weight: 400;
            line-height: 20px;
            color: #ACACAC;
        }

        input::-ms-input-placeholder {
            font-size: 15px;
            font-weight: 400;
            line-height: 20px;
            color: #ACACAC;
        }

        .input-group-text.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid {
            padding-right: 0;
            background-image: none;
        }

        .alert-success-password-reset {
            background-color: #089347;
            color: white;
            border-radius: 30px;
        }

        .btn-close {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23FFF'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e");
            opacity: 1;
        }

        .label-success {
            font-size: 22px;
            font-weight: 700;
            line-height: 31px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center" style="margin-top: 30px">
        <div class="col-11 col-lg-4">
            @if(session()->has('success'))
                <div id="alert-success" class="alert alert-success-password-reset alert-dismissible fade show" role="alert">
                    {{ session()->get('success') }}
                    <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session()->get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <p class="text-center mb-4 d-none">
                <img alt="{{ config('app.name') }}" src="{{ asset('assets/image/logo.svg') }}" width="120" height="120">
            </p>

            <div id="container-success" style="display: none;">
                <p class="label-success">
                    Yes, your password<br />has been reset!
                </p>
            </div>

            <div id="container-default">
                <h5 class="title text-center mb-4">
                    Reset Password
                </h5>

                <form id="form-password-reset" method="POST" action="{{ route('password.reset.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ request()->query('email') }}" autocomplete="false">

                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0 @error('password') is-invalid @enderror">
                            <img alt="Password" src="{{ asset('assets/image/lock.svg') }}" width="16px" height="21px">
                        </span>

                        <input id="password" type="password" class="form-control border-start-0 border-end-0 password-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New password" aria-label="New password" aria-describedby="password-addon">

                        <span class="input-group-text bg-white border-start-0 @error('password') is-invalid @enderror">
                            <img alt="Password" class="visibility" src="{{ asset('assets/image/password-visibility.svg') }}" width="24px" height="24px">
                        </span>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <i class="fa-solid fa-circle-exclamation"></i> <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0 @error('password') is-invalid @enderror">
                            <img alt="Password Confirmation" src="{{ asset('assets/image/lock.svg') }}" width="16px" height="21px">
                        </span>

                                                <input id="password-confirm" type="password" class="form-control border-start-0 border-end-0 password-input @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password" aria-label="Confirm password" aria-describedby="password-confirm-addon">

                        <span class="input-group-text bg-white border-start-0 @error('password') is-invalid @enderror">
                            <img alt="Password" class="visibility" src="{{ asset('assets/image/password-visibility.svg') }}" width="24px" height="24px">
                        </span>
                    </div>

                    <p class="rule-text my-4">Create an unique password, use uppercase (A-Z), lowercase (a-z), and numeral (0-9). Minimum 8 Characters</p>

                    <button id="btn-password-reset" type="submit" class="btn btn-inactive w-100">
                        <span>Confirm</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.visibility').click(function() {
        let passwordFields = $('.password-input');
        let passwordFieldType = passwordFields.attr('type');

        if (passwordFieldType === 'password') {
            passwordFields.attr('type', 'text');
            $('.visibility').attr('src', '{{ asset('assets/image/password-visibility-off.svg') }}');
        } else {
            passwordFields.attr('type', 'password');
            $('.visibility').attr('src', '{{ asset('assets/image/password-visibility.svg') }}');
        }
    });

    $('#password, #password-confirm').on('input', function() {
        var password = $('#password').val();
        var passwordConfirm = $('#password-confirm').val();

        if (password !== '' && passwordConfirm !== '') {
            $('#btn-password-reset').removeClass('btn-inactive').addClass('btn-confirm');
        } else {
            $('#btn-password-reset').removeClass('btn-confirm').addClass('btn-inactive');
        }
    });

    $('#form-password-reset').submit(function () {
        $('#btn-password-reset').find('span').text('Loading...').disable(true);
    });

    setTimeout(function() {
        let alertSuccess = document.getElementById('alert-success');
        let containerSuccess = document.getElementById('container-success');
        let containerDefault = document.getElementById('container-default');

        if (alertSuccess) {
            alertSuccess.style.display = 'none';
            containerSuccess.style.display = 'block';
            containerDefault.style.display = 'none';
        }
    }, 500); // Initial timeout to hide the alert
</script>
</body>
</html>
