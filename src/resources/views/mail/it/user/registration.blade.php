@component('mail::message')
# Attivazione utente

Ciao {{ $user->username }},

grazie per esserti registrato su {{ config('app.name') }}. Clicca sul pulsante in basso per attivare il tuo utente.

@component('mail::button', ['url' => url('confirm', ['code' => $user->confirmation_code, 'user' => $user->username])])
Attiva il tuo account
@endcomponent

Grazie,<br>
il team di {{ config('app.name') }}

<small>Se non riesci a cliccare sul pulsante "Attiva il tuo account", copia e incolla l'URL seguente nel tuo browser:</small>
<small>{!! url('confirm', ['code' => $user->confirmation_code, 'user' => $user->username]) !!}</small>

@endcomponent
