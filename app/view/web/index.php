<?php $this->layout("layout/main") ?>

<div class="py-5">
    <h2 class="h3">Welcome to the Super Market API!</h2>

    <p class="text-muted">
        You need to register you self in order to use this api!
    </p>

    <p class="text-muted">
        Obs: All the path must start with: <span class="text-bold"><?= url(); ?></span> plus the path that you want to access! <br>

        All the Parameters in bold are required, and if the parameter do not appear at the path, it means that it should be passed to the API through JSON!
    </p>
    

    <table class="table my-5 table-striped table-hover">
        <thead class="">
            <tr>
                <td class="">Path</td>
                <td class="">Method</td>
                <td class="">Description</td>
                <td class="">Parameters</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    /user/login
                </td>
                <td>
                    POST
                </td>
                <td>
                    Path to basic user login!
                </td>
                <td>
                    <span class="required">
                        email, password
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    /user/register
                </td>
                <td>
                    POST
                </td>
                <td>
                    Path to basic user creata an account!
                </td>
                <td>
                    <span class="required">
                        name, lastName, email, password, confirmPassword
                    </span>
                </td>
            </tr>
        </tbody>
    </table>

    <h3>
        Public paths
    </h3>
    <p class="text-muted">
        In order to use the following paths, you must have an header called "Authorization" with the token that you receve when you login!
    </p>

    <table class="table my-5 table-striped table-hover">
        <thead class="">
            <tr>
                <td class="">Path</td>
                <td class="">Method</td>
                <td class="">Description</td>
                <td class="">Parameters</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    /product/find/{id}
                </td>
                <td>
                    GET
                </td>
                <td>
                    Get a specific product by its id
                </td>
                <td>
                    id
                </td>
            </tr>

            <tr>
                <td>
                    /product/findByName/{name}
                </td>
                <td>
                    GET
                </td>
                <td>
                    Get a specific product or a group of products by their name
                </td>
                <td>
                    <span class="required">
                        name
                    </span>

                </td>
            </tr>

            <tr>
                <td>
                    /product/findByCategory/{name}
                </td>
                <td>
                    GET
                </td>
                <td>
                    Get a group of products by the category's name
                </td>
                <td>
                    <span class="required">
                        name
                    </span>

                </td>
            </tr>

            <tr>
                <td>
                    /employee/login
                </td>
                <td>
                    POST
                </td>
                <td>
                    Path to employee users login!
                </td>
                <td>
                    <span class="required">
                        email, password
                    </span>
                </td>
            </tr>

        </tbody>
    </table>

    <h3>
        Private paths
    </h3>
    <p class="text-muted">
        In order to use the following paths, you must have an header called "Authorization" with the token that you receve when you login and you need to be an employee or admin!
    </p>

    <table class="table my-5 table-striped table-hover">
        <thead class="">
            <tr>
                <td class="">Path</td>
                <td class="">Method</td>
                <td class="">Description</td>
                <td class="">Parameters</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    /product/create
                </td>
                <td>
                    POST
                </td>
                <td>
                    Create a new product!
                </td>
                <td>
                    <span class="required">
                        name, price, qtd: quantity
                    </span>
                    , category_id
                </td>
            </tr>

            <tr>
                <td>
                    /product/update/{id}
                </td>
                <td>
                    PUT
                </td>
                <td>
                    Update a hole product by its id
                </td>
                <td>
                    <span class="required">
                        id, name, price, qtd: quantity
                    </span>
                    , category_id
                </td>
            </tr>

            <tr>
                <td>
                    /product/update/name/{id}"
                </td>
                <td>
                    PATCH
                </td>
                <td>
                    Update an product's name
                </td>
                <td>
                    <span class="required">
                        id, name
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    /product/update/price/{id}
                </td>
                <td>
                    PATCH
                </td>
                <td>
                    Update an product's price
                </td>
                <td>
                    <span class="required">
                        id, price
                    </span>

                </td>
            </tr>

            <tr>
                <td>
                    /product/update/quantity/{id}
                </td>
                <td>
                    PATCH
                </td>
                <td>
                    Update an product's quantity
                </td>
                <td>
                    <span class="required">
                        id, qtd: quantity
                    </span>

                </td>
            </tr>

            <tr>
                <td>
                    /product/delete/{id}
                </td>
                <td>
                    DELETE
                </td>
                <td>
                    Delete a product
                </td>
                <td>
                    <span class="required">
                        id
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    /employee/login
                </td>
                <td>
                    POST
                </td>
                <td>
                    Path to employee users login!
                </td>
                <td>
                    <span class="required">
                        email, password
                    </span>

                </td>
            </tr>

            <tr>
                <td>
                    /employee/register
                </td>
                <td>
                    POST
                </td>
                <td>
                    Path to register a new employee
                </td>
                <td>
                    <span class="required">
                        name, lastName, email, password, confirmPassword
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    /employee/find/{id}
                </td>
                <td>
                    GET
                </td>
                <td>
                    Find an employee by his id
                </td>
                <td>
                    <span class="required">
                        id
                    </span>

                </td>
            </tr>

            <tr>
                <td>
                    /employee/find/info/{id}
                </td>
                <td>
                    GET
                </td>
                <td>
                    Find the employee's information by his id
                </td>
                <td>
                    <span class="required">
                        id
                    </span>

                </td>
            </tr>

            <tr>
                <td>
                    /employee/findByName/{name}
                </td>
                <td>
                    GET
                </td>
                <td>
                    Find a specific employee or a group of employees by their names
                </td>
                <td>
                    <span class="required">
                        name
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    /employee/register/info/{id}
                </td>
                <td>
                    POST
                </td>
                <td>
                    Register the employee's information
                </td>
                <td>
                    id, address, addressNumber, phoneNumber, salary
                </td>
            </tr>

            <tr>
                <td>
                    /employee/update/address/{id}
                </td>
                <td>
                    PATH
                </td>
                <td>
                    Update the employee's address
                </td>
                <td>
                    <span class="required">
                        id
                    </span>
                    , address, addressNumver
                </td>
            </tr>

            <tr>
                <td>
                    /employee/update/salary/{id}
                </td>
                <td>
                    POST
                </td>
                <td>
                    Update the employee's salary
                </td>
                <td>
                    <span class="required">
                        id
                    </span>
                    , salary
                </td>
            </tr>

            <tr>
                <td>
                    /employee/delete/{id}
                </td>
                <td>
                    DELETE
                </td>
                <td>
                    Delete an employee by his id
                </td>
                <td>
                    <span class="required">
                        id
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    /employee/promote/{id}
                </td>
                <td>
                    PATCH
                </td>
                <td>
                    Promote a normal employee to an admin employee
                </td>
                <td>
                    <span class="required">
                        id
                    </span>
                </td>
            </tr>

        </tbody>
    </table>


</div>