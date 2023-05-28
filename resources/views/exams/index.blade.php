<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Provas') }}
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
        @if (session('success'))
            <div
                class="mb-4 rounded-lg bg-green-100 text-green-800 p-4 py-2 max-w-4xl mx-auto sm:px-6 lg:px-8 text-center"
                role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (count($exams) === 0)
                <div class=" mx-auto">
                    <img src="https://cdn-icons-png.flaticon.com/512/1234/1234839.png?w=740&t=st=1682274426~exp=1682275026~hmac=a1bc29342f1fb92b5f7bd7b1efcba0d7507d5bdf10c22cfd07c266574085a53a" class="w-48 h-48  mx-auto" alt="No data available">
                    <p class="text-secondary text-center mt-4">Não há provas cadastradas para listar.</p>
                </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <ul class="w-full divide-y divide-gray-200">
                    @foreach($exams as $exam)
                    <li>
                        <a class="py-4 px-4 flex" href="{{ route('exam.show', ['id' => $exam->id]) }}">
                            <img class="h-10 w-10 rounded-full mr-4" src="https://cdn-icons-png.flaticon.com/512/457/457551.png?w=740&t=st=1684983513~exp=1684984113~hmac=2a06e75a0fde7af514e4c8d037d538fd83f66b955b856220a8372cc7840936c3" alt="">
                            <div>
                            <p class="font-medium">{{ $exam->title }}</p>
                            <p class="text-gray-500">{{ \Carbon\Carbon::parse($exam->datetime_start)->format('d/m/Y H:i') }} - {{ \Carbon\Carbon::parse($exam->datetime_end)->format('d/m/Y H:i') }}</p>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            @endif
            </div>
        </div>
    </div>
</x-app-layout>
