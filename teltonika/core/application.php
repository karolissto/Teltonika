<?php
include "autoload.php";

class application extends db
{
    protected $controller = 'homeController';                                              // Url controller part
    protected $action = 'index';                                                           // Url called function name
    protected $params = [];                                                                // Url parameters

    public function __construct()
    {
        $this->connect("localhost", "root", "1525354565Kk.", "teltonika");      // Connects to the database

        $this->prepareURL();                                                                // Calls prepareURL function

        if(file_exists(CONTROLLER . $this->controller . '.php')){                   // Checks if a file with this controller name exists

            $this->controller = new $this->controller;                                      // Creates a controller

            if(method_exists($this->controller,$this->action)){                             // Checks if this controller has this function
                call_user_func_array([$this->controller,$this->action],$this->params);      // If it does, calls it
            }
        }
    }

    // Splits the url to needed parts
    protected function prepareURL(){
        $request = trim($_SERVER['REQUEST_URI'], '/');                              // Trims current url
        if(!empty($request)){
            $url = explode('/',$request);
            $this->controller = isset($url[0]) ? $url[0].'Controller' : 'homeController';   // If controller part of the url is set, get it's name and set it to this controller variable, if not, set it to home controller
            $this->action = isset($url[1]) ? $url[1] : 'index';                             // If function part of the url is set, get it's name and set it to this action variable, if not, set it to home index
            unset($url[0],$url[1]);                                                         // Remove previous parts from the url
            $this->params = !empty($url) ? array_values($url) : [];                         // If there are any remaining variables add them to the params array
        }
    }
}