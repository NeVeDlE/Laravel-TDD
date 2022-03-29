<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
</head>
<body>
<h2>Hello</h2>
<ul>
    @forelse($projects as $project)
        <li><a href="{{$project->path()}}">{{$project->title}}</a></li>
    @empty
        <li>No projects yet.</li>
    @endforelse
</ul>

</body>
</html>
