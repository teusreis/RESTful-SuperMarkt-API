<?php

namespace App\Services;

use Faker\Factory;
use League\Plates\Engine;

class FakerServices
{
    private Engine $templete;

    public function __construct()
    {
        $this->templete = new Engine(__DIR__ . "/../view");
    }

    public function procuct($data)
    {
        dd($data);

        $faker = Factory::create();
    }

    public function category($data)
    {
        dd($data);

        $faker = Factory::create();
    }

    public function user()
    {
    }

    public function employe()
    {
    }
}
