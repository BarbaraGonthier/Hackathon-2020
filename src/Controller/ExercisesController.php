<?php

namespace App\Controller;

use App\Model\ExercisesManager;

class ExercisesController extends AbstractController
{
    public $images = [
        1 => '1.jpg',
        2 => '2.jpg',
        3 => '3.jpg',
        4 => '4.jpg',
        5 => '5.jpg',
        6 => '6.jpg',
        7 => '7.jpg',
        8 => '8.jpg',
        9 => '9.jpg',
        10 => '10.jpg',
        11 => '11.jpg',
        12 => '12.jpg',
        13 => '13.jpg',
        14 => '14.jpg',
        15 => '15.jpg',
    ];

    public $categoryImages = [
        10 => 'abs.png',
        8 => 'arm.png',
        12 => 'back.png',
        14 => 'calves.png',
        11 => 'chest.png',
        9 => 'leg.png',
        13 => 'shoulder.png',
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
            'categories' => $categories,
            'images' => $this->categoryImages
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
            'illustrations' => $this->images,
            'done' => $_SESSION['done'] ?? []
        ]);
    }

    public function done(int $id)
    {
        $exercisesManager = new ExercisesManager();
        $exercise = $exercisesManager->getExerciseById($id);
        $_SESSION['done'] = [];
        if (key_exists($id, $_SESSION['done'])) {
            unset($_SESSION['done'][$id]);
        } else {
            $_SESSION['done'][$id] = $exercise;
        }
        header('Location: /exercises/exercise/' . $id);
    }

    public function myExercises()
    {
        return $this->twig->render('Exercises/done.html.twig', [
            'exercises' => $_SESSION['done'] ?? []
        ]);
    }
}
