## Panda Shop

A demo "skeleton" store for Panda & minion related products.

## Guidelines

Seeds 8 demo products, 4 categories and one admin user.

Login to the admin user with: test@test.com:1234567890
The admin user has /home which lists shop customers and allows the admin to delete their customer information.

- Additional users (besides the admin) are logged in and sent directly to the store homepage.
- The checkout process saves the orders but DOES NOT display the order details.
- Customer information can only be edited by the customer.
- Customers are only allowed to edit and delete their own products and categories
- Products created by customers CANNOT be purchased by them.
- SQLITE requires DB_FOREIGN_KEYS=true

## Installlation
1. Clone the repo and `cd` into it
1. `composer install`
1. Rename or copy `.env.example` file to `.env`
1. `php artisan key:generate`
1. Set your database credentials in your `.env` file
1. `php artisan migrate`
1. `php artisan db:seed`
1. `npm install`
1. `npm run dev`
1. `php artisan serve` or any other alternative