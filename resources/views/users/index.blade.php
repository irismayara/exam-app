<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuários') }}
        </h2>
        <form class="ml-auto flex">
            <x-input-search id="search"
                            name="search"
                            aria-label="Search"
                            aria-describedby="button-addon2"/>
        </form>
        
        <x-primary-link class="ml-3" href="{{ route('user.create') }}">
                {{ __('Adicionar Novo') }}
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
        <div class="max-w-4xl overflow-hidden mx-auto sm:px-6 lg:px-8">
            @if (count($users) === 0)
                <div class=" mx-auto">
                    <img src="https://cdn-icons-png.flaticon.com/512/1234/1234839.png?w=740&t=st=1682274426~exp=1682275026~hmac=a1bc29342f1fb92b5f7bd7b1efcba0d7507d5bdf10c22cfd07c266574085a53a" class="w-48 h-48  mx-auto" alt="No data available">
                    <p class="text-secondary text-center mt-4">Não há usuários cadastrados para listar.</p>
                </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <ul class="w-full divide-y divide-gray-200">
                    @foreach($users as $user)
                    <li>
                        <a class="py-4 px-4 flex" href="{{ route('user.show', ['id' => $user->id]) }}">
                            <img class="h-10 w-10 rounded-full mr-4" src="https://cdn-icons-png.flaticon.com/512/258/258375.png?w=740&t=st=1682281759~exp=1682282359~hmac=92c4d2de64d1598d61fc15b9001afec225af7428c87b45dbd865dae00be6595a" alt="">
                            <div>
                            <p class="font-medium">{{ $user->name }}</p>
                            <p class="text-gray-500">{{ $user->email }}</p>
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
