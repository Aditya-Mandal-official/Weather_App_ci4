<?php

namespace App\Controllers;

use App\Models\WeatherModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WeatherController extends BaseController
{
    public function view(){
        return view('weather');
    }
    public function getWeather(){
        if ($this->request->isAJAX()) {
            $city = $this->request->getPost('city');
            $apiKey = getenv('weather.apiKey');
            $apiUrl = "https://api.weatherapi.com/v1/forecast.json?key={$apiKey}&q={$city}&days=5";
            // $apiUrl = "https://api.weatherapi.com/v1/current.json?key={$apiKey}&q={$city},india";

            $weatherData = $this->fetchWeatherData($apiUrl);

            if ($weatherData['status'] === 200 && isset($weatherData['data'])) {
                $this->saveWeatherData($weatherData['data']);
                $this->sendWeatherEmail($weatherData['data']);
            }
            
            return $this->response->setJSON($weatherData);
        }
        return redirect()->to('/weather');
    }

    private function fetchWeatherData($url){
        $curl = \Config\Services::curlrequest();

        $response = $curl->get($url);

        $responseData = json_decode($response->getBody(), true);
        $responseStatus = $response->getStatusCode();

        $responseData = [
            'data' => $responseData,
            'status' => $responseStatus
        ];

        return $responseData;
    }
    private function saveWeatherData($data){
        $weatherModel = new WeatherModel();
        // $weatherData = [
        //     'city' => $data['location']['name'],
        //     'region' => $data['location']['region'],
        //     'country' => $data['location']['country'],
        //     'temperature' => $data['current']['temp_c'],
        //     'condition' => $data['current']['condition']['text'],
        //     'humidity' => $data['current']['humidity'],
        //     'wind' => $data['current']['wind_kph'],
        //     'fetched_at' => date('Y-m-d H:i:s')
        // ];
        
        // $weatherModel->save($weatherData);
        $city = $data['location']['name'];

    // Check if the weather data for the given city and current date already exists
    $existingWeather = $weatherModel->where('city', $city)->first();

    $weatherData = [
        'city' => $data['location']['name'],
        'region' => $data['location']['region'],
        'country' => $data['location']['country'],
        'temperature' => $data['current']['temp_c'],
        'condition' => $data['current']['condition']['text'],
        'humidity' => $data['current']['humidity'],
        'wind' => $data['current']['wind_kph'],
        'fetched_at' => date('Y-m-d H:i:s')
    ];

    if ($existingWeather) {
        // Update the existing record
        $weatherModel->update($existingWeather['id'], $weatherData);
        return false; // Indicate that the record was updated
    } else {
        // Insert new record
        $weatherModel->save($weatherData);
        return true; // Indicate that a new record was inserted
    }

    }
    private function sendWeatherEmail($data){
        $email = service('email');

        $email->setFrom('adityamandalweb@gmail.com', 'Aditya Mandal');
        $email->setTo('adityamandal8617@gmail.com');

        $email->setSubject('Weather Report for ' . $data['location']['name']);
        $email->setMessage('<p>Temperature: ' . $data['current']['temp_c'] . ' °C</p>' .
            '<p>Condition: ' . $data['current']['condition']['text'] . '</p>' .
            '<p>Humidity: ' . $data['current']['humidity'] . ' %</p>' .
            '<p>Wind: ' . $data['current']['wind_kph'] . ' kph</p>');

        $email->send();
    }
}
