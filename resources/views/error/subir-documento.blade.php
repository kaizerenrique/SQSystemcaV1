<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('El documento aún no ha sido publicado por el laboratorio, intente nuevamente más tarde. ') }}
        </div>        
    </x-jet-authentication-card>
</x-guest-layout>