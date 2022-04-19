<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-4 text-2xl">
        <div class="mt-4 text-2xl flex justify-between">
            <div>
                Configuraciones 
            </div>
        </div>        
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 py-6">
        
        <card class="col-span-1 bg-emerald-500 w-80 rounded-2xl border shadow py-12 px-8 hover:-translate-y-1 hover:shadow-2xl hover:bg-emerald-300 delay-75 duration-100">
            <p class="text-center text-xl text-gray-700 font-semibold py-3">Información del Sistema</p>
            <p class="text-lg text-gray-700 font-semibold mt-1">Perfiles Por Usuario: {{$config->max_personas}}</p>
            <p class="text-lg text-gray-700 font-semibold mt-1">Perfiles Por Empresa: {{$config->max_empresas}}</p>
            <p class="text-lg text-gray-700 font-semibold mt-1">Correo de Notificaciones</p>
            <p class="text-lg text-gray-700 font-semibold mt-1">{{$config->email_system}}</p>
            
            <button class="mt-10 w-full py-3 rounded-xl border border-purple-600 text-lg text-purple-600 hover:bg-purple-600 hover:text-gray-50" wire:click="configuracionSistema({{$config->id}})">
                Modificar
            </button>
        </card> 

        <card class="col-span-1 bg-teal-500 w-80 rounded-2xl border shadow py-12 px-8 hover:-translate-y-1 hover:shadow-2xl hover:bg-teal-300 delay-75 duration-100">
            <p class="text-center text-xl text-gray-700 font-semibold py-3">Estadísticas</p>
            <p class="text-lg text-gray-700 font-semibold mt-1">Usuarios Registrados: {{$usuarios}}</p>            
            <p class="text-lg text-gray-700 font-semibold mt-1">Laboratorios Registrados: {{$laboratorio}}</p>
            <p class="text-lg text-gray-700 font-semibold mt-1">Total Cuentas: {{$users_count}}</p>            
            <p class="text-lg text-gray-700 font-semibold mt-1">Total Perfiles: {{$personas_count}}</p>
            <p class="text-lg text-gray-700 font-semibold mt-1">Total Historias: {{$historias_count}}</p>
        </card>               
    </div>

<!-- Modal Agregar Maximo de Perfiles -->
    <x-jet-dialog-modal wire:model="configuracion">
        <x-slot name="title">
            {{ __('Configuraciones del Sistema') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-4 sm:col-span-2 py-2">
                <x-jet-label for="max_persona" value="{{ __('Numero máximo de Perfiles personales') }}" />
                <x-jet-input id=">confi.max_personas" type="text" class="mt-1 block w-full" wire:model.defer="confi.max_personas"/>
                <x-jet-input-error for="confi.max_personas" class="mt-2" />
            </div>
            <div class="col-span-4 sm:col-span-2 py-2">
                <x-jet-label for="max_empresas" value="{{ __('Numero máximo de Perfiles por Empresas') }}" />
                <x-jet-input id=">confi.max_empresas" type="text" class="mt-1 block w-full" wire:model.defer="confi.max_empresas"/>
                <x-jet-input-error for="confi.max_empresas" class="mt-2" />
            </div>            
            <div class="col-span-4 sm:col-span-2 py-2">
                <x-jet-label for="email_system" value="{{ __('Correo de Administración') }}" />
                <x-jet-input id=">confi.email_system" type="email" class="mt-1 block w-full" wire:model.defer="confi.email_system"/>
                <x-jet-input-error for="confi.email_system" class="mt-2" />
            </div>
            <div class="col-span-4 sm:col-span-2 py-2">
                El correo es usado para enviar los notificaciones del registro de los laboratorios así como sus datos de conexión, de igual forma se usara para enviar notificaciones del sistema.
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('configuracion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>
            <x-jet-danger-button class="ml-3" wire:click="maximoPerfilGuardar()" wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
<!-- Modal Agregar Maximo de Perfiles -->
</div>
