<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questões') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-4 bg-gray-100">
                <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-2xl">
                  <div class="md:flex">
                    <div class="p-8 w-full">
     
                      <div class="uppercase tracking-wide text-sm text-neutral-800 font-semibold">
                        {{ $question->course }}
                      </div>

                      <a href="#" class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">{{ $question->title }}</a>
                      <p class="mt-2 mb-4 text-gray-500">{{ $question->question }}</p>

                    @php
                        $tags = explode(',', $question->tags);
                    @endphp
                    @foreach($tags as $tag)
                        <span class="text-sm bg-gray-200 text-gray-800 py-1 px-2 rounded-full mr-2 mb-2">{{$tag}}</span>
                    @endforeach

                    <ul class="list-group list-group-flush my-4">
                        @foreach($question->options as $index => $option)
                        <li class="w-full border-b-2 border-neutral-100 border-opacity-100 py-2 dark:border-opacity-50">
                        {{ chr($index + 97) }}) {{ $option->option }}
                        </li>
                        @endforeach
                    </ul>

                    <div class="w-full mt-4 flex items-center justify-between">
                        <small class="text-gray-400 flex">Criado por: {{ $user->name }}</small>
                        <small class="text-gray-400 flex">Atualizado em: {{ \Carbon\Carbon::parse($question->updated_at)->format('d/m/Y')}}</small>
                    </div>

                      <div class="mt-4 flex items-center justify-between">
                        <a href="{{ route('question.edit', ['id' => $question->id]) }}" class="text-indigo-500 hover:text-indigo-700">Editar</a>
                        <form action="{{ route('question.destroy', ['id' => $question->id]) }}" method="POST">
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
