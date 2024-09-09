# PT Energeek

-   Alfian Dorif Murtadlo

This Project Is Priority To Asses Job In PT Energeek Surabaya Using Laravel 11 , Blade - Filamen (CMS),

## Laravel Dependecies Instalation

To install dependecies, run the following command

```bash
  composer require Laravel
```

## NPM Module Instalation

To install dependecies, run the following command

```bash
  npm install
```

## Setting Database

Download .env that i have sent in email. and change the database local into your computer or u can just uncomment my Supabase Key if u willing so.

Dont Forget To Paste in Project Root

if u want to use it in your local try this command to migrate the database using ORM that i already Built

```bash
  php artisan migrate
```

## Make Admin User For Filament

```bash
php artisan make:filament-user
```

## Launch Seeder

```bash
php artisan db:seed --class=CategorySeeder
```

## Running Website Locally

To run the program, run the following command

```bash
  php artisan serve
```

The Style Might Not Appear So Do the following command since iam using tailwind

```bash
  npm run dev
```

## Running Test

```bash
   php artisan test --filter RegisterTest
```

## Tech Stack

**Client:** Blade, Filamen

**Server:** Laravel
