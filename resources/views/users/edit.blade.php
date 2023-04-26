<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuário') }}
        </h2>
        <form class="ml-auto flex w-1/4">
            <x-input-search id="search"
                            name="search"
                            aria-label="Search"
                            aria-describedby="button-addon2"/>
        </form>
        
        <x-primary-link class="ml-3" href="{{ route('user.create') }}">
                {{ __('Adicionar Novo') }}
        </x-primary-button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12">
            <form method="POST" action="{{ route('user.update', ['id' => $user->id]) }}">
                @csrf
                @method('PUT')
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />

                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />

                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- IE -->
                <div class="mt-4">
                    <x-input-label for="ie" :value="__('Instituição de Ensino')" />

                    <x-text-input id="ie" class="block mt-1 w-full" type="text" name="ie" :value="old('ie', $user->ie)" required autofocus autocomplete="ie" />

                    <x-input-error :messages="$errors->get('ie')" class="mt-2" />
                </div>

                <!-- User Type -->
                <div class="my-4">
                    <x-input-label for="type" :value="__('Instituição de Ensino')" />

                    <select data-te-select-init id="type" name="type" class = "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        <option selected disabled>Selecione o tipo de usuário</option>
                        <option value="Aluno" 
                            {{ old('type', $user->type) == 'Aluno' ? 'selected' : '' }}>Aluno
                        </option>
                        <option value="Professor" 
                            {{ old('type', $user->type) == 'Professor' ? 'selected' : '' }}>Professor
                        </option>
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
