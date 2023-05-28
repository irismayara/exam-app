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
                            </div>  
                            <form action="{{ route('classes.assignExam', ['class' => $class->id]) }}" method="POST">
                                @csrf

                                <!-- Exam select -->
                                <div class="mt-4">
                                <x-input-label for="exam" :value="__('Prova')" />
                                <select id="exam" name="exam" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                    @foreach ($exams as $exam)
                                        <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('exam')" class="mt-2" />

                                <x-primary-button class="mt-4">
                                    {{ __('Atribuir Prova') }}
                                </x-primary-button>
                            </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>