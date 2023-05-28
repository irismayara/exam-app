<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Turma') }}
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
                            <div class="flex justify-between"> 
                                <div>
                                    @can('create', App\Models\ClassModel::class)
                                    <span class="uppercase tracking-wide text-sm text-neutral-800 font-semibold">
                                        {{ $class->code }}
                                    </span>
                                    @endcan
                                    <h3 class="block mt-1 text-lg leading-tight font-medium text-black ">{{ $class->name }}</h3>
                                </div>  

                                @can('create', App\Models\ClassModel::class)
                                <x-primary-link href="{{ route('classes.showAssignExamForm', ['class' => $class->id]) }}">
                                        {{ __(' Atribuir prova') }}
                                </x-primary-button>
                                @endcan
                            </div>  

                                <div class="my-8">
                                    <h4 class="font-medium text-lg">Provas</h4>
                                    @if ($class->exams->count() > 0)
                                        <ul class="w-full divide-y divide-gray-200">
                                            @foreach ($class->exams as $exam)
                                            <li>
                                            @can('listAnswersByClass', $class)
                                                <a class="py-4 px-4 flex"
                                                 href="{{ route('exams.answers.byclass', ['exam' => $exam->id, 'class' => $class->id]) }}">
                                            @else
                                            <a class="py-4 px-4 flex"
                                                 href="{{ route('exam.show', ['id' => $exam->id]) }}">
                                            @endcan
                                                    <img class="h-10 w-10 rounded-full mr-4" src="https://cdn-icons-png.flaticon.com/512/457/457551.png?w=740&t=st=1684983513~exp=1684984113~hmac=2a06e75a0fde7af514e4c8d037d538fd83f66b955b856220a8372cc7840936c3" alt="">
                                                    <div>
                                                    <p class="font-medium">{{ $exam->title }}</p>
                                                    <p class="text-gray-500">{{ \Carbon\Carbon::parse($exam->datetime_start)->format('d/m/Y H:i') }} - {{ \Carbon\Carbon::parse($exam->datetime_end)->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-sm text-center">Não há provas disponíveis para esta turma.</p>
                                    @endif
                                </div>
                                <hr>
                                <div class="my-8">
                                    <h4 class="font-medium text-lg">Participantes</h4>
                                    @if ($class->participants->count() > 0)
                                        <ul class="w-full divide-y divide-gray-200">
                                            @foreach ($class->participants as $participant)
                                            <li class="py-4 px-4 flex">
                                                    <img class="h-10 w-10 rounded-full mr-4" src="https://cdn-icons-png.flaticon.com/512/258/258375.png?w=740&t=st=1682281759~exp=1682282359~hmac=92c4d2de64d1598d61fc15b9001afec225af7428c87b45dbd865dae00be6595a" alt="">
                                                    <div>
                                                    <p class="font-medium">{{ $participant->name }}</p>
                                                    <p class="text-gray-500">{{ $participant->email }}</p>
                                                    </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-sm text-center">Não há participantes nesta turma.</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>