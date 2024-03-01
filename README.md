<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Enviroment:

```bash
$ PHP v8.1.10
$ Laravel v10.44.0
```

## Installation

From the command line, run:

```
composer install
```
## Configuration

Run the migrations:

```
php artisan migrate
```

Run the seeders:

```
php artisan make:seeder RoleSeeder

php artisan make:seeder AdminUserSeeder
```

Run the passport:

```
php artisan passport:client --personal
```

Run the server:

```
php artisan serve
```

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
