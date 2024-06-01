<?php

namespace App\Models;

use CodeIgniter\Model;

class WeatherModel extends Model
{
    protected $table = 'weather-data';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'city', 'region', 'country', 'temperature', 'condition', 'humidity', 'wind', 'fetched_at'
    ];
}
