<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About My Laravel Blog

This a simple implementation of a Blog Using Laravel 10.9 with the following functionalities:

- User Authentication using Laravel Breeze.
- Display a list of all posts on the homepage, sorted by newest first.
- Signed-In Users can create new posts.
- Users can comment on posts.
- Users can click on a post to view its details, including its comments.
- Search functionality so that users can search for posts based on keywords in the title or body.
- Users can edit and delete their own posts.
- Pagination on the homepage so that only a certain number of posts are displayed per page.
- PHPUnit tests are implemented to test the functionalities.

## How to Run this application

As the Laravel version is 10.9. The minimum PHP requirement is 8.1.

Clone GitHub repo for this project locally using the following command.

```bash
git clone https://github.com/omerfayyaz/Laravel-Blog.git my-laravel-blog
```

Go to your project directory i.e. "my-laravel-blog".

```bash
cd my-laravel-blog
```

Install Composer Dependencies.

```bash
composer install
```
Install NPM Dependencies.

```bash
npm install
```
Compile application's frontend assets.

```bash
npm run build
```
Create .env file from .env.example file

```bash
cp .env.example .env
```
Generate an app encryption key

```bash
php artisan key:generate
```
Create an empty database for our application and add database information in the .env file to allow Laravel to connect to the database.

Migrate the database

```bash
php artisan migrate
```
[Optional]: Seed the database with dummy Users, Posts and Comments.

```bash
php artisan db:seed
```

## PHPUnit Testing

Run the following command to perform the testing.

```bash
php artisan test
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
