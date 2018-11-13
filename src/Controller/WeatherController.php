<?php

namespace App\Controller;

use App\GoogleApi\DateValidator;
use App\GoogleApi\WeatherService;
use App\Model\NullWeather;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeatherController extends AbstractController
{
    public function index($day)
    {
        $validator = new DateValidator();
        $errormsg = '';
        if($day != null) {
            $resp = $validator->validate($day);
            if($resp !== true)
            {
                $errormsg = $resp;
            }
        }
        if($errormsg != '')
        {
            return $this->render('weather/error.html.twig', [
                'error' => $errormsg ]);
        }
        else {
            try {
                $fromGoogle = new WeatherService();
                $weather = $fromGoogle->getDay(new \DateTime($day));
            } catch (\Exception $exp) {
                $weather = new NullWeather();
            }
            return $this->render('weather/index.html.twig', [
                'weatherData' => [
                    'date' => $weather->getDate()->format('Y-m-d'),
                    'dayTemp' => $weather->getDayTemp(),
                    'nightTemp' => $weather->getNightTemp(),
                    'sky' => $weather->getSky()
                ],
            ]);
        }
    }
}
