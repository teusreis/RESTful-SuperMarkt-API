<?php

// Debuging functions
function d($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

function dd($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}

// Requst function
function getRequestData(): array
{
    // Get the data sent by the user e convert into an associative array;
    $request = json_decode(file_get_contents("php://input"), true);
    $data = [];

    // Sanitize the data
    foreach ($request as $key => $value) {
        $data[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    return $data;
}

function serializeData(array $request)
{
    $data = [];

    // Sanitize the data
    foreach ($request as $key => $value) {
        $data[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    return $data;
}

// URL function!
function url(string $complement = null): string
{
    if ($complement) {
        return DOMAIN . $complement;
    }

    return DOMAIN;
}
