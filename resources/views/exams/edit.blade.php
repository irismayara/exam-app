<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Prova') }}
        </h2>
        <form class="ml-auto flex w-1/4">
            <x-input-search id="search"
                            name="search"
                            aria-label="Search"
                            aria-describedby="button-addon2"/>
        </form>
        
        <x-primary-link class="ml-3" href="{{ route('exam.create') }}">
                {{ __('Adicionar Nova') }}
        </x-primary-button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12">
            <form method="POST" action="{{ route('exam.update', ['id' => $exam->id]) }}">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('Titulo')" />

                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $exam->title)" required autofocus autocomplete="title" />

                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Date start -->
                <div class="mt-4">
                    <x-input-label for="datetime_start" :value="__('Data de início')" />

                    <x-text-input id="datetime_start" class="block mt-1 w-full" type="datetime-local" name="datetime_start" :value="old('datetime_start', $exam->datetime_start)" required />

                    <x-input-error :messages="$errors->get('datetime_start')" class="mt-2" />
                </div>

                <!-- Date end -->
                <div class="mt-4">
                    <x-input-label for="datetime_end" :value="__('Data de término')" />

                    <x-text-input id="datetime_end" class="block mt-1 w-full" type="datetime-local" name="datetime_end" :value="old('datetime_end', $exam->datetime_end)" required />

                    <x-input-error :messages="$errors->get('datetime_end')" class="mt-2" />
                </div>

                <!-- Duration time -->
                <div class="mt-4">
                    <x-input-label for="time" :value="__('Duração em minutos')" />

                    <x-text-input id="time" class="block mt-1 w-full" type="number" name="time" :value="old('time', $exam->time)" required autofocus />

                    <x-input-error :messages="$errors->get('time')" class="mt-2" />
                </div>

                <!-- Questions select -->
                <div class="mt-4">
                    <x-input-label for="questions" :value="__('Questões')" />

                    <select data-te-select-init id="questions" name="questions[]" class = "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" multiple>
                    @foreach($questions as $question)
                        <option value="{{ $question->id }}" {{ $exam->questions->contains($question->id) ? 'selected' : '' }}>
                            {{ $question->title }}
                        </option>
                    @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('questions[]')" class="mt-2" />
                </div>

                

                <x-secondary-button class="mt-6">
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
