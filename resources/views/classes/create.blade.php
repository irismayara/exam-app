<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Turma') }}
        </h2>
        <form class="ml-auto flex w-1/4">
            <x-input-search id="search"
                            name="search"
                            aria-label="Search"
                            aria-describedby="button-addon2"/>
        </form>
        
        <x-primary-link class="ml-3" href="{{ route('classes.create') }}">
                {{ __('Adicionar Nova') }}
        </x-primary-button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12">
            <form method="POST" action="{{ route('classes.store') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nome')" />

                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Class Type -->
                <div class="my-4">
                    <x-input-label for="type" :value="__('Tipo')" />

                    <select data-te-select-init id="type" name="type" class = "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        <option selected disabled>Selecione o nível de privacidade da turma</option>
                        <option value="private" 
                        {{ old('type') == 'private' ? 'selected' : '' }}>Privada</option>
                        <option value="public" 
                        {{ old('type') == 'public' ? 'selected' : '' }}>Pública</option>
                    </select>
                    
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <x-secondary-button class="mt-4">
                    {{ __('Cancelar') }}
                </x-secondary-button>
                <x-primary-button class="ml-4">
                    {{ __('Salvar') }}
                </x-primary-button>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>
