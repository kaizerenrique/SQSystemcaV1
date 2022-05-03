<x-guest-layout>    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">                                              
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="w-80 bg-white shadow rounded bg-indigo-500 text-white text-xl font-bold">
                        <h2 class="px-4 py-2">
                            {{$nombre}}
                        </h2>
                        <h2 class="px-4 py-2">
                            {{$cedula}}
                        </h2> 
                    </div>                     
                    <table class="md:table-fixed table-auto w-full mt-6">
                        <thead>
                            <tr class="bg-indigo-500 text-white">                                                      
                                <th class="px-4 py-2">
                                    <div class="flex items-center">Fecha</div>
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
                                    <td class="rounded border px-4 py-2">{{$historial->created_at}}</td>                                        
                                    <td class="rounded border px-4 py-2">{{$historial->nombreLaboratorio}}</td> 
                                    <td class="rounded border px-4 py-2">                                        
                                        <x-jet-button class="bg-green-500 hover:bg-green-700">
                                            <a href="{{ route('consulta.verDocumento', $historial->nombreArchivo)}}" target="_blank">
                                                {{ __('Ver') }}
                                            </a>                                
                                        </x-jet-button>                                                                 
                                    </td>                       
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>