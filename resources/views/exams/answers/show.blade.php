<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prova') }}
        </h2>
        <form class="ml-auto flex w-1/4">
            <x-input-search id="search"
                            name="search"
                            aria-label="Search"
                            aria-describedby="button-addon2"/>
        </form>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div
                class="mb-4 rounded-lg bg-green-100 text-green-800 p-4 py-2 max-w-4xl mx-auto sm:px-6 lg:px-8 text-center"
                role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-4 bg-gray-100">
                <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-2xl">
                  <div class="md:flex">
                    <div class="p-8 w-full">
                        <h3 class="block mt-1 text-lg leading-tight font-medium text-black">{{ $exam->title }}</h3>
                        <p class="mt-2 mb-4 text-gray-500" id="cronometro"> </p>
                      <form action="{{ route('exams.grading.update', ['exam' => $exam->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @foreach($answers as $index => $answer)
                        <div class="my-6 w-full"> 
                            <hr>
                            <div class="w-full flex justify-between"> 
                                <p class="mt-4 mb-4 text-gray-500">{{$index + 1}}. {{ $answer->question->question }}</p>
                                <div>
                                     <!-- Inputs para a correção -->
                                    <div class="flex items-center mt-4">
                                        <label class="mr-2">
                                            <input type="radio" name="is_correct[{{$answer->id}}]" value="1" {{ $answer->is_correct ? 'checked' : '' }}>
                                            Correta
                                        </label>
                                        <label>
                                            <input type="radio" name="is_correct[{{$answer->id}}]" value="0" {{ !$answer->is_correct ? 'checked' : '' }}>
                                            Incorreta
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @if($answer->question->isAberta())
                            <textarea disabled name="answer[{{$answer->question->id}}]" class="w-full rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                {{ $answer->answer_text ?? '' }}
                            </textarea>
                            @endif

                            @if($answer->question->isMultiplaEscolha())
                                <ul class="list-group list-group-flush my-4">
                                    @foreach($answer->question->options as $index => $option)
                                        <li class="w-full border-b-2 border-neutral-100 border-opacity-100 py-2 dark:border-opacity-50">
                                            <input disabled type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="answer[{{$answer->question->id}}]" value="{{$option->id}}"
                                                {{ $answer->options->contains('id', $option->id) ? 'checked' : '' }}>
                                            <label class="ml-2"> {{ chr($index + 97) }}) {{ $option->option }} </label>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if($answer->question->isMultiplasRespostas())
                                <ul class="list-group list-group-flush my-4">
                                    @foreach($answer->question->options as $index => $option)
                                        <li class="w-full border-b-2 border-neutral-100 border-opacity-100 py-2 dark:border-opacity-50">
                                            <input disabled type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="answer[{{$answer->question->id}}][]" value="{{$option->id}}"
                                                {{ $answer->options->contains('id', $option->id) ? 'checked' : '' }}>
                                            <label class="ml-2">{{ chr($index + 97) }}) {{ $option->option }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if($answer->question->isVerdadeiroOuFalso())
                                <div class="form-check">
                                    <input disabled type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="answer[{{$answer->question->id}}]" value="1"
                                        {{ $answer->is_true == 1 ? 'checked' : '' }}>
                                    <label class="ml-2 form-check-label">Verdadeiro</label>
                                </div>
                                <div class="form-check">
                                    <input disabled type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="answer[{{$answer->question->id}}]" value="0"
                                        {{ $answer->is_true == 0 ? 'checked' : '' }}>
                                    <label class="ml-2 form-check-label">Falso</label>
                                </div>
                            @endif

                        </div>
                        @endforeach
                      <x-primary-button class="mt-6">
                          {{ __('Salvar Correção') }}
                      </x-primary-button>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>         
    </div>
</x-app-layout>
