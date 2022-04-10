<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit a Project
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{$project->path()}}" class="text-center flex-col ">
                        @csrf
                        @method('PATCH')
                        <x-form.input class="mx-auto w-auto" name="title" :value="$project->title"/>
                        <x-form.textarea class="w-auto" name="description">{{$project->description}}</x-form.textarea>
                        <div class="mb-6">
                            <x-submit-button>Update Project</x-submit-button>
                            <a href="{{$project->path()}}">Cancel</a>
                        </div>

                    </form>
                </div>
                @if($errors->any())
                    <div class="text-red-600 font-normal text-lg mb-3">
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </div>
                @endif

            </div>

        </div>
    </div>


</x-app-layout>
