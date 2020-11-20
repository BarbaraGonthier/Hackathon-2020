<?php

namespace App\Model;

use Symfony\Component\HttpClient\HttpClient;

class ExercisesManager
{
    public function getAll()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://wger.de/api/v2/exercise/?language=2');

        return$response->toArray();
    }

    public function getCategories()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://wger.de/api/v2/exercisecategory');

        return $response->toArray();
    }

    public function getCategoryById(int $id)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://wger.de/api/v2/exercise/?language=2&category=' . $id);

        return $response->toArray();
    }

    public function getMuscles()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://wger.de/api/v2/muscle');

        return $response->toArray();
    }

    public function getMuscleById(int $id)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://wger.de/api/v2/exercise/?language=2&muscles=' . $id);

        return $response->toArray();
    }

    public function getExerciseById(int $id)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://wger.de/api/v2/exerciseinfo/' . $id . '/');

        return $response->toArray();
    }
}
