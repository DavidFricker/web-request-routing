<?php

namespace DavidFricker\Router\Capsule;

/**
  * A representation of a HTTP request
  *
  * Stores and allows easy access to common important variables of a HTTP request.
  */
class Request {
    /**
     * url parts stored in an array e.g. example.com/path/to/resource becomes ['path','to','resource']
     * @var array
     */
    private $url_elements;

    /**
     * Parsed parts of the dynamic routes
     * @var array
     */
    private $parsed_url_elements;

    /**
     * Prased input from $_POST, $_GET, or php://input
     * @var array
     */
    private $request_parameters;

    /**
     * HTTP Request method
     * @var string
     */
    private $http_method;
    
    /**
     * Gathers HTTP request information
     */
    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];

        if (isset($_SERVER['PATH_INFO'])) {
            $this->url_elements = explode('/', trim($_SERVER['PATH_INFO'], '/'));
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

    /**
     * Getter method for the HTTP request method
     * 
     * @return string HTTP request method 
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Fetch parts of the URL/path
     *
     * Indexed from zero. The path elements are split around '/'.
     * @example path /path/to/page, getUrlElements(1) would return the string 'to'
     * 
     * @param  integer $index index of the array of path elements 
     * @return string         path element
     */
    public function getUrlElements($index=-1) {
        if ($index == -1) {
            return $this->url_elements;
        }
        
        if (count($this->url_elements) > $index) {
            return $this->url_elements[$index];
        }

        return false;        
    }

    /**
     * Fetch parameters sent with the request
     *
     * Acts similarly to the $_REQUEST array.
     * 
     * @param  string $index name of the variable you would like the value for
     * @return string        value found at the indexed location, or false
     */
    public function getParameters($index = '') {
        if ($index == '') {
            return $this->parameters;
        }
        
        if (isset($this->parameters[$index])) {
            return $this->parameters[$index];
        }

        return false;
    }

    /**
     * Set array of parsed URL elements
     *
     * Used by the Router class, stores the result of parsing the request path from the client using the template route path.
     *
     * @example if the template route path were 'path/to/article/{article_id}', the actual route path were 'path/to/article/4455', then the array [article_id => 4455] would be passed to this method
     * 
     * @param array $parsed_url_elements an associative array of path elements and parsed values
     */
    public function setParsedUrlParameters($parsed_url_elements) {
        $this->parsed_url_elements = $parsed_url_elements;
    }

    /**
     * Fetch parsed elements of the request path
     *
     * Returns values from the array set by the Router class using the setParsedUrlParameters() method.
     *
     * @example if the template route path were 'path/to/article/{article_id}', the actual route path were 'path/to/article/4455', then the array [article_id => 4455] would be passed to this method
     * 
     * @param  string $index path element, such as 'article_id' in the example
     * @return string        value found at the indexed location, or false
     */
    public function getParsedUrlParameters($index = '') {
        if ($index == '') {
            return $this->parsed_url_elements;
        }
        
        if (isset($this->parsed_url_elements[$index])) {
            return $this->parsed_url_elements[$index];
        }

        return false; 
    }
}
