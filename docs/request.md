# Request

Represents the `http` request that your client sends to the server.

```php
use Resty\Router;
use Resty\Request;
use Resty\Response;

$api = new Router();
$api->get(/*route*/, function (Request $req, Response $res) {
  // use the request object
})
```

## Examples

Get request body

```php
$req->getBody();
```

Get request query parameters

```php
$req->getQueryParams();
```

Get request parameter variables

```php
// assumung you have a route like /user/:userId
// to get the userId param
$params = $req->getParams();
$params->userId;
```

Get request cookies

```php
// assumung you have a route like /user/:userId
// to get the userId param
$cookies = $req->getCookies();
```

Get client ip address

```php
// assumung you have a route like /user/:userId
// to get the userId param
$ip = $req->getIP();
```