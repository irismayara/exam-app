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
                      <p class="mt-2 text-gray-500">Inicia em: {{ \Carbon\Carbon::parse($exam->datetime_start)->format('d/m/Y H:i') }}</p>
                      <p class="mt-1 mb-4 text-gray-500">Finaliza em: {{ \Carbon\Carbon::parse($exam->datetime_end)->format('d/m/Y H:i') }}</p>
                      <p class="mt-1 mb-4 text-gray-500">Duração: {{ $exam->time }} minutos</p>


                      <div class="w-full mt-4 flex items-center justify-between">
                        <small class="text-gray-400 flex">Criada por: {{ $user->name }}</small>
                        <small class="text-gray-400 flex">Atualizada em: {{ \Carbon\Carbon::parse($exam->updated_at)->format('d/m/Y')}}</small>
                    </div>

                    @canany(['update', 'delete'], $exam)
                      <div class="mt-6 flex items-center justify-between">
                      @can('update', $exam)
                        <a href="{{ route('exam.edit', ['id' => $exam->id]) }}" class="text-indigo-500 hover:text-indigo-700">Editar</a>
                      @endcan

                      @can('delete', $exam)
                        <form action="{{ route('exam.destroy', ['id' => $exam->id]) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-red-500 hover:text-red-700">Excluir</button>
                        </form>
                      @endcan
                      </div>
                    @endcanany

                    @can('start', $exam)
                      <x-primary-link class="mt-6" href="{{ route('exam.start', ['id' => $exam->id]) }}">
                        {{ __('Iniciar') }}
                      </x-primary-button>
                    @endcan

                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
            
    </div>
</x-app-layout>
