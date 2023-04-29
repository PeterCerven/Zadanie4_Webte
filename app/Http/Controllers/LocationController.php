<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public static string $apiKey = "30e9c66b8e2696cf69ab10445955db03";

    public function index()
    {
        session_start();
        $ip = $_SERVER['REMOTE_ADDR'];
        $guest = $this->isNewGuest($ip);
        if ($guest !== null) {
            $updated_at = Carbon::parse($guest->updated_at);
            if (!$updated_at->isToday()) {
                $guest->visits++;
                $guest->update();
            }
        } else {
            $newGuest = new Guest();
            $newGuest->visits = 1;
            $newGuest->ip = $ip;
            $newGuest->save();
        }

        $locationsCountByCountry = DB::table('locations')
            ->select(DB::raw('count(*) as numVisitors, country, flag'))
            ->groupBy('country', 'flag')
            ->get();


        return view('welcome', [
            'locations' => Location::all(),
            'locationWeather' => null,
            'locationsCount' => $locationsCountByCountry,
            'guestFrequency' => Guest::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->locationData($request);
        $location = Location::create($data);
        return redirect("./locations/$location->id");

    }

    public function show(Location $location)
    {
        $locationsCountByCountry = DB::table('locations')
            ->select(DB::raw('count(*) as numVisitors, country, flag'))
            ->groupBy('country', 'flag')
            ->get();

        return view('welcome', [
            'locations' => Location::all(),
            'locationWeather' => $location,
            'locationsCount' => $locationsCountByCountry,
            'guestFrequency' => Guest::all(),
        ]);
    }

    private function isNewGuest(mixed $ip): ?Guest
    {
        return Guest::where('ip', $ip)->first();
    }


    private function locationData(Request $request)
    {
        if (isset($request->cityName) && !empty($request->cityName)) {
            $apiCall = "http://api.openweathermap.org/geo/1.0/direct?q={$request->cityName}&limit=1&appid={$this::$apiKey}";
            $response = file_get_contents($apiCall);
            $data = json_decode($response, true);
            $_POST['latitude'] = $data[0]['lat'];
            $_POST['longitude'] = $data[0]['lon'];
        }
        $lat = $_POST['latitude'];
        $lon = $_POST['longitude'];

        $lang = 'en';
        $units = 'metric';
        $apiCall = "http://api.openweathermap.org/data/2.5/onecall?lat={$lat}&lon={$lon}&appid={$this::$apiKey}&units={$units}&lang={$lang}";
        $resp = file_get_contents($apiCall);
        $data = json_decode($resp, true);

        $info['temp'] = $data['current']['temp'];
        $info['image'] = "http://openweathermap.org/img/wn/{$data['current']['weather'][0]['icon']}@4x.png";
        $info['weather_name'] = $data['current']['weather'][0]['main'];
        $info['humidity'] = $data['current']['humidity'];
        $info['time'] = date('H:i', $data['current']['dt']);


        $apiCall2 = "https://api.openweathermap.org/geo/1.0/reverse?lat=$lat&lon=$lon&limit=1&appid={$this::$apiKey}";
        $resp2 = file_get_contents($apiCall2);
        $data2 = json_decode($resp2, true);

        $countryCode = $data2[0]['country'];
        $city = $data2[0]['name'];
        $countryName = $data2[0]['state'] ?? '';


        $apiCall3 = "https://restcountries.com/v3.1/alpha/$countryCode";
        $resp3 = file_get_contents($apiCall3);

        $data3 = json_decode($resp3, true);

        $capital = $data3[0]['capital'][0] ?? '';
        $flagUrl = $data3[0]['flags']['svg'] ?? '';
        $countryName = $data3[0]['name']['common'] ?? '';

        return [
            'guest_id' => Guest::latest()->first()->id ?? 0,
            'city' => $city,
            'country_code' => $countryCode, // 'US
            'country' => $countryName,
            'capital' => $capital,
            'longitude' => $lon,
            'latitude' => $lat,
            'flag' => $flagUrl,
            'weather_name' => $info['weather_name'],
            'temperature' => $info['temp'],
            'humidity' => $info['humidity'],
            'weather_image' => $info['image'],
            'time' => $info['time'],
        ];
    }


}
