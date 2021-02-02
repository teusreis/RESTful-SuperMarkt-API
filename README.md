# SuperMarkt API

SuperMarkt API, as the name suggest, is a Restful  API that uses JSON Web Token authentication!

## Main Features
---

- Login and register System
- JWT authentication
- Find products
- Create/update/delete products
- Register Employee

## What I learned
---

- How to use properly http methods, such as get, post, put, path and delete with in PHP
- How to authenticate and check users' permission with JWT
- Hot to use and send HTTP response status code
- How to receive and handle JSON data sent by the user, then sent a response in JSON!

## Requirements
---
- php: ^7.4 | ^8.0
- composer
- ext-pdo: *

## Installation and Setup
---

### Project Set up

First you need to clone this repo or download the zip and extract!

Then, inside the project, run the following command in your terminal to install the dependencies.

```
composer install
```

And, last but not the least, remove the .example from the config.php.example then change the variables' value to your database and domain info!

### DataBase Set up

To set up the database you just need to run the following commands in your MySQL workbench!

```
create database db_name;

use db_name;

create table category(
	id int primary key auto_increment,
    name varchar(255) unique not null,
    created_at timestamp default now(),
    updated_at timestamp default null
);

create table products(
	id int primary key auto_increment,
    name varchar(255) not null,
    price double not null,
    qtd int not null,
    category_id int,
    foreign key(category_id) references category(id) on delete set null,
    created_at timestamp default now(),
    updated_at timestamp default null
);

create table employees_info(
	id int primary key auto_increment,
    address varchar(255),
    addressNumber varchar(255),
    phoneNumber varchar(50),
    salary double
);

create table users(
	id int primary key auto_increment,
    name varchar(255) not null,
    lastName varchar(255) not null,
    email varchar(255) not null unique,
    isEmployee bool default false,
    userType varchar(50) not null default "basic",
    info int,
    foreign key(info) references employees_info(id) on delete cascade,
    password varchar(255) not null,
    created_at timestamp default now(),
    updated_at timestamp default null
);

insert into users(name, lastName, email, isEmploye, userType, password)
value("admin", "admin", "admin@admin.com", true, "admin" ,"$2y$10$zninhNb0cmI/Q9Q4DRo7/umY29os2UVcF9tCyxfvliwVB/Kf7wKB6");
```

So after the configuration, you can access the "/" page in your browser to see all the routes and the parameters!