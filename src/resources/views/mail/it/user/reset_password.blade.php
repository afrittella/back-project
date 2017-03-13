@component('mail::message')
# Reimpostazione password

Ciao,

ricevi questa email perché abbiamo ricevuto una richiesta di reimpostazione della password. Per scegliere una nuova password clicca sul pulsante "Reimposta password".

@component('mail::button', ['url' => route('password.reset', $token)])
Reimposta password
@endcomponent

Grazie,<br>
il team di {{ config('app.name') }}

<small>Se non riesci a cliccare sul pulsante "Reimposta password", copia e incolla l'URL seguente nel tuo browser:</small>
<small>{!! route('password.reset', $token) !!}</small>
@endcomponent
