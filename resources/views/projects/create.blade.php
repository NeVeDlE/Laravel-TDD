<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create a Project
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="/projects" class="text-center flex-col ">
                        @csrf
                        <x-form.input name="title" :value="old('title')"/>
                        <x-form.textarea name="description">{{old('description')}}</x-form.textarea>
                        <div class="mb-6">
                            <x-submit-button>Publish</x-submit-button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
