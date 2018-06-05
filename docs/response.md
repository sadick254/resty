# Response

Represents the `http` response that your rest api sends to the client.

```php
use Resty\Router;
use Resty\Request;
use Resty\Response;

$api = new Router();
$api->get(/*route*/, function (Request $req, Response $res) {
  // use the response object
})
```

## Response API Methods

### `$res->send(data)`

Sends html response to the client

```php
$res->send('<b>ok</b>');
```

### `$res->json(data)`

Sends a json response

```php
$data = [1, 2, 4];
$res->json($data);
```

### `$res->sendFile(path)`

Sends the contents of the file

```php
$file = './file.txt';
$res->sendFile($file);
```

### `$res->download(path)`

Sends the file and triggers download on the client

```php
$file = './file.txt';
$res->download($file);
```

### `$res->setHeader(type, value)`

Sets the response header

```php
$res->setHeader("Content-Type", "text/plain");
```

### `$res->setStatus(code)`

Sets the http status code

```php
$res->setStatus(403)
```

### `$res->setCookie($name,$value, $options)`

Sets cookie

```php
$res->setCookie("name","sadick");
// options
$options = [
  'expiry' => time() + (86400 * 30),
  'path' => '/admin',
  'domain' => 'domain.com',
  'secure' => true
];

$res->setCookie("age", "3", $options);
```

### `$res->clearCookie(name)`

Clears/Deletes a cookie

```php
$res->clearCookie("age");
```