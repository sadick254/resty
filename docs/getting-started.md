# Resty

A fast, minimal with zero dependancies php router that enables you write straight forward rest api's.

## Features

* Routing
* Middleware

## Getting Started

### Installation

The recomended way of installing Resty is through [Composer](https://getcomposer.org/)

```bash
composer require sadick/resty
```

### Minimal Example

```php
<?php
require 'vendor/autoload.php';
use Resty\Router;

$app = new Router();
$app->get('/users', function ($req, $res) {
  $res->send('Hello World');
});

$app->serve();

```

You can test that your requests are being served using the built in php server

```bash
php -S localhost:4000
```

Navigating to [http://localhost:4000/users]() will display `hello world`