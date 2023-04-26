<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questões') }}
        </h2>
        <form class="ml-auto flex">
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
        @if (session('success'))
            <div
                class="mb-4 rounded-lg bg-green-100 text-green-800 p-4 py-2 max-w-4xl mx-auto sm:px-6 lg:px-8 text-center"
                role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (count($questions) === 0)
                <div class=" mx-auto">
                    <img src="https://cdn-icons-png.flaticon.com/512/1234/1234839.png?w=740&t=st=1682274426~exp=1682275026~hmac=a1bc29342f1fb92b5f7bd7b1efcba0d7507d5bdf10c22cfd07c266574085a53a" class="w-48 h-48  mx-auto" alt="No data available">
                    <p class="text-secondary text-center mt-4">Não há questões cadastradas para listar.</p>
                </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <ul class="w-full divide-y divide-gray-200">
                    @foreach($questions as $question)
                    <a class="py-4 px-4 flex" href="{{ route('question.show', ['id' => $question->id]) }}">
                            <img class="h-10 w-10 rounded-full mr-4" src="https://cdn-icons-png.flaticon.com/512/1168/1168270.png?w=740&t=st=1682446498~exp=1682447098~hmac=845e109d1d315e57de9805776b948d01d59bbe15f5c215aec454b9f34b408d94" alt="">
                            <div>
                            <p class="font-medium">{{ $question->title }}</p>
                            <p class="text-gray-500">{{ $question->question }}</p>
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
