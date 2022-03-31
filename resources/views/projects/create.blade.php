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
                        <div class="mb-4">
                            <label for="title">Title </label>
                            <input type="text" class="input" name="title" placeholder="Title">

                        </div>
                        <div class="mb-4">
                            <label for="description">Description </label>
                            <textarea type="text" class="input" name="description" placeholder="Title"></textarea>

                        </div>
                        <div class="mb-4">
                            <button type="submit" class="bg-gray-100">Submit</button>
                        </div>
                        <div class="mb-4">
                            <a href="/projects">back to projects</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
