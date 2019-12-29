<?php

include "core/View.php";

class Controller
{
    protected $data;                                                // Data
    protected $view = "";                                           // Created view
    protected $id;                                                  // Country id

    // Creates a new view
    public function view($viewName){

        $this->view = new View($viewName,$this->data,$this->id);     // Creates a new view with given name, data and id
        return $this->view;                                          // Returns the created view
    }

    // Creates a new model
    public function model($modelName,$query,$id=''){
        if(file_exists(MODEL . $modelName . '.php')){       // Checks if a file with this model name exists
            require MODEL . $modelName . '.php';

            if(!empty($query))                                      // Checks if query variable is not empty
                $result = Db::queryDB($query)->fetchAll();          // If it's not, calls a db function with the created query name and fetches the result

            $sort = $_SESSION["sort"];                              // Gets session's 'sort' variable

            if(count($result) > 1) {                                // Checks is fetched result's array count is higher than 1
                foreach ($result as $row) {                         // If it is, cycles through the array
                    $model = new $modelName($row,$sort);            // Creates a model with given data
                    $this->data[] = $model;                         // Adds it to the data array
                }
            }
            else if(count($result) == 1){                           // If it's not, checks if it's equal to 1
                $this->data = new $modelName($result[0]);           // If true, creates a model with given data
            }
                                                                    // Jei negauna jokiu duomenu reiskia reikia persiusti id (salies) pagal kuri veliau bus galima pridet
            $this->id = $id;                                        // Sets this id to the given id (countries id, used for city management)
        }
    }
}