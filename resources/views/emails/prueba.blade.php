@component('mail::message')
# Hola {{ $usuario }}

{{ $mensaje }}

@component('mail::button', ['url' => config('app.url')])
Ir al sitio
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
