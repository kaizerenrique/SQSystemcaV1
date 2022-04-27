<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            <form action="{{ route('consulta.show') }}" method="POST">
                @csrf
                <div class="col-span-4 sm:col-span-2 py-2">
                    <x-jet-label for="cedula" value="{{ __('Ingrese número de cédula o el código de identificación asignado al perfil de un menor de edad sin cédula de identidad Ejemplo: MSC-0000000') }}" />
                    <x-jet-input id="cedula" name="cedula" type="text" class="mt-1 block w-full"/>
                    <x-jet-input-error for="cedula" class="mt-2" />
                </div>
                <div class="flex justify-end mt-4">
                    <x-jet-button class="ml-4" type="submit">
                        {{ __('Consultar') }}
                    </x-jet-button>
                </div>
            </form>
        </div>        
    </x-jet-authentication-card>
</x-guest-layout>