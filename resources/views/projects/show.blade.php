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

                @foreach($project->tasks as $task)
                    <div class="bg-white p-5 bo rounded shadow w-full mb-3">
                        <form action="{{$task->path()}}" method="POST">
                            @method('patch')
                            @csrf
                            <div class="flex">
                                <input type="text" name="body" value="{{$task->body}} "
                                       class="w-full border-white {{$task->completed ? 'text-gray-400' : ''}}">
                                <input type="checkbox" {{$task->completed ? 'checked' : '' }} name="completed"
                                       onchange="this.form.submit()">
                            </div>
                        </form>
                    </div>

                @endforeach
                <div class="bg-white p-5 rounded shadow w-full mb-3">
                    <form action="{{$project->path().'/tasks'}}" method="POST">
                        @csrf
                        <input type="text" placeholder="Add a new task" class="w-full border-white" name="body">
                    </form>
                </div>

            </div>

            <div class="mb-8">
                <form action="{{$project->path()}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <h2 class="text-gray-400 font-normal text-lg mb-3">General Notes</h2>
                    <textarea class="bg-white p-5 rounded shadow w-full" name="notes"
                              style="min-height: 200px" placeholder="">{{$project->notes}}</textarea>
                    <button class="bg-blue-500 text-white uppercase font-semibold
                            text-xs py-2 px-10 rounded-2xl hover:bg-blue-600">Submit
                    </button>
                </form>
            </div>

        </div>
        <div class="w-1/4 px-3">
            <x-card :project="$project"/>
        </div>
    </div>


</x-app-layout>
