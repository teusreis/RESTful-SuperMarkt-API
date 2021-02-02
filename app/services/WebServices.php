<?php

namespace App\Services;

use League\Plates\Engine;

class WebServices
{
    private Engine $templete;

    public function __construct()
    {
        $this->templete = new Engine(__DIR__ . "/../view");
    }

    public function index()
    {
        echo $this->templete->render("web/index");
    }
}
