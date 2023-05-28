<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Turmas') }}
        </h2>
        <form class="ml-auto flex w-1/4">
            <x-input-search id="search"
                            name="search"
                            aria-label="Search"
                            aria-describedby="button-addon2"/>
        </form>
        @can('create', App\Models\ClassModel::class)
        <x-primary-link href="{{ route('classes.create') }}">
                {{ __('Adicionar Nova') }}
        </x-primary-button>
        @endcan
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
            @if (count($classes) === 0)
                <div class=" mx-auto">
                    <img src="https://cdn-icons-png.flaticon.com/512/1234/1234839.png?w=740&t=st=1682274426~exp=1682275026~hmac=a1bc29342f1fb92b5f7bd7b1efcba0d7507d5bdf10c22cfd07c266574085a53a" class="w-48 h-48  mx-auto" alt="No data available">
                    <p class="text-secondary text-center mt-4">Não há turmas para listar.</p>
                </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <ul class="w-full divide-y divide-gray-200">
                    @foreach($classes as $class)
                    <li>
                        <a class="py-4 px-4 flex" href="{{ route('classes.show', ['id' => $class->id]) }}">
                            <img class="h-10 w-10 rounded-full mr-4" src="https://cdn-icons-png.flaticon.com/512/718/718339.png?w=740&t=st=1685115802~exp=1685116402~hmac=51ed2178d2879eff5eff723a12237391ce002b0dba9ff431c794d7242f5eff9f" alt="">
                            <div>
                            <p class="font-medium">{{ $class->name }}</p>
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
