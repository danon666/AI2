<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods:['GET'])]
    public function index(
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] string $city,
        WeatherUtil $util,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response
    {
        $measurements = $util->getWeatherForCountryAndCity($country, $city);

        if ($twig) {
            $template = $format === 'csv'
                ? 'weather_api/index.csv.twig'
                : 'weather_api/index.json.twig';

            $response = $this->render($template, [
                'city' => $city,
                'country' => $country,
                'measurements' => $measurements,
            ]);

            $response->headers->set(
                'Content-Type',
                $format === 'csv'
                    ? 'text/plain;charset=utf-8'
                    : 'application/json'
            );

            return $response;
        }

        if($format === 'csv'){
            $cols = ["city,country,date,celcius,fahrenheit"];
            foreach($measurements as $m){
                $cols[] = sprintf(
                    '%s,%s,%s,%s %s',
                    $city,
                    $country,
                    $m->getDate()->format('Y-m-d'),
                    $m->getCelsius(),
                    $m->getFahrenheit()
                );
            }
            return new Response(
                implode("\n",$cols),
                Response::HTTP_OK,
                ['Content-Type' => 'text/plain;charset=utf-8']
            );
        }
        return $this->json([
            'country' => $country,
            'city' => $city,
            'measurements' => array_map(fn(Measurement $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'celsius' => $m->getCelsius(),
                'fahrenheit' => $m->getFahrenheit(),
            ], $measurements),
        ]);
    }
}
