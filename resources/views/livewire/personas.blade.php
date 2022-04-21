<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
<!-- Cabecera y boton -->    
    <div class="mt-4 text-2xl">
        <div class="mt-4 text-2xl flex justify-between">
            <div>
                Registrar perfiles
            </div>
            <div class="mr-2">
                <x-jet-button class="bg-indigo-500 hover:bg-indigo-700" wire:click="agregarPerfil" >
                    {{ __('Registro') }}
                </x-jet-button>
            </div>
        </div>        
    </div> 

<!-- seccion de personas -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 py-6">
        @foreach($personas as $persona)
            <card class="col-span-1 bg-teal-400 w-80 rounded-2xl border shadow py-12 px-8 hover:-translate-y-1 hover:shadow-2xl hover:bg-teal-200 delay-75 duration-100">
                <p class="text-center text-xl text-gray-700 font-semibold py-3">Perfil de Usuario</p>
                <p class="text-lg text-gray-700 font-semibold mt-1">{{$persona->nombre }}</p>
                <p class="text-lg text-gray-700 font-semibold mt-1">{{$persona->apellido}}</p>
                <p class="text-lg text-gray-700 font-semibold mt-1">{{$persona->nac }}{{$persona->cedula }}</p>
                <p class="text-lg text-gray-700 font-semibold mt-1">Código: {{$persona->idusuario }} </p>                
                <button class="mt-10 w-full py-3 rounded-xl border border-purple-600 text-lg text-purple-600 hover:bg-purple-600 hover:text-gray-50" wire:click="mostrarCodigo({{$persona->id}})">
                    Ver
                </button>
            </card>                
        @endforeach       
    </div>

    <div>
        <!--
        <div class="flex justify-between">            
            <div>
                <input wire:model="buscar" type="search" placeholder="Buscar" class="shadow appearence-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder-indigo-500" name="">
            </div>            
        </div>
        -->
        <table class="table-auto w-full mt-6">
            <thead>
                <tr class="bg-indigo-500 text-white">
                    <th class="px-4 py-2">
                        <div class="flex items-center">Código</div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">Nombre de archivo</div>
                    </th>                     
                    <th class="px-4 py-2">
                        <div class="flex items-center">Laboratorio</div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">Acción</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($historials as $historial)
                    <tr>                        
                        <td class="rounded border px-4 py-2">{{$historial->codigo}}</td>
                        <td class="rounded border px-4 py-2">
                            <a href="{{$historial->url_simbol}}" target="_blank">
                                {{$historial->nombreArchivo}}
                            </a>                            
                        </td>
                        <td class="rounded border px-4 py-2">{{$historial->nombreLaboratorio}}</td> 
                        <td class="rounded border px-4 py-2">
                            <x-jet-button class="bg-green-500 hover:bg-green-700">
                                <a href="{{$historial->url_simbol}}" target="_blank">
                                    {{ __('Ver') }}
                                </a>                                
                            </x-jet-button>                           
                        </td>                       
                    </tr>
                @endforeach
            </tbody>
        </table>        
    </div>
    <div class="mt-4">
        {{$historials->links()}}
    </div>

<!-- Inicio del Modal para Editar datos de usuario -->
    <x-jet-dialog-modal wire:model="modalCedula">
        <x-slot name="title">
            {{ __('Registro') }}
        </x-slot>
        <x-slot name="content">             
            <div class="grid grid-cols-4 gap-4 text-sm text-gray-600">                
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="nacionalidad" value="{{ __('Nacionalidad') }}" />
                    <select name="nac" id="nac" wire:model.defer="nac" class="mt-1 block w-full"> 
                        <option value="" selected>Selecciona la Nacionalidad</option>                                                                         
                        <option value="V">Venezolano</option>
                        <option value="E">Extranjero</option>
                    </select> 
                    <x-jet-input-error for="nac" class="mt-2" />                   
                </div>
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="cedula" value="{{ __('Numero de Cedula') }}" />
                    <x-jet-input id="cedula" type="text" class="mt-1 block w-full" wire:model.defer="cedula" />
                    <x-jet-input-error for="cedula" class="mt-2" />
                </div>                                           
            </div>
        </x-slot>            

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalCedula', false)" wire:loading.attr="disabled">
                    {{ __('Cerrar') }}
            </x-jet-secondary-button>
            <x-jet-danger-button class="ml-3" wire:click="comprobarCedula()" wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-jet-danger-button>            
        </x-slot>
    </x-jet-dialog-modal>
<!-- Fin del Modal para Editar datos de usuario -->
<!-- Inicio del Modal para alertas  -->
    <x-jet-dialog-modal wire:model="mensajeModal">
        <x-slot name="title">
            {{ __('Alerta') }}
        </x-slot>

        <x-slot name="content">            
            {{$mensaje}}            
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('mensajeModal', false)" wire:loading.attr="disabled">
                {{ __('Aceptar') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
<!-- Agregar Persona Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmingPersonaAdd">
            <x-slot name="title">
                {{'Registrar' }}
            </x-slot>

            <x-slot name="content">                
                <div class="grid grid-cols-4 gap-4 text-sm text-gray-600">
                    <div class="col-span-4 sm:col-span-2">
                        <x-jet-label for="name" value="{{ __('Nombre') }}" />
                        <x-jet-input id="nombre" type="text" class="mt-1 block w-full" wire:model.defer="nombre"/>
                        <x-jet-input-error for="nombre" class="mt-2" />
                    </div>
                    <div class="col-span-4 sm:col-span-2">
                        <x-jet-label for="apellido" value="{{ __('Apellido') }}" />
                        <x-jet-input id="apellido" type="text" class="mt-1 block w-full" wire:model.defer="apellido"/>
                        <x-jet-input-error for="apellido" class="mt-2" />
                    </div>
                    <div class="col-span-4 sm:col-span-2">
                        <x-jet-label for="nac" value="{{ __('Nacionalidad') }}" />
                        <x-jet-input id="nac" name="nac" type="text" class="mt-1 block w-full" wire:model.defer="nac" disabled/>
                        <x-jet-input-error for=">nac" class="mt-2" />
                    </div>                    
                    <div class="col-span-4 sm:col-span-2">
                        <x-jet-label for="cedula" value="{{ __('Cedula') }}" />
                        <x-jet-input id="cedula" name="cedula" type="text" class="mt-1 block w-full" wire:model.defer="cedula" disabled/>
                        <x-jet-input-error for="cedula" class="mt-2" />
                    </div>
                    <div class="col-span-4 sm:col-span-2">
                        <x-jet-label for="pasaporte" value="{{ __('Pasaporte') }}" />
                        <x-jet-input id=">pasaporte" type="text" class="mt-1 block w-full" wire:model.defer="pasaporte"/>
                        <x-jet-input-error for="pasaporte" class="mt-2" />
                    </div>
                    <div class="col-span-4 sm:col-span-2">
                        <x-jet-label for="fnacimiento" value="{{ __('Fecha de Nacimiento') }}" />
                        <x-jet-input id="fnacimiento" type="date" class="mt-1 block w-full" wire:model.defer="fnacimiento" />
                        <x-jet-input-error for="fnacimiento" class="mt-2" />
                    </div>
                    <div class="col-span-4 sm:col-span-2">
                        <x-jet-label for="campsexo" value="{{ __('Sexo') }}" />
                            <select name="sexo" id="sexo" wire:model.defer="sexo" class="mt-1 block w-full"> 
                                <option value="" selected>Selecciona el Sexo</option>                                                                         
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                            </select> 
                        <x-jet-input-error for="sexo" class="mt-2" />                   
                    </div>
                    <div class="col-span-4 sm:col-span-2">
                        <x-jet-label for="ntelefono" value="{{ __('Numero de Teléfono ') }}" />
                        <x-jet-input id=">nrotelefono" type="text" class="mt-1 block w-full" wire:model.defer="nrotelefono"/>
                        <x-jet-input-error for="nrotelefono" class="mt-2" />
                    </div>                    
                    <div class="col-span-4 sm:col-span-4">
                        <x-jet-label for="direccion" value="{{ __('Dirección') }}" />
                        <x-jet-input id=">direccion" type="text" class="mt-1 block w-full" wire:model.defer="direccion"/>
                        <x-jet-input-error for="direccion" class="mt-2" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingPersonaAdd', false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>
                <x-jet-danger-button class="ml-3" wire:click="savePersona()" wire:loading.attr="disabled">
                    {{ __('Guardar') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>

<!-- Inicio del Modal para mostrar el codigo -->
    <x-jet-dialog-modal wire:model="codigoModal">
        <x-slot name="title">
            {{ __('código') }}
        </x-slot>

        <x-slot name="content">
            <div class="text-center text-9xl">        
                {{$codigo}} 
            </div>   
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('codigoModal', false)" wire:loading.attr="disabled">
                {{ __('Aceptar') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>

