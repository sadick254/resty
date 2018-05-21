# Routing

**Routing** refers to how an application’s endpoints (URIs) respond to client request.
Resty gives you a simple way do define your endpoints.

## Basics

```php
<?php
...
$app->get('/users', function ($req, $res) {
  $res->send('get');
});

$app->post('/users', function ($req, $res) {
  $res->send('post');
});

$app->put('/users', function ($req, $res) {
  $res->send('put');
});

$app->delete('/users', function ($req, $res) {
  $res->send('delete');
});
...
```

### Params

```php
...
$app->get('/users/:id', function ($req, $res) {
  $params = $req->getParams();
  $res->send("user id $params->id");
})
...
```

### Request Body

```php
...
$app->post('/users/:id', function ($req, $res) {
  $body = $req->getBody();
  $res->send($body);
})
...
```