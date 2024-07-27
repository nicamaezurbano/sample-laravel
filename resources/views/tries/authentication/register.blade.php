<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<body>
    <div class="mx-auto my-5" style="width: 600px;">
        <h1>Register</h1>

        @if(session('message'))
            <div class="alert alert-{{ session('status') }}">
                {{ session('message') }}
            </div>
        @endif

        <!-- FORM -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="/create_account" method="post">
                    @csrf
                    <div class="row">
                        <div class="col col-12">
                            <div class="mb-3">
                                <label for="firstname" class="form-label m-0">First Name:</label>
                                <input type="text" name="first_name" id="firstname" class="form-control" required>
                            </div>
                        </div>
                        <div class="col col-12">
                            <div class="mb-3">
                                <label for="lastname" class="form-label m-0">Last Name:</label>
                                <input type="text" name="last_name" id="lastname" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-12">
                            <div class="mb-3">
                                <label for="email" class="form-label m-0">Email:</label>
                                <input type="text" name="email" id="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col col-12">
                            <div class="mb-3">
                                <label for="password" class="form-label m-0">Password:</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-12 d-flex justify-content-end">
                            <input type="submit" value="Create Account" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>