Implementing JSON Web Token (JWT) in laravel 10 


## install required packages

```composer require php-open-source-saver/jwt-auth```


## publish the config file

```php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
```

## generate the secret key

```php artisan jwt:secret
```

## configure the JWT AuthGuard in config/auth.php

by adding in guards array: 

```'api'=>[
        'driver' => 'jwt',
        'provider' => 'users',
    ],
```


## changing the default user model

by implementing the ```PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject``` interface in your user model
and overriding the ```getJWTIdentifier()``` and ```getJWTCustomClaims()``` methods.


## creating AuthController

```php artisan make:controller AuthController
```
