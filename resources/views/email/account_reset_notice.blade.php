<x-email.layout>
    <img style="margin-bottom: 36px;" src="{{asset('assets/image/email-reset-lock.png')}}" alt="Password Reset">

    <h1>Password Reset</h1>

    <p>{{$user->name}},</p>
    <br>
    <p>You recently requested to reset your password for your {{ config('app.name') }} account.</p>
    <br>
    <p>To reset your password, click the button below:</p>

    <p class="button-container"><a href="{{$reset}}" target="_blank" class="button">Reset My Password</a></p>

    <p>This password reset link will expire in 2 hours. If you did not initiate this action, we highly advise that you change your password as soon as possible and also notify us by replying to this mail.</p>
    <br>
    <p>Best Regards,</p>
    <p>{{ config('app.name') }} Team</p>
</x-email.layout>
