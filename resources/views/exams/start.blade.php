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
                        <h3 class="block mt-1 text-lg leading-tight font-medium text-black">{{ $exam->title }}</h3>
                        <p class="mt-2 mb-4 text-gray-500" id="cronometro"> </p>
                      <form action="{{ route('exam.send', ['id' => $exam->id]) }}" method="POST" id="form_exam">
                        @csrf
                        @foreach($exam->questions as $index => $question)
                        <div class="my-6 w-full"> 
                            <hr>
                            <p class="mt-4 mb-4 text-gray-500">{{$index + 1}}. {{ $question->question }}</p>

                            @if($question->isAberta())
                            <textarea name="answer[{{$question->id}}]" class="w-full rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            </textarea>
                            @endif

                            @if($question->isMultiplaEscolha())
                            <ul class="list-group list-group-flush my-4">
                                @foreach($question->options as $index => $option)
                                <li class="w-full border-b-2 border-neutral-100 border-opacity-100 py-2 dark:border-opacity-50">
                                <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="answer[{{$question->id}}]" value="{{$option->id}}">
                                <label class="ml-2"> {{ chr($index + 97) }}) {{ $option->option }} </label>
                                </li>
                                @endforeach
                            </ul>
                            @endif

                            @if($question->isMultiplasRespostas())
                            <ul class="list-group list-group-flush my-4">
                                @foreach($question->options as $index => $option)
                                  <li class="w-full border-b-2 border-neutral-100 border-opacity-100 py-2 dark:border-opacity-50">
                                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="answer[{{$question->id}}][]" value="{{$option->id}}"> 
                                    <label class="ml-2">{{ chr($index + 97) }}) {{ $option->option }}</label>
                                  </li>
                                @endforeach
                            </ul>
                            @endif

                            @if($question->isVerdadeiroOuFalso())
                            <div class="form-check">
                                <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="answer[{{$question->id}}]" value="1">
                                <label class="ml-2 form-check-label">Verdadeiro</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="answer[{{$question->id}}]" value="0">
                                <label class="ml-2 form-check-label">Falso</label>
                            </div>
                            @endif
                        </div>
                        @endforeach
                        <input hidden name="attempt_id" value="{{ $attempt->id }}">
                      <x-primary-button class="mt-6" id="send_exam">
                          {{ __('Finalizar') }}
                      </x-primary-button>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>         
    </div>

    <div hidden id="pop-up-finalizar-prova" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
      <div class="bg-white rounded-lg p-8">
        <h2 class="text-lg font-bold mb-4">Finalizar prova</h2>
        <p class="mb-4">Você está prestes a finalizar a prova. Deseja continuar?</p>
        <div class="flex justify-end">
          <x-secondary-button id="btn-nao" class="mr-2">
              {{ __('Revisar') }}
          </x-secondary-button>
          <x-primary-button id="btn-sim">
              {{ __('Finalizar') }}
          </x-primary-button>
        </div>
      </div>
    </div>
    <div hidden id="pop-up-tempo-esgotado" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
      <div class="bg-white rounded-lg p-8">
        <h2 class="text-lg font-bold mb-4">Tempo esgotado!</h2>
        <p class="mb-4">O tempo esgotou! A prova está sendo finalizada..</p>
        <div class="flex justify-end">
          <x-primary-button id="btn-ok">
              {{ __('OK') }}
          </x-primary-button>
        </div>
      </div>
    </div>

    <script>
        $('#pop-up-finalizar-prova').hide();
        $('#pop-up-tempo-esgotado').hide();

        var tempo_restante = {{ $exam->time }} * 60; // tempo restante em segundos
      setInterval(function(){
          tempo_restante--;
          var minutos = Math.floor(tempo_restante / 60);
          var segundos = tempo_restante % 60;
          $('#cronometro').text('Tempo restante: ' + minutos + ':' + segundos);
          if (tempo_restante <= 0) {
              clearInterval();
              $('#pop-up-tempo-esgotado').show();
              setTimeout(function() {
                $('#form_exam').submit();
              }, 5000);
            }
      }, 1000);

        $('#btn-ok').click(function() {
            $('#pop-up-tempo-esgotado').hide();
        });

        $('#send_exam').click(function(event) {
            event.preventDefault(); // cancela a submissão do formulário
            $('#pop-up-finalizar-prova').show();
        });

        $('#btn-nao').click(function() {
            $('#pop-up-finalizar-prova').hide();
        });

        $('#btn-sim').click(function() {
            // submeter a prova normalmente
            $('#form_exam').submit();
        });

</script>

</x-app-layout>
