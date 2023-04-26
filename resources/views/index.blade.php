<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Início') }}
        </h2>
        <form class="ml-auto flex w-1/4">
            <x-input-search id="search"
                            name="search"
                            aria-label="Search"
                            aria-describedby="button-addon2"/>
        </form>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="container mx-auto max-w-2xl">
                <div class="flex items-center" >
                    <img src="https://img.freepik.com/vetores-gratis/estudante-com-laptop-estudando-no-curso-on-line_74855-5293.jpg?w=826&t=st=1682274955~exp=1682275555~hmac=62954d774d4b384889b19e956170bbcaee6e34613854c04bad0bfb1fbf0f0222" alt="study">
                </div>
                <div class="flex items-center p-4 mb-5">
                    <div  class="text-center">
                        <h3 class="text-3xl font-bold">Exam App</h3>
                        <p class="text-lg">Maximize a eficiência e praticidade das suas avaliações com o nosso sistema de provas online! Crie, gerencie e aplique exames com facilidade e segurança, tudo isso com uma interface amigável.
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
