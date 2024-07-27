<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lists</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</head>
<body>
    <div class="mx-auto my-5" style="width: 800px;">
        <h1>POSTED JOBS</h1>

        <hr>
        <form action="/search_job" method="post">
        @csrf
            <label for="category">Category</label>
            <input type="text" name="category" id="category">

            <br>

            <label for="location">Location</label>
            <input type="text" name="location" id="location">

            <br>

            <label for="keyword">Keyword</label>
            <input type="text" name="keyword" id="keyword">

            <br>

            <input type="submit" value="Find Job">
        </form>
        <hr>

        @if(session('data') !== null)
            <div class="row">
                @foreach (session('data') as $job)
                    <div class="col-4">
                        <div class="card my-3">
                            <div class="card-body">
                                <h5 class="card-title">Job ID: {{ $job->id }}</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Job Name: {{ $job->name }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                @foreach ($data as $job)
                    <div class="col-4">
                        <div class="card my-3">
                            <div class="card-body">
                                <h5 class="card-title">Job ID: {{ $job->id }}</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Job Name: {{ $job->name }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>