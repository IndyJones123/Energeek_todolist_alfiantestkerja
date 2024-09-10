# PT Energeek

-   Alfian Dorif Murtadlo

This Project Is Priority To Asses Job In PT Energeek Surabaya Using Laravel 11 , Blade - Filamen (CMS),

## Laravel Dependecies Instalation

To install dependecies, run the following command. Dont forget to check if you are in the right directory.

```bash
  composer install
```

## NPM Module Instalation

To install dependecies, run the following command

```bash
  npm install
```

## Setting Database

Download .env that i have sent in email. and change the database local into your computer

Dont Forget To Paste in Project Root

Run this command to migrate the database using ORM that i already Built using postgreSQL

```bash
  php artisan migrate
```

## Make Admin Account For Filament

Run this command to add new admin account & fill the data.

```bash
php artisan make:filament-user
```

## Launch Seeder

Run this command to insert data category from seeder

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

Run This Code in new Terminal to run Unit Testing That I have been built. i also documented the rest api in postman.
here is the link : https://documenter.getpostman.com/view/34782433/2sAXjSz8si

```bash
   php artisan test
```

## Tech Stack

**Client:** Blade, Filamen

**Server:** Laravel
