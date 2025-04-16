<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">نظام إدارة الطلبات الداخلي</h1>



---

##  خطوات تشغيل المشروع

### 1. استنساخ المشروع
```bash
git clone https://github.com/amatalaziz/test.git
cd internal-requests-system
composer install
npm install
php artisan migrate
php artisan migrate --seed
npm run dev
php artisan serve




http://127.0.0.1:8000

## role 
# admin account
amat@gmail.com
12345678

user
client2@gmail.com
12345678

user2
client@hmail.com
12345678

# create new account 
http://127.0.0.1:8000/register
