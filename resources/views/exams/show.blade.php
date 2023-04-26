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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-4 bg-gray-100">
                <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-2xl">
                  <div class="md:flex">
                    <div class="p-8 w-full">

                      <a href="#" class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">{{ $exam->title }}</a>
                      <p class="mt-2 mb-4 text-gray-500">Duração: {{ $exam->time }} minutos</p>

                    @foreach($exam->questions as $question)
                    <div class="my-6 w-full"> 
                        <hr>
                        <p class="mt-4 mb-4 text-gray-500">{{ $question->question }}</p>
                        <ul class="list-group list-group-flush my-4">
                            @foreach($question->options as $index => $option)
                            <li class="w-full border-b-2 border-neutral-100 border-opacity-100 py-2 dark:border-opacity-50">
                            {{ chr($index + 97) }}) {{ $option->option }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach

                      <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('exam.edit', ['id' => $exam->id]) }}" class="text-indigo-500 hover:text-indigo-700">Editar</a>
                        <form action="{{ route('exam.destroy', ['id' => $exam->id]) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-red-500 hover:text-red-700">Excluir</button>
                        </form>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
            
    </div>
</x-app-layout>
