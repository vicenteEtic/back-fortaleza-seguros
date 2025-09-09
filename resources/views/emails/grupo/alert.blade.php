{{-- resources/views/emails/grupo/alert.blade.php --}}
@component('mail::message')
# Olá {{ $user->name }}

Você está recebendo esta notificação porque pertence ao grupo de alerta.

@component('mail::button', ['url' => config('app.url')])
Ver mais detalhes
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
