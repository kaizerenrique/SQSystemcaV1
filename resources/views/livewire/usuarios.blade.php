<div class="p-2 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-4 text-2xl">
        <div class="mt-4 mb-4 text-2xl flex justify-between">
            <div>Total de Usuarios Registrados: {{$users_count}} </div>
            <div class="mr-2">
                <x-jet-button class="bg-indigo-500 hover:bg-indigo-700" wire:click="laboratorioAdd" >
                    {{ __('Registrar Laboratorio') }}
                </x-jet-button>
            </div>
        </div>        
    </div>
    
    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">        
        <div class="flex justify-between">            
            <div>
                <input wire:model="buscar" type="search" placeholder="Buscar" class="shadow appearence-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder-indigo-500" name="">
            </div>            
        </div>
        <table class="table-auto w-full mt-6">
            <thead>
                <tr class="bg-indigo-500 text-white">
                    <th class="px-4 py-2">
                        <div class="flex items-center">Foto</div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">ID</div>
                    </th>                     
                    <th class="px-4 py-2">
                        <div class="flex items-center">Nombre</div>
                    </th>                 
                    <th class="px-4 py-2">
                        <div class="flex items-center">Correo</div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">Rol</div>
                    </th>                  
                    <th class="px-4 py-2">
                        <div class="flex items-center">Acción</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td class="rounded border px-4 py-2">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $usuario->profile_photo_url }}" alt="{{ $usuario->name }}" />
                        </td>
                        <td class="rounded border px-4 py-2">{{$usuario->id}}</td>
                        <td class="rounded border px-4 py-2">{{$usuario->name}}</td>
                        <td class="rounded border px-4 py-2">{{$usuario->email}}</td>
                        <td class="rounded border px-4 py-2">
                            @foreach($usuario->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </td>                                            
                        <td class="rounded border px-4 py-2">
                            <x-jet-button class="bg-green-500 hover:bg-green-700" wire:click="confirmPersonaVer({{$usuario->id}})" >
                                {{ __('Ver') }}
                            </x-jet-button>
                        <!-- Boton Editar
                            <x-jet-button class="bg-blue-500 hover:bg-blue-700" wire:click="confirmPersonaEditar({{$usuario->id}})" >
                                {{ __('Editar') }}
                            </x-jet-button>  
                        -->                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{$usuarios->links()}}
    </div>
<!-- Inicio del Modal para ver datos de usuario -->
    <x-jet-dialog-modal wire:model="confirmingPersonaVer">
        <x-slot name="title">
            {{ __('Ver') }}
        </x-slot>
        <x-slot name="content">             
            <div class="grid grid-cols-4 gap-4 text-sm text-gray-600">
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="name" value="{{ __('Nombre') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" disabled/>
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="email" value="{{ __('Correo electrónico') }}" />
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email"  disabled/>
                    <x-jet-input-error for="email" class="mt-2" />
                </div> 
                
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="rolUsuario" value="{{ __('Rol') }}" />
                    <x-jet-input id="rol" type="text" class="mt-1 block w-full" wire:model.defer="rol"  disabled/>
                    <x-jet-input-error for="rol" class="mt-2" />
                </div> 
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="fechaRegistro" value="{{ __('Fecha de Registro') }}" />
                    <x-jet-input id="fechaReg" type="text" class="mt-1 block w-full" wire:model.defer="fechaReg"  disabled/>
                    <x-jet-input-error for="fechaReg" class="mt-2" />
                </div>                                            
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingPersonaVer', false)" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
<!-- Fin del Modal para ver datos de usuario -->

<!-- Inicio del Modal para Editar datos de usuario -->
    <x-jet-dialog-modal wire:model="confirmingPersonaEditar">
        <x-slot name="title">
            {{ __('Editar') }}
        </x-slot>
        <x-slot name="content">             
            <div class="grid grid-cols-4 gap-4 text-sm text-gray-600">
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="name" value="{{ __('Nombre') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" disabled/>
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="email" value="{{ __('Correo electrónico') }}" />
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email"  disabled/>
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="rolUsuario" value="{{ __('Rol') }}" />
                    <select name="rol" id="rol" wire:model.defer="rol" class="mt-1 block w-full">
                        <option value="" selected>Seleccionar Rol</option>
                        @foreach ($roles as $role)                            
                            <option value="{{ $role->id }}">{{ $role->name }}</option>                            
                        @endforeach                        
                    </select>                    
                </div> 
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="fechaRegistro" value="{{ __('Fecha de Registro') }}" />
                    <x-jet-input id="fechaReg" type="text" class="mt-1 block w-full" wire:model.defer="fechaReg"  disabled/>
                    <x-jet-input-error for="fechaReg" class="mt-2" />
                </div>                                            
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingPersonaEditar', false)" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
<!-- Fin del Modal para Editar datos de usuario -->

<!-- Inicio del Modal para Registrar Laboratorio -->
    <x-jet-dialog-modal wire:model="agregarLaboratorio">
        <x-slot name="title">
            {{ __('Registrar Laboratorio') }}
        </x-slot>
        <x-slot name="content">             
            <div class="grid grid-cols-4 gap-4 text-sm text-gray-600">
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="name" value="{{ __('Nombre') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name"/>
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="email" value="{{ __('Correo electrónico') }}" />
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email" />
                    <x-jet-input-error for="email" class="mt-2" />
                </div>                                          
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('agregarLaboratorio', false)" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-jet-secondary-button>
            <x-jet-danger-button class="ml-3" wire:click="guardarLaboratorio()" wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
<!-- Fin del Modal para Registrar Laboratorio -->

<!-- Inicio del Modal para Laboratorio Registrado Correctamente  -->
    <x-jet-dialog-modal wire:model="mostrarTokenApi">
        <x-slot name="title">
            {{ __('Laboratorio Registrado Correctamente ') }}
        </x-slot>
        <x-slot name="content">             
            
                <div class="col-span-4 sm:col-span-2">
                    <x-jet-label for="token" value="{{ __('Token para la API') }}" />
                    <x-jet-input id="token" type="text" class="mt-1 block w-full" wire:model.defer="token" disabled/>
                    <x-jet-input-error for="token" class="mt-2" />
                </div>                                                      
            
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('mostrarTokenApi', false)" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
<!-- Fin del Modal para Laboratorio Registrado Correctamente  -->
</div>
