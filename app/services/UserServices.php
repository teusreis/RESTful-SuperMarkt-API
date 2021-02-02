<?php

namespace App\Services;

use App\Auth\AuthController;
use App\Model\User;

class UserServices
{
    private User $user;

    public function __construct()
    {
        header("Content-type: Application/json");
        $this->user = new User();
    }

    public function find(array $data)
    {
        $user = $this->user->findById($data["id"]);
        
        if (is_null($user)) {
            http_response_code(404);
            $response = [
                "status" => "not found",
                "body" => "No user found with the id: {$data['id']}"
            ];
        } else {
            AuthController::isAdmin();
            $response = [
                "status" => "success",
                "body" => $user->data
            ];
        }

        echo json_encode($response);
    }

    public function login()
    {
        $POST = getRequestData();

        $token = $this->user->login($POST["email"], $POST['password']);

        if ($token === false) {
            $response = [
                "Status" => "Error",
                "body" => "Invalide email or password!"
            ];
        } else {
            $response = [
                "Status" => "Success",
                "body" => "$token"
            ];
        }

        echo json_encode($response);
    }

    public function register()
    {
        $request = getRequestData();

        extract($request);

        $this->user->setName($name ?? "")
            ->setLastName($lastName ?? "")
            ->setEmail($email ?? "")
            ->setPassword($password ?? "", $confirmPassword ?? "");

        if ($this->user->save()) {
            http_response_code(201);
            $response = [
                "status" => "success",
                "body" => "User created successfully!",
                "userId" => $this->user->id
            ];
        } else {
            http_response_code(400);
            $response = [
                "status" => "error",
                "body" => $this->user->error
            ];
        }
        echo json_encode($response);
    }
}
