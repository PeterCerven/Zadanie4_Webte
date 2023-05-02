<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
            integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <title>LUL</title>
</head>
<body>
<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Home</a>
        </div>
    </nav>
    <header class="container">
        <h1>Weather APP</h1>
    </header>
    <main class="container">
        <div class="weather row">
                <div class="col-12 col-md-6">
                    <div id="tableInfo" class="card h-100">
                        <h5 class="card-title p-2">Flags</h5>
                        <div class="card-body" style="overflow-y: auto; max-height: 500px;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Country</th>
                                    <th>Flag</th>
                                    <th>City</th>
                                    <th>Visitors</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($locations as $location)
                                    <tr>
                                        <td>{{$location->country}}</td>
                                        <td>
                                            <img src="{{$location->flag}}" class="card-img-top img-fluid"
                                                 alt="{{$location->country}}"
                                                 style="max-width: 50px; max-height: 50px;"
                                            />
                                        </td>
                                        <td>{{$location->city}}</td>
                                        <td>{{$location->numVisitors}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </main>
</div>
</body>

</html>

