<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-body-secondary">
    <div class="container">
        <h2 class="text-center py-4">Weather App</h2>
        <div class="row">
            <div class="text-danger mb-0" ></div>
            <form class="col-lg-4 d-flex" id="getWeather">
                <input type="text" name="city" id="city" class="form-control"  placeholder="Search City">
                <button class="btn btn-primary" style="margin: 7px; margin-left: -80px;">Search</button>
            </form>
        </div>
        <div class="row" id="weatherInfo">

        </div>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#getWeather').submit(function(e) {
                e.preventDefault();

                var city = $('#city').val();

                $.ajax({
                    url: '/weather/getWeather',
                    type: 'POST',
                    data: {
                        city: city,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>' // Include CSRF token
                    },
                    dataType: 'json',
                    success: function(response) {

                        if (response.status === 200) {
                            const forecast = response.data.forecast.forecastday;
                            let forecastHtml = `<h2 class="mt-5">5-Day Weather Forecast for ${city}</h2>`;
                            forecast.forEach(day => {
                                forecastHtml += `
                                <div class="col-lg-3 col-md-6 col-12 mt-5 text-center">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5>${response.data.location.name}</h5>
                                            <img src="${response.data.current.condition.icon}" alt="" class="img-fluid">
                                            <p>${new Date(day.date).toLocaleDateString()}</p>
                                            <p>Temperature: ${day.day.avgtemp_c} °C</p>
                                            <p>Condition: ${day.day.condition.text}</p>
                                            <p>Humidity: ${day.day.avghumidity} %</p>
                                            <p>Wind: ${day.day.maxwind_kph} kph</p>
                                        </div>
                                    </div>
                                </div>
                                `;
                            });
                            $('#weatherInfo').html(forecastHtml);
                        } else {
                            $('#weatherInfo').html('<p>Error: Could not fetch weather data.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#weatherInfo').html('<p>An error occurred while fetching weather data.</p>');
                    }
                });
            });
        });
    </script>
</html>