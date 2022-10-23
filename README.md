<p align="center" dir="auto" style="text-align:center">
    <a href="https://laravel.com" rel="nofollow">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" style="max-width: 100%;">
    </a>
</p>

# sapienza

## Installation

Clone the repository

```bash
$ git clone git@gitlab.com:iroid-web-team/sapienza-webapp.git
```

Once installed, Switch to the repo folder

```bash
cd sapienza-webapp
```

Install all the dependencies using composer

```bash
composer install
```

Copy the example env file and make the required configuration changes in the .env file

```bash
cp .env.example .env
```

Generate a new application key

```bash
php artisan key:generate
```

Run the database migrations (**Set the database connection in .env before migrating**)

```bash
php artisan migrate
```

Generate a new passport authentication secret key

```bash
php artisan passport:install
```

## Authentication

This applications uses JSON Web Token (JWT) to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The JWT authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about JWT.

-   https://jwt.io/introduction/
-   https://self-issued.info/docs/draft-ietf-oauth-json-web-token.html
