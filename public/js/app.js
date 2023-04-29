// AIzaSyAf-phax9JVzpIm91BBxFP-HFM83rnTY9U

const app = {
    init: () => {
        document
            .getElementById('btnGet')
            .addEventListener('click', app.fetchWeather);
        document
            .getElementById('btnCurrent')
            .addEventListener('click', app.getLocation);
        document
            .getElementById('btnGetName')
            .addEventListener('click', app.fetchWeatherName);
    },
    fetchWeatherName: (ev) => {
        let cityName = document.getElementById('cityName').value;
        let key = '30e9c66b8e2696cf69ab10445955db03';
        let limit = 1;
        let apiCall = `http://api.openweathermap.org/geo/1.0/direct?q=${cityName}&limit=${limit}&appid=${key}`;
        fetch(apiCall)
            .then((resp) => {
                if (!resp.ok) throw new Error(resp.statusText);
                return resp.json();
            })
            .then((data) => {
                console.log(data);
                document.getElementById('latitude').value = data[0].lat;
                document.getElementById('longitude').value = data[0].lon;
                app.fetchWeather();
            })
            .catch(console.err);
    },
    fetchWeather: (ev) => {
        //use the values from latitude and longitude to fetch the weather
        let lat = document.getElementById('latitude').value;
        let lon = document.getElementById('longitude').value;
        let key = '30e9c66b8e2696cf69ab10445955db03';
        let lang = 'en';
        let units = 'metric';
        let apiCall = `http://api.openweathermap.org/data/2.5/onecall?lat=${lat}&lon=${lon}&appid=${key}&units=${units}&lang=${lang}`;
        //fetch the weather
        fetch(apiCall)
            .then((resp) => {
                if (!resp.ok) throw new Error(resp.statusText);
                return resp.json();
            })
            .then((data) => {
                console.log(data);
                app.showWeather(data);
                app.showWeatherInfo(data);
            })
            .catch(console.err);
        let apiCall2 = `https://api.openweathermap.org/geo/1.0/reverse?lat=${lat}&lon=${lon}&limit=1&appid=${key}`;
        fetch(apiCall2)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const countryCode = data[0].country;
                const city = data[0].name;
                const countryName = data[0].state || "";
                const capital = data[0].capital || "";
                console.log(`Country Code: ${countryCode}`);
                console.log(`City: ${city}`);
                console.log(`CountryName: ${countryName}`);
                console.log(`Capital: ${capital}`);
            })
            .catch(error => console.log(error));
        const apiKey = "30e9c66b8e2696cf69ab10445955db03";
        const countryName = "Slovakia";
        const countryCode = "SK";

        fetch(`https://restcountries.com/v3.1/alpha/${countryCode}`)
            .then(response => response.json())
            .then(data => {
                const capital = data[0].capital;
                const flagUrl = data[0].flags.svg;
                console.log(data[0]);
                console.log(`Capital City of ${countryName}: ${capital}`);
                console.log(`Flag Image URL of ${countryName}: ${flagUrl}`);
            })
            .catch(error => console.log(error));
    },
    getLocation: (ev) => {
        let opts = {
            enableHighAccuracy: true,
            timeout: 1000 * 10, //10 seconds
            maximumAge: 1000 * 60 * 5, //5 minutes
        };
        navigator.geolocation.getCurrentPosition(app.ftw, app.wtf, opts);
    },
    ftw: (position) => {
        //got position
        document.getElementById('latitude').value =
            position.coords.latitude.toFixed(2);
        document.getElementById('longitude').value =
            position.coords.longitude.toFixed(2);
    },
    wtf: (err) => {
        //geolocation failed
        console.error(err);
    },
    showWeather: (resp) => {
        let col = document.querySelector('#weather');
        //clear out the old weather and add the new
        // row.innerHTML = '';
        let day = resp.current;


        col.innerHTML = `
            <div class="card">
              <h5 class="card-title p-2">${new Date(day.dt * 1000).toDateString()}</h5>
                <img
                  src="http://openweathermap.org/img/wn/${day.weather[0].icon}@4x.png"
                  class="card-img-top"
                  alt="${day.weather[0].description}"
                />
                <div class="card-body">
                  <h3 class="card-title">${day.weather[0].main}</h3>
                  <p class="card-text">Temperature ${day.temp}&deg;</p>
                  <p class="card-text">Humidity ${day.humidity}%</p>
                </div>
              </div>
          `;
    },
    showWeatherInfo: (resp) => {
        let col = document.querySelector('#weatherInfo');
        let day = resp.current;


        col.innerHTML = `
            <div class="card">
              <h5 class="card-title p-2">Info</h5>
                <div class="card-body">
                  <p class="card-text">Latitude ${resp.lat}</p>
                  <p class="card-text">Longitude ${resp.lon}</p>
                </div>
              </div>
          `;
    },

};

app.init();
