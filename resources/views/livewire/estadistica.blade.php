<div class="p-2 sm:px-20 bg-white border-b border-gray-200">
    <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 lg:grid-cols-3 gap-3 p-8">
        <!-- card-1 -->
        <div class="relative">
            <div class="px-2">
                <div class="flex h-8 w-full rounded-t-lg border-b-2 border-slate-300 bg-slate-100 pl-[90px] shadow-lg">
                    <small class="my-auto items-center text-xs font-light tracking-tight text-slate-400">Numero total de Registros</small>
                </div>
            </div>
            <div class="flex h-12 w-full rounded-lg bg-white pl-[98px] shadow-xl">
                <small class="my-auto text-lg font-medium text-slate-700">{{$historiasTotales}}</small>
            </div>
        </div>
        <!-- card-2 -->
        <div class="relative">
            <div class="px-2">
                <div class="flex h-8 w-full rounded-t-lg border-b-2 border-slate-300 bg-slate-100 pl-[90px] shadow-lg">
                    <small class="my-auto items-center text-xs font-light tracking-tight text-slate-400">Documentos Subidos hoy</small>
                </div>
            </div>
            <div class="flex h-12 w-full rounded-lg bg-white pl-[98px] shadow-xl">
                <small class="my-auto text-lg font-medium text-slate-700">{{$hoy}}</small>
            </div>
        </div>
        <!-- card-3 -->
        <div class="relative">
            <div class="px-2">
                <div class="flex h-8 w-full rounded-t-lg border-b-2 border-slate-300 bg-slate-100 pl-[90px] shadow-lg">
                    <small class="my-auto items-center text-xs font-light tracking-tight text-slate-400">Registros del Día Previo</small>
                </div>
            </div>
            <div class="flex h-12 w-full rounded-lg bg-white pl-[98px] shadow-xl">
                <small class="my-auto text-lg font-medium text-slate-700">{{$ayer}}</small>
            </div>
        </div>
    </div>
</div>

<div class="p-2 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-3">        
        <div class="flex justify-between">            
            <div>
                <input wire:model="buscar" type="search" placeholder="Buscar" class="shadow appearence-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder-indigo-500" name="">
            </div>            
        </div>
        <table class="table-auto w-full mt-6">
            <thead>
                <tr class="bg-indigo-500 text-white">
                    <th class="px-4 py-2">
                        <div class="flex items-center">Nombre</div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">Cedula</div>
                    </th>                    
                    <th class="px-4 py-2">
                        <div class="flex items-center">Código</div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">Nombre de archivo</div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">Fecha y Hora</div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">Acción</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($historials as $historial)
                    <tr>
                        <td class="rounded border px-4 py-2">{{$historial->nombreyapellido}}</td> 
                        <td class="rounded border px-4 py-2">{{$historial->cedula}}</td>                                               
                        <td class="rounded border px-4 py-2">{{$historial->codigo}}</td>
                        <td class="rounded border px-4 py-2">
                            <a href="{{$historial->url_simbol}}" target="_blank">
                                {{$historial->nombreArchivo}}
                            </a>                            
                        </td>
                        <td class="rounded border px-4 py-2">{{$historial->created_at}}</td>
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
</div>
