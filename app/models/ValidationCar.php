<?php

namespace App\Models;

class ValidationCar
{
    const RULLE_CAR = [
        'name' => 'required | max:80',
        'description' => 'required',
        'model' => 'required | max:10 | min:2',
        'date' => 'required | date_format: "Y-m-d"'
    ];
}