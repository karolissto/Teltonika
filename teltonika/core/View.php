<?php
class View
{
    protected $view_file;                                               // Name of the view
    protected $view_data;                                               // View data
    protected $view_id;                                                 // View id (country's id for city management)

    public function __construct($view_file,$view_data=[],$id='')
    {
        $this->view_data = $view_data;                                  // Sets data for displaying
        $this->view_file = $view_file;                                  // Sets a name for the view
        $this->view_id = $id;                                           // Sets id (country's id for city management)
    }

    // Displays the view with it's data
    public function render(){
        if(file_exists(VIEW . $this->view_file . '.phtml'))     // Checks if a file with this view name exists
            include VIEW . $this->view_file . '.phtml';                  // If yes, includes the view file
    }

    // Gets the function name from the url
    public function getAction(){
        return (explode('/',$this->view_file)[1]);
    }
}