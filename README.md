<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Test App

This test is developed for the purpose of testing for a PHP job.

Build in Laravel

- It fetches company symbol data from another JSON API, caches it, and displays it on the form.
- It takes input from the user and validates the input both front-end and back-end.
- After validating the form data, it sends an email and redirects the user back with the sucessful status
- It fetches historical data on user-based selections, whatever the user selected in the previous form.
- It displays the historical data in charts and a data table.

## How to run

Use the following commands to run the app:

- composer update
- docker build -t php-exercise .
- docker run -p 8000:80 php-exercise OR docker run -p 8000:80 imageID

## Run test

Use the following command to run the tests:

- docker run php-excercise vendor/bin/phpunit

## Env file

It's not recommended to push the.env file along with the project, so I'll send it separately via email.

## Some Todo lists for the same task

There are some ideal scenarios that kept running through my mind, but due to a shortage of time, I didn't implement them.

After submitting the form, the ideal case would be to send an email using events, so the user will not wait for the response.

All requests should be managed by Jquery without page loading.
