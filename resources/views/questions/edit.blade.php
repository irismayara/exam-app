<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Questão') }}
        </h2>
        <form class="ml-auto flex w-1/4">
            <x-input-search id="search"
                            name="search"
                            aria-label="Search"
                            aria-describedby="button-addon2"/>
        </form>
        
        <x-primary-link class="ml-3" href="{{ route('question.create') }}">
                {{ __('Adicionar Nova') }}
        </x-primary-button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12">
            <form method="POST" action="{{ route('question.update', ['id' => $question->id]) }}">
                @csrf
                @method('PUT')
                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('Título')" />

                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $question->title)" required autofocus autocomplete="title" />

                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Question -->
                <div class="mt-4">
                    <x-input-label for="question" :value="__('Questão')" />

                    <x-text-input id="question" class="block mt-1 w-full" type="text" name="question" :value="old('question', $question->question)" required autofocus autocomplete="question" />

                    <x-input-error :messages="$errors->get('question')" class="mt-2" />
                </div>

                <!-- Course -->
                <div class="mt-4">
                    <x-input-label for="course" :value="__('Disciplina')" />

                    <x-text-input id="course" class="block mt-1 w-full" type="text" name="course" :value="old('course', $question->course)" required autofocus autocomplete="course" />

                    <x-input-error :messages="$errors->get('course')" class="mt-2" />
                </div>

                <!-- Difficulty Level -->
                <div class="my-4">
                    <x-input-label for="difficulty" :value="__('Nível de dificuldade')" />

                    <select data-te-select-init id="difficulty" name="difficulty" class = "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        <option selected disabled>Selecione o nível de dificuldade</option>
                        <option value="1"
                        {{ old('difficulty', $question->difficulty) === 1 ? 'selected' : '' }} >Nível 1</option>
                        <option value="2" 
                        {{ old('difficulty', $question->difficulty) === 2 ? 'selected' : '' }}>Nível 2</option>
                        <option value="3" 
                        {{ old('difficulty', $question->difficulty) === 3 ? 'selected' : '' }}>Nível 3</option>
                        <option value="4" 
                        {{ old('difficulty', $question->difficulty) === 4 ? 'selected' : '' }}>Nível 4</option>
                        <option value="5" 
                        {{ old('difficulty', $question->difficulty) === 5 ? 'selected' : '' }}>Nível 5</option>
                    </select>
                    
                    <x-input-error :messages="$errors->get('difficulty')" class="mt-2" />
                </div>

                <!-- Topic -->
                <div class="mt-4">
                    <x-input-label for="topic" :value="__('Temática')" />

                    <x-text-input id="topic" class="block mt-1 w-full" type="text" name="topic" :value="old('topic', $question->topic)" required autofocus autocomplete="topic" />

                    <x-input-error :messages="$errors->get('topic')" class="mt-2" />
                </div>

                <!-- Tags -->
                <div class="mt-4">
                    <x-input-label for="tags" :value="__('Tags')" />

                    <x-text-input id="tags" class="block mt-1 w-full" type="text" name="tags" :value="old('tags', $question->tags)" required autofocus autocomplete="tags" />

                    <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                </div>

                <!-- Question Type -->
                <div class="my-4">
                    <x-input-label for="type" :value="__('Tipo de questão')" />

                    <select data-te-select-init id="type" name="type" class = "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        <option selected disabled>Selecione o tipo de questão</option>
                        <option value="1" 
                        {{ old('type', $question->type) === 1 ? 'selected' : '' }}>Aberta</option>
                        <option value="2" 
                        {{ old('type', $question->type) === 2 ? 'selected' : '' }}>Múltipla escolha com uma resposta correta</option>
                        <option value="3" 
                        {{ old('type', $question->type) === 3 ? 'selected' : '' }}>Múltipla escolha com mais de uma resposta correta
                        </option>
                        <option value="4"
                        {{ old('type', $question->type) === 4 ? 'selected' : '' }}>Verdadeiro ou falso</option>
                    </select>
                    
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                @if($question->options->count() > 0)
                <fieldset id="options">
                    <div>
                        <!-- Altenativa 1 -->
                        <div>
                            <x-input-label for="option1" :value="__('Alternativa 1')" />

                            <x-text-input id="option1" class="block mt-1 w-full" type="text" name="option[]" 
                            :value="old('option.0', $question->options[0]->option)" required autofocus />

                            <x-input-error :messages="$errors->get('option.0')" class="mt-2" />
                        </div>
                         <!-- Is Correct -->
                        <div class="block mt-2">
                            <label for="is_correct1" class="inline-flex items-center">
                                <input id="is_correct1" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_correct[]" 
                                value="0"
                                {{ $question->options[0]->is_correct == 1 ? 'checked' : '' }} >
                                <span class="ml-2 text-sm text-gray-600">{{ __('Está correta?') }}</span>
                            </label>
                        </div> 
                    </div>
                    <div>
                        <!-- Altenativa 2 -->
                        <div class="mt-4">
                            <x-input-label for="option2" :value="__('Alternativa 2')" />

                            <x-text-input id="option2" class="block mt-1 w-full" type="text" name="option[]" 
                            :value="old('option.1', $question->options[1]->option)" required autofocus />

                            <x-input-error :messages="$errors->get('option.1')" class="mt-2" />
                        </div>
                        <!-- Is Correct -->
                        <div class="block mt-2">
                            <label for="is_correct2" class="inline-flex items-center">
                                <input id="is_correct2" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_correct[]" 
                                value="1"
                                {{ $question->options[1]->is_correct == 1 ? 'checked' : '' }} >
                                <span class="ml-2 text-sm text-gray-600">{{ __('Está correta?') }}</span>
                            </label>
                        </div> 
                    </div>
                    <div>
                        <!-- Altenativa 3 -->
                        <div class="mt-4">
                            <x-input-label for="option3" :value="__('Alternativa 3')" />

                            <x-text-input id="option3" class="block mt-1 w-full" type="text" name="option[]" 
                            :value="old('option.2', $question->options[2]->option)" required autofocus />

                            <x-input-error :messages="$errors->get('option.2')" class="mt-2" />
                        </div>
                        <!-- Is Correct -->
                        <div class="block mt-2">
                            <label for="is_correct3" class="inline-flex items-center">
                                <input id="is_correct3" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_correct[]" 
                                value="2"
                                {{ $question->options[2]->is_correct == 1 ? 'checked' : '' }} >
                                <span class="ml-2 text-sm text-gray-600">{{ __('Está correta?') }}</span>
                            </label>
                        </div> 
                    </div>
                    <div>
                        <!-- Altenativa 4 -->
                        <div class="mt-4">
                            <x-input-label for="option4" :value="__('Alternativa 4')" />

                            <x-text-input id="option4" class="block mt-1 w-full" type="text" name="option[]" 
                            :value="old('option.3', $question->options[3]->option)" required autofocus />

                            <x-input-error :messages="$errors->get('option.3')" class="mt-2" />
                        </div>
                        <!-- Is Correct -->
                        <div class="block mt-2">
                            <label for="is_correct4" class="inline-flex items-center">
                                <input id="is_correct4" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_correct[]" 
                                value="3"
                                {{ $question->options[3]->is_correct == 1 ? 'checked' : '' }} >
                                <span class="ml-2 text-sm text-gray-600">{{ __('Está correta?') }}</span>
                            </label>
                        </div> 
                    </div>
                </fieldset>
                @endif

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
