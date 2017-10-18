@component('mail::message')
# User Activation

Hello {{ $user->username }},

You have registered in the webapp named {{ config('app.name') }}. Click the button below to activate your user.

@component('mail::button', ['url' => url('confirm', ['code' => $user->confirmation_code, 'user' => $user->username])])
Activate your account
@endcomponent

Thank you,<br>
The IT Team {{ config('app.name') }}

<small>If you can not click the "Activate Your Account" button, copy and paste the following URL into your browser:</small>
<small>{!! url('confirm', ['code' => $user->confirmation_code, 'user' => $user->username]) !!}</small>

@endcomponent
