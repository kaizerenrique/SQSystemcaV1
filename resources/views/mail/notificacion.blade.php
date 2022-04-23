@component('mail::message')
# Saludos

{{$mensajeCorreo}}

### Nombre: {{$nombre}}
### Apellido: {{$apellido}}
### Cedula: {{$cedula}}
### Código: {{$code}}

@component('mail::button', ['url' => 'http://ditecp.xyz/personas'])
Ingresar.
@endcomponent

Gracias,<br>
© {{ date('Y') }} {{ config('app.name') }}
@endcomponent