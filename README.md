# Web request routing
A standalone lightweight web request routing system. 

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

## Request class reference

#### getMethod
Getter method for the HTTP request method
returns `string` HTTP request method 

#### getUrlElements
Fetch a single part of the path or all in the form of an array. To fetch all parts in an array supply no arguments. To fetch a single part supply the numeric index of the expected position of the part starting from zero. The path elements are split around '/'.

For example, the `Request` object for the URI `/path/to/page` would return the string 'to' when calling `getUrlElements(1)`.

#### getParameters
Fetch parameters sent with the request. This method acts similarly to the $_REQUEST array. 
To fetch all parameters in an array supply no arguments. To fetch a single value supply the parameter key (in the same way you would fetch a value from the $_POST or $_GET arrays).

#### getParsedUrlParameters
Fetch parsed elements of the request path. Returns the parsed value from the request URI using the request route.
For example, if the template route path were 'path/to/article/{article_id}', the requested URI were 'path/to/article/4455', then the array [article_id => 4455] would be passed to this method. This would then be accessible by the following method call `getParsedUrlParameters('article_id')`

## Bugs
Bug reports welcome, please included details to reproduce the bugs. Commits are also very welcome for bug fixes, features, or refactoring. 

## License
Released under the MIT license.
