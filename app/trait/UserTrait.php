<?php

namespace App\Trait;

use App\Auth\AuthController;

trait UserTrait
{
    public function login(string $email, string $password, $isEmployee = false)
    {
        $params = http_build_query([
            "email" => $email,
            "isEmployee" => $isEmployee
        ]);

        $user = $this->find("email = :email AND isEmployee = :isEmployee", $params)->fetch();

        if (!is_null($user) && password_verify($password, $user->password)) {
            $token = AuthController::createJwt($user->id, $user->email, $user->userType);
            return $token;
        } else {
            return false;
        }
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        if ($name === "") {
            $this->hasError = true;
            $this->error['name'] = "Name is required";
        } else if (strlen($name) >= 50) {
            $this->hasError = true;
            $this->error['name'] = "Name most not be greater than 50 character";
        }
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */
    public function setLastName($lastName)
    {
        if ($lastName === "") {
            $this->hasError = true;
            $this->error['lastName'] = "lastName is required";
        } else if (strlen($lastName) >= 50) {
            $this->hasError = true;
            $this->error['lastName'] = "Last name most not be greater than 50 character";
        }

        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        if ($email === "") {
            $this->hasError = true;
            $this->error['email'] = "Email is required";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->hasError = true;
            $this->error['email'] = "$email is not a valide";
        } else if ($this->emailExist($email)) {
            $this->hasError = true;
            $this->error['email'] = "Email alredy exist!";
        }

        $this->email = $email;

        return $this;
    }

    public function setPassword($password, $confirmPassword)
    {
        if ($password === "" || $confirmPassword === "") {
            $this->hasError = true;
            $this->error['password'] = "Password is required";
        } else if ($password !== $confirmPassword) {
            $this->hasError = true;
            $this->error['password'] = "Password does not match with confirm password";
        }

        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    public function emailExist($email): bool
    {
        $user = $this->find("email = :email", "email={$email}")->count();

        return $user > 0;
    }
}
