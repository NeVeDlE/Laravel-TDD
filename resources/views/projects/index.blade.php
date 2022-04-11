<x-app-layout>
    <x-slot name="header" class="flex items-center inline">

        <div class="flex justify-between items-end mb-3 text-center my-2">
            <h2 class="text-gray-500 font-normal text-sm">My Projects</h2>
            <button
                class="bg-blue-500 text-white uppercase font-semibold text-xs py-2 px-10 rounded-2xl hover:bg-blue-600">
                <a href="/projects/create" class="text-white">New Project</a>
            </button>
        </div>
    </x-slot>


    <div class="flex flex-wrap -mx-3 ">

        @forelse($projects as $project)

            <div class="w-1/3 px-3 pb-6">
                <x-card :project="$project"/>

            </div>

        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
</x-app-layout>
