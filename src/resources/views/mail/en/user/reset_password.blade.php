@component('mail::message')
# Reset password

Hello,

You received this email because we have received a password reset request. To choose a new password, click the "Reset Password" button.

@component('mail::button', ['url' => route('password.reset', $token)])
Reset Password
@endcomponent

Thank you,<br>
The IT team {{ config('app.name') }}

<small>If you can not click the "Reset Password" button, copy and paste the following URL into your browser:</small>
<small>{!! route('password.reset', $token) !!}</small>
@endcomponent
