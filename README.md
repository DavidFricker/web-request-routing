# Web request routing
Lightweight PHP OOP web request routing system 

## Install
Using composer

`composer require DavidFricker/Router`

## Usage example 
Before any requests can be routed they must be defined and stored within a RouteContainer object.
```PHP
use DavidFricker\Router\Capsule\RouteContainer;

$RouteContainer = DavidFricker\Router\Capsule\RouteContainer::init();
```

### Create a static route
The following line will create a static route. Static routes are those without any dynamic components that require parsing. 
The first argument is the URI the client should navigate to. The second argument is the HTTP method they should use to request the. The third argument can be an anonymous function or a string that identifies a method of a given class.

#### Directing to a class member
```PHP
// the method, in this instance `getPage`, should accept a $Request object as its single parameter
$RouteContainer->set('/dashboard', RouteContainer::HTTP_METHOD_GET, 'getPage@Namespace\Vendor\Package\Controller\Dashboard');
```

#### Directing to an anonymous function
```PHP
$RouteContainer->set('/dashboard', RouteContainer::HTTP_METHOD_GET, function($Request){
  echo 'Welcome to your dashboard';
});
```

### Create a dynamic route
Dynamic routes are defined in the same fashion as their static counterparts. However, in the defined route any parts that are surrounded by curly braces will be parsed and passed to the called function through the `Request` object. An example of format and usage can be seen below. 

```PHP
$RouteContainer->set('/confirm/{token}/complete', RouteContainer::HTTP_METHOD_GET, function($Request){
  echo 'Token: ' . $Request->getParsedUrlParameters('token');
});
```

## License
Released under the MIT license.
