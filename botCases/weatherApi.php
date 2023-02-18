<?php

//namespace botCases;
//
//class WeatherApi
// {

    function getTemp(): string
    {
        $apiKey = 'a3ffcfba207f3d4a6c4ccb21ec6aab06';
        $city = 'Yoshkar-Ola';

        $googleApiUrl = "https://api.openweathermap.org/data/2.5/weather?q=" . $city . "&lang=ru&units=metric&APPID=" . $apiKey;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        curl_close($ch);
        $data = json_decode($response);
//        echo 'погода работает';
        return "В городе: " . $data->name . ", температура: " .$data->main->temp_min . "c";
    }
// }
