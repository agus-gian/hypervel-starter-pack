<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100;0,9..40,200;0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,100;1,9..40,200;1,9..40,300;1,9..40,400;1,9..40,500;1,9..40,600;1,9..40,700&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="{{ env('APP_FE_URL') }}/favicon.ico">
        <style>
            body, p, h1 {
                margin: 0;
                font-family: 'DM Sans', sans-serif;
            }

            h1 {
                font-size: 20px;
                font-weight: 700;
                line-height: 150%;
                margin-bottom: 36px;
            }

            p {
                font-weight: 400;
                font-size: 16px;
                line-height: 180%;
            }

            a {
                color: #689CFF;
            }

            table {
                border-spacing: 0;
                width: 100%;
            }

            td {
                padding: 0;
            }

            img {
                border: 0;
                vertical-align: bottom;
            }

            .logo {
                width: 80px;
                border-radius: 10px;
            }

            .button-container {
                padding: 36px 0;
                text-align: center;
            }

            .button {
                padding: 10px 40px 10px 40px;
                text-decoration: none;
                background: #689CFF;
                color: #ffffff !important;
                border-radius: 4px;
                font-size: 15px;
                line-height: 20px;
                width: 279px;
            }

            .wrapper {
                text-align: center;
            }

            .head {
                height: 150px;
                background: #F2F6F9;
                text-align: left;
            }

            .head td {
                padding: 48px;
            }

            .content {
                text-align: left;
            }

            .content > td {
                padding: 48px;
            }

            .footer > td {
                padding: 0 48px;
            }

            .download {
                font-size: 14px;
                line-height: 150%;
                color: #494747;
            }

            .pitch {
                padding: 32px;
                background: #F5F8FF;
            }

            .badge {
                background: #F5F8FF;
            }

            .support {
                padding: 32px;
                background: #F5F8FF;
            }

            .copyright > td {
                padding: 36px;
            }

            .social > td {
                padding: 0 60px;
                padding-bottom: 204px;
            }

            .social table {
                width: 180px;
                margin: auto;
            }

            .footer2 {
                display: none;
            }

            .footer2 > td {
                padding: 0 48px;
            }

            .footer2 > td > table {
                padding: 32px;
                background: #F2F6F9;
                text-align: left;
            }

            .pitch2 > td {
                padding-bottom: 20px;
            }

            .badge2 table {
                width: fit-content;
            }

            .support2 > td {
                padding-top: 20px;
            }

            .social2 > td {
                padding: 0 48px 48px;
            }

            .social2 > td > table {
                padding: 32px;
                text-align: left;
            }

            .social2 > td > table table {
                text-align: center;
            }

            .social2 {
                display: none;
            }

            .email {
                font-weight: 700;
                color: red;
            }

            @media screen and (max-width: 768px) {
                .footer {
                    display: none;
                }

                .copyright {
                    display: none;
                }

                .social {
                    display: none;
                }

                .footer2 {
                    display: revert;
                }

                .social2 {
                    display: revert;
                }
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <table class="main">
                <tr class="content">
                    <td>
                        {{$slot}}
                    </td>
                </tr>

                <tr class="footer">
                    <td>
                        <table>
                            <tr>
                                <td class="support">
                                    <p class="download">Need Help? <a href="{{ config('app.frontend_url') }}">Contact our support team</a></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="copyright">
                    <td>
                        <p class="download">{{ config('app.env') === 'production' ? config('app.env') : config('app.name_staging') }} {{ date('Y') }}</p>
                    </td>
                </tr>
                <tr class="social">
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <img alt="{{ config('app.name') }} Facebook" src="{{asset('assets/image/email-social-fb.png')}}">
                                </td>
                                <td>
                                    <img alt="{{ config('app.name') }} X" src="{{asset('assets/image/email-social-tw.png')}}">
                                </td>
                                <td>
                                    <img alt="{{ config('app.name') }} Instagram" src="{{asset('assets/image/email-social-ig.png')}}">
                                </td>
                                <td>
                                    <img alt="{{ config('app.name') }} E-mail" src="{{asset('assets/image/email-social-in.png')}}">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="footer2">
                    <td>
                        <table>
                            <tr class="support2">
                                <td>
                                    <p class="download">Need Help? <a href="{{ config('app.frontend_url') }}">Contact our support team</a></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="social2">
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <p class="download">{{ config('app.env') === 'production' ? config('app.name') : config('app.name_staging') }} {{ date('Y') }}</p>
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                <img alt="{{ config('app.name') }} Facebook" src="{{asset('assets/image/email-social-fb.png')}}">
                                            </td>
                                            <td>
                                                <img alt="{{ config('app.name') }} X" src="{{asset('assets/image/email-social-tw.png')}}">
                                            </td>
                                            <td>
                                                <img alt="{{ config('app.name') }} Instagram" src="{{asset('assets/image/email-social-ig.png')}}">
                                            </td>
                                            <td>
                                                <img alt="{{ config('app.name') }} E-mail" src="{{asset('assets/image/email-social-in.png')}}">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
