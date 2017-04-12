# Web request routing
Lightweight PHP OOP web request routing system 

## Install
Using composer

`composer require DavidFricker/Router`

## Usage example 
### Create a static route
The following example creates a rate limiting bucket persisted in volatile memory identified by the $UID, which allows 5 requests in any 60 second window.

```PHP

```
### Create a dynamic route
Once you have created a rate limiter object as directed in the previous section simply call the `addDrop` method and check its return value. If the function returns true then the UID has not exceeded his or her allowed limit and so you may continue.

```PHP

```

### Create a route with anonymous function
Once you have created a rate limiter object as directed in the previous section simply call the `addDrop` method and check its return value. If the function returns true then the UID has not exceeded his or her allowed limit and so you may continue.

```PHP

```

## License
Released under the MIT license.

