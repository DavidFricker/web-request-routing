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
The first parameter is the URI the client should naviagate to. The second arugment is the HTTP method they should request the URI with. The third argument can be an anonymus function or a string that identifies a method of a given class.

#### Directing to a class member
```PHP
$RouteContainer->set('/dashboard', RouteContainer::HTTP_METHOD_GET, 'getPage@Namespace\Vendor\Package\Controller\Dashboard');
```
#### Directing to an annonymus function
```PHP
$RouteContainer->set('/dashboard', RouteContainer::HTTP_METHOD_GET, function($Request){
  echo 'Welcome to your dashboard';
});
```

### Create a dynamic route for an anonymous function
Dynamic routes are defined in the same fashion as thier static counterparts. However in the defined route any parts that are sourned by curely braces will be parsed and passed to the called function through the request object. An example of format and usage can be seen below. 

```PHP
$RouteContainer->set('/confirm/{token}/complete', RouteContainer::HTTP_METHOD_GET, function($Request){
  echo 'Token: ' . $Request->getParsedUrlParameters('token');
});
```

## License
Released under the MIT license.

