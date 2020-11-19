<?php

namespace App\Controller;

use App\Model\ExercisesManager;

class ExercisesController extends AbstractController
{
    public $images = [
        1 => '1.png',
        2 => '2.png',
        3 => '3.png',
        4 => '4.png',
        5 => '5.png',
        6 => '6.png',
        7 => '7.png',
        8 => '8.png',
        9 => '9.png',
        10 => '10.png',
        11 => '11.png',
        12 => '12.png',
        13 => '13.png',
        14 => '14.png',
        15 => '15.png',
    ];

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $exercisesManager = new ExercisesManager();
        $exercises = $exercisesManager->getAll();
        return $this->twig->render('Exercises/index.html.twig', [
            'exercises' => $exercises
        ]);
    }

    public function indexCategories()
    {
        $exercisesManager = new ExercisesManager();
        $categories = $exercisesManager->getCategories();
        return $this->twig->render('Exercises/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    public function category(int $id)
    {
        $exercisesManager = new ExercisesManager();
        $exercises = $exercisesManager->getCategoryById($id);
        return $this->twig->render('Exercises/index.html.twig', [
            'exercises' => $exercises
        ]);
    }

    public function indexMuscles()
    {
        $exercisesManager = new ExercisesManager();
        $muscles = $exercisesManager->getMuscles();
        return $this->twig->render('Exercises/muscles.html.twig', [
            'muscles' => $muscles,
            'illustrations' => $this->images
        ]);
    }

    public function muscle(int $id)
    {
        $exercisesManager = new ExercisesManager();
        $exercises = $exercisesManager->getMuscleById($id);
        return $this->twig->render('Exercises/index.html.twig', [
            'exercises' => $exercises
        ]);
    }

    public function exercise(int $id)
    {
        $exercisesManager = new ExercisesManager();
        $exercise = $exercisesManager->getExerciseById($id);
        return $this->twig->render('Exercises/show.html.twig', [
            'exercise' => $exercise,
            'illustrations' => $this->images
        ]);
    }
}
