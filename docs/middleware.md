# Middleware

HTTP middleware provide a convenient mechanism for catching HTTP requests entering your application.
Middlewares can be used for authentication, loging, changing requests or response and any many more.

## Writting A Middleware

Middleware functions are functions that have access to the request object (req), the response object (res), and the next function in the application’s request-response cycle.

If the current middleware function does not end the request-response cycle, it must call next() to pass control to the next middleware function. Otherwise, the request will be left hanging.

```php
<?php
...
// a simple structure of a middleware
$logger = function ($req, $req, $next) {
  echo "logging middleware\r\n";
  $next();
};
...
```

### Application wide Middleware

This middleware will run before the callback of a route is executed

```php
<?php
...
$app->use($logger);
...
```

### Route Specific Middleware

This middleware will run when a client a request to the route

```php
<?php
...
$app->use('/users', $logger);
...
```

Register the middleware when defining the route

```php
<?php
...
$app->get('/users', $logger, function ($req, $res) {
  $res->send('users with middleware');
});
...
```

### Middleware Before And After

Register a middleware to run before and after the route callback is called. Its as easy as placing the
middlewares before and after the callback;

```php
<?php
...
$after = function ($req, $res, $next) {
  echo "after middleware";
  $next();
}

$app->get('/users', $logger, function ($req, $res) {
  $res->send('users with middleware');
}, $after);
...
```

### Multiple Middlewares

Register more than one middleware on a route

```php
<?php
...
$app->get('/users', $logger, $after, function ($req, $res) {
  $res->send('mutliple middlewares');
});
...
```
