<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
</head>
<body>
<h2>Create A Project</h2>
<form method="POST" action="/projects">
    @csrf
    <div class="control">
        <label for="title">Title
            <input type="text" class="input" name="title" placeholder="Title">
        </label>
    </div>
    <div class="control">
        <label for="description">Description
            <textarea type="text" class="input" name="description" placeholder="Title"></textarea>
        </label>
    </div>
    <div class="control">
        <button type="submit">Submit</button>
    </div>
</form>

</body>
</html>
