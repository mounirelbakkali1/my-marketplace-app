#PetsPlaza (REST API only)



## Prerequisites

Before you can run this application, you need to have the following installed on your machine:

=> PHP 8.1 or higher
=> Composer
=> MySQL
=> Node.js
=> npm



## installation 

1. Clone the repository : 

```git clone https://github.com/your-username/my-laravel-app.git```



2. Install the project dependencies using Composer:

 ```
 
cd my-laravel-app
composer install

```


3. Copy the .env.example file to .env and update the database configuration:

```

cp .env.example .env
nano .env


```


4. Generate the application key:


```

php artisan key:generate


```


5. Run the database migrations:

```

php artisan migrate


```


6. Generate a JWT authentication secret by running the following command:


```

php artisan jwt:secret


```


6. Run the database migrations:


```

php artisan db:seed


```


## Usage : 

To start the application, run the following command:


```

php artisan serve


```




