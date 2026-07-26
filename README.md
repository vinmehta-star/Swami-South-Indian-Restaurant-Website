# Swami - South Indian Restaurant Website

A PHP-based web application for a South Indian restaurant, allowing customers to browse the menu, manage a cart, and place orders online.

## Overview

Swami is a dynamic restaurant website built with PHP and MySQL. It provides a full customer-facing ordering flow — from account registration and login, through browsing the shop/menu, to cart management and checkout — along with informational pages like About and Contact.

## Features

- **User Authentication:** Register, log in, and log out (`register.php`, `login.php`, `logout.php`)
- **Menu / Shop:** Browse South Indian dishes such as dosas, idli, vada, thali, rasam, and appam (`shop.php`)
- **Cart Management:** Add items to cart, update quantities, and view cart contents (`add_to_cart.php`, `update_cart.php`, `get_cart.php`, `cart.php`)
- **Checkout & Orders:** Place orders and view order confirmation (`checkout.php`, `place_order.php`, `order_success.php`)
- **Informational Pages:** About and Contact pages (`about.php`, `contact.php`)
- **Dynamic Frontend Behavior:** Client-side interactivity via `script.js` and `angular-app.js`

## Tech Stack

- **Backend:** PHP (mysqli for database access)
- **Database:** MySQL (database name: `swami`)
- **Frontend:** HTML, CSS (`style.css`), JavaScript, AngularJS (`angular-app.js`)

## Project Structure

```
SwamiProject/
├── images/                 # Menu and site images (logo, dishes, hero banner, etc.)
├── db_connect.php          # MySQL database connection
├── index.php                # Homepage
├── shop.php                 # Menu / shop listing
├── about.php                 # About page
├── contact.php                # Contact page
├── register.php / login.php / logout.php   # User authentication
├── cart.php / add_to_cart.php / update_cart.php / get_cart.php   # Cart management
├── checkout.php / place_order.php / order_success.php   # Checkout & order flow
├── style.css
├── script.js
└── angular-app.js
```

## Getting Started

### Prerequisites
- A local server environment with PHP and MySQL (e.g., XAMPP, WAMP, or MAMP)
- A MySQL database named `swami`

### Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/vinmehta-star/Swami-South-Indian-Restaurant-Website.git
   ```
2. Move the `SwamiProject` folder into your local server's web root (e.g., `htdocs` for XAMPP).
3. Create a MySQL database named `swami` and import the required tables (users, cart, orders, etc.) as used by the PHP files.
4. Update `db_connect.php` if your MySQL credentials differ from the defaults (`root` with no password).
5. Start Apache and MySQL, then open the project in your browser, e.g.:
   ```
   http://localhost/SwamiProject/index.php
   ```

## Author

Vin Mehta
