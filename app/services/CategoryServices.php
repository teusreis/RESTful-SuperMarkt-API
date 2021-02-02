<?php

namespace App\Services;

use App\Auth\AuthController;
use App\Model\Category;

class CategoryServices
{
    private Category $category;

    public function __construct()
    {
        header("content-type: application/json");
        AuthController::checkAuth();
        $this->category = new Category();
    }

    public function find($data)
    {
        $category = $this->findCategory($data["id"]);

        $response = [
            "status" => "success",
            "body" => $category->data
        ];

        echo json_encode($response);
    }

    public function findByName($data)
    {
        $category = $this->category->find("name = :name", "name={$data['name']}")->fetch();

        if (is_null($category)) {
            http_response_code(404);
            $response = [
                "status" => "The category: {$data['name']} doen not exist!"
            ];

            echo json_encode($response);
            return;
        }

        $products = $category->products();

        if (is_null($products)) {
            http_response_code(404);
            $response = [
                "status" => "No products found for the category: {$category->name}!"
            ];

            echo json_encode($response);
            return;
        }

        $response = [
            "status" => "success",
            "categoryName" => $category->name,
            "produtsQtd" => count($products),
            "body" => $products
        ];

        echo json_encode($response);
    }

    public function create()
    {
        AuthController::isEmployee();

        $requets = getRequestData();

        $this->category->setName($requets["name"] ?? "");

        if ($this->category->save()) {
            http_response_code(201);
            $response = [
                "status" => "Success",
                "id" => $this->category->id,
                "body" => "Category created successfully!"
            ];
        } else {
            http_response_code(500);
            $response = [
                "status" => "Error",
                "body" => $this->category->error
            ];
        }

        echo json_encode($response);
    }

    public function update($data)
    {
        AuthController::isEmployee();

        $category = $this->findCategory($data["id"]);

        $POST = getRequestData();

        $category->setName($POST["name"] ?? "");

        if ($category->save()) {
            http_response_code(201);

            $response = [
                "status" => "Success",
                "body" => "Category updated successfully!"
            ];
        } else {
            http_response_code(500);
            $response = [
                "status" => "error",
                "body" => $category->error
            ];
        }

        echo json_encode($response);
    }

    public function delete($data)
    {
        AuthController::isEmployee();
        
        $category = $this->findCategory($data["id"]);

        if ($category->destroy()) {
            $response = [
                "status" => "success",
                "body" => "Category deleted successfully!"
            ];
        } else {
            http_response_code(500);
            $response = [
                "status" => "error",
            ];
        }

        echo json_encode($response);
    }

    private function findCategory($id): Category
    {
        $category = $this->category->findById($id);

        if (is_null($category)) {
            http_response_code(404);

            $response = [
                "status" => "Not found",
                "body" => "No category found with the id: $id"
            ];

            echo json_encode($response);
            die();
        }

        return $category;
    }
}
