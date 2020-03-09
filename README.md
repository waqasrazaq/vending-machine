# Vending Machine

## Technologies Used
* PHP 7.2
* Laravel Framework 7.0.6
* Redis 
* LaraDock

## Prerequisites

Make sure **Docker** (with docker-compose) and Git are already installed/running on the system. If not then follow the instructions to download and install it from the below link
* [Docker](https://www.docker.com/)
* [Git](https://git-scm.com/downloads)


## Installation
The installation process is quite simple and straightforward. Just follow the below steps

1- Clone the shared repo in any local directory using below command
```
git clone https://github.com/waqasrazaq/vending-machine.git
```

2- From the project root directory, navigate into Laradock
 
```
 cd laradock
 ```
and then below command

```
docker-compose up -d nginx redis
```

It will bring up all the required containers (e.g. PHP, NGINX, Redis) to run the application.

3-  Enter into workspace using below command
```
docker-compose exec workspace bash
```

4- Finally run the below command to install the project dependencies/libraries
```
composer install
```

That's it. Our vending-machine application is installed and configured. Should be available at http://localhost


## End Points
Vending machine actions are based on Restful Api. Below are end points to use the machine

**1- Insert Coin**: 

Method: Post

Example URL http://localhost/api/payments

Payload: JSON Object as below. Valid coins are 0.05, 0.10, 0.25, 1. 
```
{ "coin": 0.25 }
```

For valid response, HTTP status code 200 with object {"results":true} and status code 500 in case of any error on the server 


**2- Get Back Entered Coins** 

Method: Get 

Example URL http://localhost/api/payments

For valid response, HTTP status code 200 with the list of entered coins and status code 500 in case any error on the server.

**3- Add Available Change** 

Method: Post 

Example URL http://localhost/api/changes

Payload: JSON Object as below. 
```
{
	"coins": [0.05, 0.1, 0.25, 1]
}
```
**4- Add A New Product** 

Method: Post 

Example URL http://localhost/api/products
Payload: JSON Object as below. 

```
{
	"item_name": 2,
	"item_price": 0.65,
	"item_count": 10
}
```
**5- Get An Item** 

Method: Get

Example URLs http://localhost/api/products/water, http://localhost/api/products/juice, http://localhost/api/products/soda

Successful response will be as below otherwise erorr messages will be returned with proper status codes
```
{
    "results": "0.25, 0.1, water"
}
```

Call these services in correct order for example, first set available change, Add some new products, Insert coin (1 or multiple times) to purchase and Get and item.


## A brief introduction to project structure
Although the information below on the application structure is very brief, but it gives a starting point for the developers to work on the project


* **routes/api.php** Contains the routes for both end points

* **app/Http/Controllers** All controller files inside this directory handles the end points 

* **app/Domain/Entities/VendingMachine.php** Manage the business logic of vending machine, Also a middle man between controllers and models

* **app/Http/Requests** These files Contains custom validator for different type of request inputs. It validates request parameters (payload) before even starting the business logic

* **app/Infrastructure/Repositories and Contracts** Directories holds the storage repos. InMemoryStore (based on Redis) via Repository pattern

* **config/common.php** Holds configuration variables

* **test/Feature/** Folder contains the files for end point test cases

* **vendor** - Contains all the composer dependencies

For more details on the files structure, follow this docs https://laravel.com/docs/ link.

### Execute Tests
Execute below command to run the tests
```
./vendor/bin/phpunit
```

####Note: 
Current test cases covers only features testing. It can definitely be enhanced more and add more coverage including unit test cases as well. 

## References
Below link contains the best practices (Design principles and Design patterns specific to Laravel) and Coding standards which i have followed in this project. 

http://www.laravelbestpractices.com/
