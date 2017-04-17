<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

<h1 align="center">Hướng dẫn build project (trên Window)</h1>

<h4>1. Clone project: https://github.com/tqhung04/simple-laravel-crud.git</h4>
<h4>2. Download composer: https://getcomposer.org/download/</h4>
<h4>3. Cd tới thư mục chứa project, download các packages mà project sử dụng: <b style="color: #f4645f; padding: 5px; background: bisque;">composer install</b></h4>
<h4>4. Copy file .env.example ra file .env: <b style="color: #f4645f; padding: 5px; background: bisque;"> cp .env.example .env</b></h4>
<h4>5. Sửa các thông số trong file .env vừa tạo như: DB_DATABASE, DB_USERNAME, DB_PASSWORD v..v..</h4>
<h4>6. Generate key: <b style="color: #f4645f; padding: 5px; background: bisque;"> php artisan key:generate</b></h4>
<h4>7. Clear cache: <b style="color: #f4645f; padding: 5px; background: bisque;"> php artisan config:clear</b></h4>
<h4>8. Tạo Database và các row default: <b style="color: #f4645f; padding: 5px; background: bisque;"> php artisan migrate --seed</b></h4>
<h4>9. Khởi chạy serve: <b style="color: #f4645f; padding: 5px; background: bisque;">php artisan serve</b></h4>
<h4>10. Kết nối tới : http://127.0.0.1:8000/admin</h4>