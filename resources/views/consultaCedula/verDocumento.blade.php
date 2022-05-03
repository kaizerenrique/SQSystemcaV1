<x-guest-layout>    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">                                              
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-4 text-2xl">
                        <div class="mt-4 text-2xl flex justify-between">                                                         
                            <div class="mr-2">
                                @if (Route::has('login'))
                                    @auth
                                        <x-jet-button class="bg-indigo-500 hover:bg-indigo-700">
                                            <a href="{{ route('personas') }}">
                                                {{ __('Personas') }}
                                            </a>                                    
                                        </x-jet-button> 
                                    @else                                
                                        <x-jet-button class="bg-indigo-500 hover:bg-indigo-700">
                                            <a href="{{ route('welcome') }}">
                                                {{ __('Inicio') }}
                                            </a>                                    
                                        </x-jet-button>
                                    @endauth 
                                @endif                                                       
                            </div>
                        </div>        
                    </div>

                    <iframe class="w-full max-h-full aspect-auto " ssrc="http://docs.google.com/gview?url={{ asset($url)}}&embedded=true" frameborder="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>