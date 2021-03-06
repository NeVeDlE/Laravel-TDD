@props(['project'])
<div class="bg-white p-5 rounded shadow" style="height: 200px">
    <a href="{{$project->path()}}"><h3
            class="font-normal text-xl py-4 -ml-5 mb-4 border-l-4 border-blue-400 hover:border-blue-800 pl-4">{{$project->title}}</h3>
    </a>
    <div class="text-gray-400 mb-4">{{Str::limit($project->description,100 )}}</div>
    <footer>
        <form method="POST" class="text-right" action="{{$project->path()}}">
            @method('delete')
            @csrf
            <button type="submit" class="text-xs">Delete</button>
        </form>
    </footer>
</div>

