<x-app-layout>

    <x-slot name="header">
        <p class="text-gray-500 font-normal text-md">
            <a href="/projects">My Projects </a> / {{$project->title}}
        </p>
    </x-slot>

    <div class="flex -mx-3">
        <div class="w-3/4 px-3">
            <div class="mb-8">
                <h2 class="text-gray-400 font-normal text-lg mb-3">Tasks</h2>
                <div class="bg-white p-5 rounded shadow mb-3">hello</div>
                <div class="bg-white p-5 rounded shadow mb-3">hello</div>
            </div>

            <div class="mb-8">
                <h2 class="text-gray-400 font-normal text-lg mb-3">General Notes</h2>
                <textarea class="bg-white p-5 rounded shadow w-full" style="min-height: 200px"></textarea>
            </div>

        </div>
        <div class="w-1/4 px-3">
            <x-card :project="$project"/>
        </div>
    </div>


</x-app-layout>
