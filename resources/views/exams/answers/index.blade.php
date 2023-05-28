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

                      <h3 class="block mt-1 text-lg leading-tight font-medium text-black ">{{ $exam->title }}</h3>
                      <p class="mt-2 text-gray-500">Inicia em: {{ \Carbon\Carbon::parse($exam->datetime_start)->format('d/m/Y H:i') }}</p>
                      <p class="mt-1 mb-4 text-gray-500">Finaliza em: {{ \Carbon\Carbon::parse($exam->datetime_end)->format('d/m/Y H:i') }}</p>
                      <p class="mt-1 mb-4 text-gray-500">Duração: {{ $exam->time }} minutos</p>


                      <div class="w-full mt-4 flex items-center justify-between">
                      <small class="text-gray-400 flex">Criada por: {{ $exam->createdBy->name }}</small>
                        <small class="text-gray-400 flex">Atualizada em: {{ \Carbon\Carbon::parse($exam->updated_at)->format('d/m/Y')}}</small>
                    </div>

                    @canany(['update', 'delete'], $exam)
                      <div class="mt-6 flex items-center justify-between mb-8">
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

                    <hr>
                    <div class="my-8">
                        <h4 class="font-medium text-lg">Respostas</h4>
                        @if ($users->count() > 0)
                            <ul class="w-full divide-y divide-gray-200">
                                @foreach ($users as $user)
                                <li>
                                    <a class="py-4 px-4 flex" href="{{ route('exams.grading.edit', ['exam' => $exam->id, 'user' => $user->id]) }}">
                                        <img class="h-10 w-10 rounded-full mr-4" src="https://cdn-icons-png.flaticon.com/512/258/258375.png?w=740&t=st=1682281759~exp=1682282359~hmac=92c4d2de64d1598d61fc15b9001afec225af7428c87b45dbd865dae00be6595a" alt="">
                                        <div>
                                            <p class="font-medium">{{ $user->name }}</p>
                                            <p class="text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-center">Não há respostas nesta prova.</p>
                        @endif
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
