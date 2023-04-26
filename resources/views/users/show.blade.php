<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuários') }}
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
                      
                      <div class="uppercase tracking-wide text-sm text-neutral-800 font-semibold">
                        {{ $user->type }}
                      </div>

                      <a href="#" class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">{{ $user->name }}</a>
                      <p class="mt-2 text-gray-500">{{ $user->email }}</p>
                      <p class="mt-2 text-gray-500">{{ $user->ie }}</p>

                      <div class="mt-4 flex items-center justify-between">
                        <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="text-indigo-500 hover:text-indigo-700">Editar</a>
                        <form action="{{ route('user.destroy', ['id' => $user->id]) }}" method="POST">
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
