<?php

use CoffeeCode\Router\Router;

require __DIR__ . "./../vendor/autoload.php";

$router = new Router(DOMAIN, "::");

$router->namespace("App\Services");

/**
 * Web Routes
 */
$router->group("");
$router->get("/", "WebServices::index");

/**
 * Procucts Routes
 */
$router->group("/product");
$router->get("/find/{id}", "ProductServices::find");
$router->get("/findByName/{name}", "ProductServices::findByName");
$router->get("/findByCategory/{name}", "CategoryServices::findByName");

$router->post("/create", "ProductServices::create");
$router->put("/update/{id}", "ProductServices::update");
$router->patch("/update/name/{id}", "ProductServices::updateName");
$router->patch("/update/price/{id}", "ProductServices::updatePrice");
$router->patch("/update/quantity/{id}", "ProductServices::updateQtd");
$router->delete("/delete/{id}", "ProductServices::delete");

/**
 * Category Routes
 */
$router->group("/category");
$router->get("/find/{id}", "CategoryServices::find");
$router->post("/create", "CategoryServices::create");
$router->put("/update/{id}", "CategoryServices::update");
$router->delete("/delete/{id}", "CategoryServices::delete");

/**
 * Users Routes
 */
$router->group("/user");
$router->get("/find/{id}", "UserServices::find");
$router->post("/login", "UserServices::login");
$router->post("/register", "UserServices::register");

/**
 * Employees Routes
 */
$router->group("/employee");
$router->post("/login", "EmployeeServices::login");
$router->post("/register", "EmployeeServices::register");
$router->post("/register/info/{id}", "EmployeeServices::registerEmployeeInfo");
$router->get("/find/{id}", "EmployeeServices::find");
$router->get("/find/info/{id}", "EmployeeServices::info");
$router->get("/findByName/{name}", "EmployeeServices::findByName");
$router->patch("/update/address/{id}", "EmployeeServices::updateAdrress");
$router->patch("/update/salary/{id}", "EmployeeServices::updateSalary");
$router->delete("/delete/{id}", "EmployeeServices::delete");

$router->patch("/promote/{id}", "EmployeeServices::promote");


/**
 * Faker Routes
 */
$router->group("faker");
$router->get("/product/{qtd}", "FakerServices::procuct");
$router->get("/category/{qtd}", "FakerServices::category");

/**
 * This method executes the routes
 */
$router->dispatch();

if ($router->error()) {
    var_dump($router->error());
}