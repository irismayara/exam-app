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

                                <h3 class="block mt-1 text-lg leading-tight font-medium text-black ">Entrar em {{ $class->name }}</h3>

                                <form action="{{ route('classes.join', ['id' => $class->id]) }}" method="POST">
                                    @csrf

                                    @if ($class->isPrivate())
                                    <div class="mt-4">
                                        <label for="code" class="font-medium">Digite o código da turma:</label>
                                        <input type="text" id="code" name="code" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full mt-1">
                                    </div>
                                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                                    @endif

                                    <div class="mt-6">
                                    <x-primary-button>
                                        {{ __('Entrar') }}
                                    </x-primary-button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
