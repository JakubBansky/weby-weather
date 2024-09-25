<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dovolenka</title>
    <?php include 'header.php'; ?>
    <style>
        .background {
            background-color: #81A594;
            border-radius: 5px;
        }
        #form{
            width: 94%;
            margin-left: 3%;
            margin-top: 1rem;
        }
        .country-flag{
           width: 128px;
        }
    </style>
</head>

<body>
    <form method="post" action="api.php" class="row g-3 needs-validation" id="form" novalidate>
        <div class="col-md-6">
            <label for="destination" class="form-label">Destinácia</label>
            <input type="text" name="destination" id="destination" class="form-control" required maxlength="50">
            <div class="invalid-feedback">
                Musíš zadať destináciu.
            </div>
        </div>
        <div class="col-md-6">
            <label for="date" class="form-label">Dátum</label>
            <input type="date" name="date" id="date" class="form-control" required>
            <div class="invalid-feedback">
                Musíš zadať dátum.
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Hľadaj</button>
        </div>
    </form>


    <div class="container text-center " id="info">
        <div class="row" id="weather">
        </div>
        <div></div>
    </div>
    <script>
        function addDiv(destination, data, txt) {
            let div = document.createElement("div");
            let h = document.createElement("h5");
            let p = document.createElement("p");
            div.classList.add("col");
            div.classList.add("mx-3");
            div.classList.add("my-3");
            div.classList.add("background");
            h.innerHTML = txt;
            p.innerHTML = data;
            div.appendChild(h);
            div.append(p);
            destination.appendChild(div);

            destination.appendChild(div);
        }

        const daysInMonth = {
            1: 31,
            2: 28,
            3: 31,
            4: 30,
            5: 31,
            6: 30,
            7: 31,
            8: 31,
            9: 30,
            10: 31,
            11: 30,
            12: 31
        };



        let form = document.getElementById("form");
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (!form.checkValidity()) {
                event.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            const currentDate = new Date();
            let currentMonth = currentDate.getMonth() + 1;
            const currentDay = currentDate.getDate();
            currentMonth = parseInt(currentMonth, 10);
            console.log('Current year:', currentDay);
            const destination = document.getElementById('destination').value;
            const dateInput = document.getElementById('date').value;
            let month = dateInput.split('-')[1]; // Assuming the format is YYYY-MM-DD
            month = parseInt(month, 10);

            if (currentMonth > month) {
                year = 2024;
            } else {
                year = 2023;
            }
            const apiKey = 'hehe';
            const apiUrl = `https://api.weatherapi.com/v1/current.json?key=${apiKey}&q=${destination}&aqi=no`;

            try {
                // const response = await fetch(apiUrl);
                // if (!response.ok) {
                //     throw new Error('Weather data not available.');
                // }
                // const weatherData = await response.json();
                // const wind = weatherData.current.wind_kph;
                // const weather = weatherData.current.condition.text;
                // const temperature = weatherData.current.temp_c;
                // const country = weatherData.location.country;


                // const countryDataResponse = await fetch(`https://restcountries.com/v3.1/name/${country}?fullText=true`);
                // if (!countryDataResponse.ok) {
                //     throw new Error('Country data not available.');
                // }

                // const countryData = await countryDataResponse.json();
                // const countryCode = countryData[0].cca2;
                // const capitalCity = countryData[0].capital[0];
                // const currencyCode = Object.keys(countryData[0].currencies)[0];

                let weatherInfo = document.getElementById("weather");
                // let info = document.getElementById("info");
                while (weatherInfo.firstChild) {
                    weatherInfo.removeChild(weatherInfo.firstChild);
                }
                
                // info.removeChild(info.lastElementChild);
                
                const image = document.createElement("img");
                const div = document.createElement("div");
                image.classList.add("col");
                image.classList.add("my-3");
                image.classList.add("mx-3");
                
                image.alt = "flag";

                // image.src = "https://flagsapi.com/" + countryCode + "/flat/64.png";
                image.src = "https://flagsapi.com/" + 'SK' + "/flat/64.png";
                image.classList.add("country-flag");
                div.appendChild(image);
                // const currencyResponse = await fetch(`https://api.freecurrencyapi.com/v1/latest?apikey=API_KEY&currencies=${currencyCode}&base_currency=EUR`);
                // if (!currencyResponse.ok) {
                //     throw new Error('Currency data not available.');
                // }
                // let avgTmp = 0;

                // if (currentMonth === month) {
                //     //past
                //     for (let i = 1; i < currentDay + 1; i++) {
                //         year = 2024;
                //         const temperatureResponse = await fetch(`https://api.weatherapi.com/v1/history.json?key=${apiKey}&q=${destination}&dt=${year}-${month}-${i}`);
                //         const temperatureData = await temperatureResponse.json();
                //         let temperature = temperatureData.forecast.forecastday[0].day.avgtemp_c;
                //         avgTmp += temperature;
                //     }
                //     //future
                //     for (let i = currentDay + 1; i < daysInMonth[month] + 1; i++) {
                //         year = 2023;
                //         const temperatureResponse = await fetch(`https://api.weatherapi.com/v1/history.json?key=${apiKey}&q=${destination}&dt=${year}-${month}-${i}`);
                //         const temperatureData = await temperatureResponse.json();
                //         let temperature = temperatureData.forecast.forecastday[0].day.avgtemp_c;
                //         avgTmp += temperature;
                //     }
                // } else {
                //     for (let i = 1; i < daysInMonth[month] + 1; i++) {
                //         const temperatureResponse = await fetch(`https://api.weatherapi.com/v1/history.json?key=${apiKey}&q=${destination}&dt=${year}-${month}-${i}`);
                //         const temperatureData = await temperatureResponse.json();
                //         let temperature = temperatureData.forecast.forecastday[0].day.avgtemp_c;
                //         avgTmp += temperature;
                //     }
                // }
                // avgTmp /= daysInMonth[month];
                // const currencyData = await currencyResponse.json();
                // const currencyRate = currencyData.data[currencyCode];
                
                const country = "APIKEY"
                fetch('http://localhost/api.php?countries', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            name: destination,
                            state: country,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                addDiv(weatherInfo, "APIKEY", 'počasie: ');
                addDiv(weatherInfo, "APIKEY" + '°C', 'teplota: ');
                addDiv(weatherInfo, "APIKEY" + 'kph', 'vietor: ');
                addDiv(weatherInfo, "APIKEY" + '°C', 'teplota (mesiac): ');

                addDiv(weatherInfo, "APIKEY", 'krajina: ');
                addDiv(weatherInfo, "APIKEY", 'hl. mesto: ');
                document.getElementById("info").appendChild(image);
                addDiv(weatherInfo, "API" +" "+ "KEY", 'kurz (1€ = ): ');
               
            } catch (error) {
                console.error('Error fetching weather data:', error.message);
            }

        });
    </script>
</body>

</html>