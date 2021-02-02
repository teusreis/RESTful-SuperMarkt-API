<?php

namespace App\Services;

use App\Model\Employee;
use App\Model\EmployeeInfo;
use App\Auth\AuthController;

class EmployeeServices
{
    private Employee $employee;

    public function __construct()
    {
        header("Content-type: Application/json");
        $this->employee = new Employee();
    }

    public function login()
    {
        $POST = getRequestData();

        $token = $this->employee->login($POST["email"] ?? "", $POST['password']  ?? "", true);

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

    public function find(array $data)
    {
        $column = "id, name, lastName, email, userType, created_at, updated_at";

        $employee = $this->getEmployee($data["id"], $column);

        if (is_null($employee)) {
            http_response_code(404);
            $response = [
                "status" => "not found",
                "body" => "No employee found with the id: {$data['id']}"
            ];
        } else {
            AuthController::isAdmin();
            $response = [
                "status" => "success",
                "body" => $employee->data
            ];
        }

        echo json_encode($response);
    }

    public function findByName($data)
    {
        AuthController::isAdmin();

        $data = serializeData($data);

        $term = "(name LIKE :name OR lastName LIKE :lastName) AND isEmployee = true";

        $params = http_build_query([
            "name" => "%" . $data["name"] . "%",
            "lastName" => "%" . $data["name"] . "%"
        ]);

        $column = "id, name, lastName, email, userType, created_at, updated_at";

        $employees = $this->employee->find($term, $params, $column)->fetch(true);

        if (!is_null($employees)) {

            $data = array_map(fn ($employee) => $employee->data, $employees);

            $response = [
                "status" => "success",
                "body" => $data
            ];
        } else {
            $response = [
                "status" => "Not found!",
                "body" => "No employee with the name: {$data['name']}"
            ];
        }

        echo json_encode($response);
    }

    public function register()
    {
        AuthController::isAdmin();

        $request = getRequestData();

        extract($request);

        $this->employee->setName($name)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPassword($password, $confirmPassword)
            ->setIsEmployee(true)
            ->setUserType("employee");

        if ($this->employee->save()) {
            http_response_code(201);

            $response = [
                "status" => "success",
                "body" => "Employee created successfully",
                "employeeId" => $this->employee->id
            ];
        } else {
            http_response_code(400);

            $response = [
                "status" => "error",
                "body" => $this->employee->error,
            ];
        }

        echo json_encode($response);
    }

    public function registerEmployeeInfo($data)
    {
        AuthController::isAdmin();

        $employee = $this->getEmployee($data["id"]);

        $info = $employee->getInfo();

        if (!is_null($info)) {
            $response = [
                "status" => "error",
                "body" => "This employee alredy have some infomation set! If you wanto, yuo can use another path to update them!"
            ];
        } else {
            $request = getRequestData();
            extract($request);

            $info = (new EmployeeInfo)->setAddress($address ?? null)
                ->SetAddressNumber($addressNumber ?? null)
                ->setPhoneNumber($phoneNumber ?? null)
                ->setSalary($salary ?? null);

            if ($info->save()) {
                $employee->info = $info->id;
                $employee->save();
                http_response_code(201);
                $response = [
                    "status" => "success",
                    "employeeId" => $employee->id,
                    "body" => "Employee'info added successfully!"
                ];
            } else {
                $response = [
                    "status" => "error",
                    "body" => $info->error
                ];
            }
        }

        echo json_encode($response);
    }

    public function promote($data)
    {
        AuthController::isAdmin();
        $employee = $this->getEmployee($data["id"]);

        $employee->setUserType("admin");

        if ($employee->save()) {
            $response = [
                "status" => "success",
                "employee_id" => $employee->id,
                "body" => "Employee promoted to admin!"
            ];
        } else {
            http_response_code(400);
            $response = [
                "status" => "error",
                "body" => $employee->error
            ];
        }

        echo json_encode($response);
    }

    public function info($data)
    {

        $employee = $this->getEmployee($data["id"]);

        AuthController::isAdmin();
        $info = $employee->getInfo();

        if (is_null($info)) {
            $response = [
                "status" => "Not found",
                "body" => "There is no information for this employee!"
            ];
        } else {
            $response = [
                "status" => "success",
                "employeeId" => $data["id"],
                "body" => $info->data
            ];
        }

        echo json_encode($response);
    }

    public function updateAdrress($data)
    {
        AuthController::isAdmin();

        $employee = $this->getEmployee($data["id"]);
        $info = $employee->getInfo();


        $request = getRequestData();
        extract($request);

        $info->setAddress($address ?? "")
            ->setAddressNumber($addressNumber ?? "");

        if ($info->save()) {
            $response = [
                "status" => "success",
                "employeeId" => $employee->id,
                "body" => "Employee's address updated successfully!"
            ];
        } else {
            http_response_code(400);
            $response = [
                "status" => "error",
                "body" => $info->error
            ];
        }

        echo json_encode($response);
    }

    public function updateSalary($data)
    {
        AuthController::isAdmin();

        $employee = $this->getEmployee($data["id"]);
        $info = $employee->getInfo();
        $request = getRequestData();

        $info->setSalary($request["salary"] ?? 0);

        if ($info->save()) {
            $response = [
                "status" => "success",
                "employeeId" => $employee->id,
                "body" => "Employee's salary updated successfully!"
            ];
        } else {
            http_response_code(400);
            $response = [
                "status" => "error",
                "body" => $info->error
            ];
        }

        echo json_encode($response);
    }

    public function updatePhoneNumber($data)
    {
        AuthController::isAdmin();

        $employee = $this->getEmployee($data["id"]);
        $info = $employee->info();
        $request = getRequestData();

        $info->setPhoneNumber($request["phoneNumber"]);

        if ($info->save()) {
            $response = [
                "status" => "success",
                "employeeId" => $employee->id,
                "body" => "Employee's phone's number updated successfully!"
            ];
        } else {
            http_response_code(400);
            $response = [
                "status" => "error",
                "body" => $info->error
            ];
        }

        echo json_encode($response);
    }

    public function delete($data)
    {
        AuthController::isAdmin();

        $employee = $this->getEmployee($data["id"]);

        if ($employee->destroy()) {
            $response = [
                "status" => "success",
                "body" => "Employee deleted successfully!"
            ];
        } else {
            http_response_code(500);
            $response = [
                "status" => "error",
                "body" => "Ops, we had some internal probles!"
            ];
        }

        echo json_encode($response);
    }

    private function getEmployee($id, $colomn = "*")
    {
        $employee = $this->employee->find("id = :id AND isEmployee = true", "id=$id", $colomn)->fetch();

        if (is_null($employee)) {
            http_response_code(404);

            $response = [
                "status" => "Not found",
                "body" => "No employee found with the id: $id"
            ];

            echo json_encode($response);
            die();
        } else {
            return $employee;
        }
    }
}
