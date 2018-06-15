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

## Examples

Send html response

```php
$res->send('<b>ok</b>');
```

Send json response

```php
$data = [1, 2, 4];
$res->json($data);
```

Send contents of a file

```php
$file = './file.txt';
$res->sendFile($file);
```

Send file and trigger download on the client

```php
$file = './file.txt';
$res->download($file);
```

Set the response header

```php
$res->setHeader("Content-Type", "text/plain");
```

Set the http status code

```php
$res->setStatus(403)
```

Set cookie

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

Clear  cookie

```php
$res->clearCookie("age");
```