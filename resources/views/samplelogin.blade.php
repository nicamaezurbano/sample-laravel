<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/login_post" method="post">
        @csrf
        <label for="email">Email</label>
        <input type="text" name="email" id="email">

        <label for="password">Password</label>
        <input type="text" name="password" id="password">

        <input type="submit" value="login">
    </form>

    @if(session('message'))
        <div class="alert alert-primary">
            {{ session('message') }}
        </div>
    @endif
    <!-- @if(session('error'))
        <div class="alert alert-primary">
            {{ session('error') }}
        </div>
    @endif -->
</body>
</html>