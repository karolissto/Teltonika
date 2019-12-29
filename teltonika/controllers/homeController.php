<?php

include "core/Controller.php";

class homeController extends Controller
{
    // Shows index page
    public function index($id='',$name=''){
        $this->view('home/index');      // Creates a view

        $this->view->render();                    // Displays the view
    }

}