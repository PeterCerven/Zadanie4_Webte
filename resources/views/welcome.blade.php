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
    <header class="container">
        <h1>Weather APP</h1>
    </header>
    <nav class="container">
        <div class="row align-items-end py-2">
            <div class="col-sm">
                <form method="POST" action="/locations">
                    @csrf
                    <div class="input-group col-sm">
                        <span class="input-group-text" id="basic-addon1">Lat</span>
                        <input
                            type="text"
                            class="form-control"
                            inputmode="numeric"
                            name="latitude"
                            id="latitude"
                            placeholder="latitude"
                            aria-label="latitude"
                            aria-describedby="basic-addon1"
                            value="42.98"
                        />
                    </div>
                    <div class="input-group col-sm">
                        <span class="input-group-text" id="basic-addon1">Lon</span>
                        <input
                            type="text"
                            class="form-control"
                            inputmode="numeric"
                            id="longitude"
                            name="longitude"
                            placeholder="longitude"
                            aria-label="longitude"
                            aria-describedby="basic-addon1"
                            value="-81.23"
                        />
                    </div>
                    <button id="btnGet" type="submit" class="btn btn-primary mb-3">
                        Get Weather by Lat/Long
                    </button>
                </form>
            </div>
            <div class="col-3">
                <form method="POST" action="/locations">
                    @csrf
                    <div class="input-group col-sm">
                        <span class="input-group-text" id="basic-addon1">City</span>
                        <input
                            type="text"
                            class="form-control"
                            inputmode="numeric"
                            id="cityName"
                            placeholder="City"
                            aria-label="latitude"
                            aria-describedby="basic-addon1"
                            value="London"
                        />
                    </div>
                    <button id="btnGet" type="submit" class="btn btn-primary mb-3">
                        Get Weather by City Name
                    </button>
                </form>
            </div>
            <div class="col">
                <form action="">
                    @csrf
                    <button id="btnCurrent" type="button" class="btn btn-primary mb-3">
                        Use Current Location
                    </button>
                </form>
            </div>
        </div>

    </nav>
    <main class="container">
        <div class="weather row d-flex align-items-stretch">
            @unless($locationWeather == null)
                <div class="col-6">
                    <div class="row">
                        <div id="weather" class="col-6">
                            <div class="card">
                                <h5 class="card-title p-2">{{$locationWeather->time}}</h5>
                                <img
                                    src="{{$locationWeather->weather_image}}"
                                    class="card-img-top"
                                    alt="{{$locationWeather->weather_name}}"
                                />
                                <div class="card-body">
                                    <h3 class="card-title">{{$locationWeather->weather_name}}</h3>
                                    <p class="card-text">Temperature: {{$locationWeather->temperature}}&deg;C</p>
                                    <p class="card-text">Humidity: {{$locationWeather->humidity}}%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div id="weatherInfo" class="row">
                                <div class="card">
                                    <h5 class="card-title p-2">Weather Info</h5>
                                    <div class="card-body">
                                        <p class="card-text">Latitude: {{$locationWeather->latitude}}</p>
                                        <p class="card-text">Longitude: {{$locationWeather->longitude}}</p>
                                        <p class="card-text">Country: {{$locationWeather->country}}</p>
                                        <p class="card-text">Capital: {{$locationWeather->capital}}</p>
                                    </div>
                                </div>
                            </div>
                            <div id="timeData" class="row">
                                <div class="card">
                                    <h5 class="card-title p-2">Visits</h5>
                                    <div class="card-body">
                                        <canvas id="myChart" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-6">
                    <div class="row">
                        <div id="weather" class="col-6">
                            <div class="card">
                                <h5 class="card-title p-2">Weather</h5>

                            </div>
                        </div>
                        <div class="col-6">
                            <div id="weatherInfo" class="row">
                                <div class="card">
                                    <h5 class="card-title p-2">Weather Info</h5>
                                </div>
                            </div>
                            <div id="timeData" class="row">
                                <div class="card">
                                    <h5 class="card-title p-2">Visits</h5>
                                    <div class="card-body">
                                        <canvas id="myCharts" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endunless
            @unless($locations->isEmpty())
                <div class="col-6">
                    <div class="row h-100">
                        <div id="tableInfo" class="col-12">
                            <div class="card">
                                <h5 class="card-title p-2">Flags</h5>
                                <div class="card-body">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>Country</th>
                                            <th>Flag</th>
                                            <th>Visitors</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($locationsCount as $location)
                                            <tr>
                                                <td>{{$location->country}}</td>
                                                <td>
                                                    <img
                                                        src="{{$location->flag}}"
                                                        class="card-img-top"
                                                        width="100" height="100"
                                                        alt="{{$location->country}}"
                                                    />
                                                </td>
                                                <td>{{$location->numVisitors}}</td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="weather row">
            <div id="mapInfo" class="col">
                <div class="card">
                    <div class="card-body">
                        <style>
                            #map {
                                height: 400px;
                                width: 100%;
                            }
                        </style>
                        <div id="map"></div>
                    </div>
                </div>
            </div>
            @endunless
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function initMap() {
        let locations = @json($locations);

        let map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: {lat: 37.7749, lng: -122.4194} // San Francisco coordinates
        });

        for (let i = 0; i < locations.length; i++) {
            let location = locations[i];
            let myLat = parseFloat(location.latitude);
            let myLong = parseFloat(location.longitude);
            let myLatLng = {lat: myLat, lng: myLong};
            let marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: location.city
            });
        }
    }

    const ctx = document.getElementById('myChart');
    let data = @json($guestFrequency);
    let sixToThree = 0;
    let threeToNine = 0;
    let nineToTwelve = 0;
    let twelveToSix = 0;

    for (let i = 0; i < data.length; i++) {
        let date = new Date(data[i].created_at);
        const hours = date.getHours();
        if (hours >= 6 && hours < 15) {
            sixToThree += data[i].visits;
            console.log(data[i].visits);
        } else if (hours >= 15 && hours < 21) {
            threeToNine += data[i].visits;
        } else if (hours >= 21 && hours < 24) {
            nineToTwelve += data[i].visits;
        } else if (hours >= 0 && hours < 6) {
            twelveToSix += data[i].visits;
        }
    }

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['6:00-15:00', '15:00-21:00', '21:00-24:00', '00:00-6:00'],
            datasets: [{
                label: 'Visits',
                data: [sixToThree, threeToNine, nineToTwelve, twelveToSix],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf-phax9JVzpIm91BBxFP-HFM83rnTY9U&callback=initMap"
        async defer></script>
{{--<script src="{{ asset('js/app.js') }}" defer></script>--}}
</body>

</html>
