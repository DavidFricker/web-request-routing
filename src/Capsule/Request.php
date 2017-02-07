<?php
namespace DavidFricker\Router;

/**
  * A wrapper around a DB driver to expose a uniform interface
  *
  * Bassically an abstraction over the complexity of the PDO class, but by design this could wrap any strctured storage mechanism 
  * A database engine adapter
  *
  * @param string $myArgument With a *description* of this argument, these may also
  *    span multiple lines.
  *
  * @return void
  *
 *
 */
class Request {
    // url parts stored in an array e.g. example.com/path/to/resource becomes ['path','to','resource']
    private $url_elements;
    private $request_parameters;
    private $http_method;
    
    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];

        if (isset($_SERVER['PATH_INFO'])) {
            $this->url_elements = explode(DIRECTORY_SEPARATOR, trim($_SERVER['PATH_INFO'], DIRECTORY_SEPARATOR));
        }
        
        switch($this->getMethod()) {
            case 'GET':
                $this->parameters = $_GET;
                break;
                
            case 'POST':
                $this->parameters = $_POST;
                break;

            case 'PUT':       
            case 'DELETE':
                $this->parameters = file_get_contents('php://input');
                break;

            default:
                break;
        }
    }

    public function getMethod() {
        return $this->method;
    }

    public function getUrlElements($index=-1) {
        if ($index == -1) {
            return $this->url_elements;
        }
        
        if (count($this->url_elements) > $index) {
            return $this->url_elements[$index];
        }

        return false;        
    }

    public function getParameters($index = '') {
        if ($index == '') {
            return $this->parameters;
        }
        
        if (isset($this->parameters[$index])) {
            return $this->parameters[$index];
        }

        return false;
    }
}