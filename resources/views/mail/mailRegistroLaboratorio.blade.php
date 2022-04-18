@component('mail::message')
# Bienvenid@

## Dirigido a: {{$name}}
Por medio de este correo le damos la bienvenid@, puedes ingresar usando las siguientes credenciales:
### Correo: {{$email}}
### Contraseña: {{$password}}
### Token API: {{$token}}

Es importante que inicie sesión y confirme su correo electrónico, una vez confirmado se recomienda ir al perfil y cambiar la contraseña.

@component('mail::button', ['url' => 'http://ditecp.xyz/login'])
Ingresar.
@endcomponent

Gracias,<br>
© {{ date('Y') }} {{ config('app.name') }}
@endcomponent