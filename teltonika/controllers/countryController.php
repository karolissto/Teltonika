<?php

include "core/autoload.php";

class countryController extends Controller
{
    // Shows all countries
    public function index($id='',$name='',$query=''){
        session_start();                                    // Start a session

        $sort = $_SESSION["sort"];                          // Get sort variable from session

        $_SESSION['limit'] = 10;                             // Set the number of objects to show on a page
        $limit = $_SESSION['limit'];
        if (isset($_GET["page"])) {                         // Check if page number has been pressed
            $pn  = $_GET["page"];                           // If yes, get it
        }
        else {
            $pn=1;                                          // If no, set to 1
        };

        $start_from = ($pn-1) * $limit;                     // Get a number from which to get objects

        if($query == ''){                                   // If query variable is empty create a query that gets all countries
            $query = "
                        SELECT *
                        FROM `Salis`                     
                        ORDER BY `pavadinimas` ".$sort."
                        LIMIT $start_from, $limit
                        
                ";

            $_SESSION['from'] = '';                         // Set session variables to be empty
            $_SESSION['to'] = '';
        } else{                                             // If not, add order and limit parts to it (query comes from filter function)
            $query .= "ORDER BY `pavadinimas` ".$sort."
                        LIMIT $start_from, $limit";

        }
        $this->execute($query, 'index');     // Call execute function with given variables
    }

    // Sorts countries
    public function sortCountries($id='',$name=''){
        session_start();                                    // Start a session

        if (!isset($_GET["page"])) {                        // Check if page number has been pressed
            if($_SESSION["sort"] == 'DESC'){                // Check if session's variable 'sort' is equal to 'DESC'
                $_SESSION["sort"] = 'ASC';                  // If yes, change it to 'ASC'
            }
            else {
                $_SESSION["sort"] = 'DESC';                 // If not, leave it the same
            }
        }

        $this->filter();                                    // Call filter function
    }

    // Shows one country
    public function show($id='',$name=''){
        if(ctype_alnum($id)) {
            $query = '                                
                        SELECT *
                        FROM `Salis`
                        WHERE `id` = "' . $id . '"
                ';

            $this->execute($query, 'show');      // Call execute function with given variables
        } else{
            $this->error();
        }
    }

    // Shows one country's edit page with it's information
    public function edit($id='',$name=''){
        if(ctype_alnum($id)) {
            $query = '
                        SELECT *
                        FROM `Salis`
                        WHERE `id` = "' . $id . '"
                ';

            $this->execute($query, 'edit');      // Call execute function with given variables
        } else{
            $this->error();
        }
    }

    // Edits a country
    public function doEdit($id='',$name=''){
        if (isset($_POST['name']) && isset($_POST['area']) && isset($_POST['population']) && isset($_POST['phone_code'])){      // Check if these variables have been set (submit button pressed in edit view)
            if(ctype_alnum($_POST['name']) && ctype_alnum($_POST['area']) && ctype_alnum($_POST['population']) && ctype_alnum($_POST['phone_code'])) {
                $name = $_POST['name'];
                $area = $_POST['area'];
                $population = $_POST['population'];
                $phone_code = $_POST['phone_code'];
                $query = "UPDATE `Salis` 
                        SET `pavadinimas` = '$name' , `plotas` = $area, `gyventojai` = $population, `tel_kodas` = $phone_code, `sukurtas` = '" . date('Y-m-d') . "'
                        WHERE `Salis`.`id` = '$id'";

                Db::queryDB($query);                                // Call database's function

                $this->index();                                     // Call index function
            } else {
                $this->error();
            }

        }

    }

    // Deletes a country
    public function delete($id='',$name='')
    {
        if(ctype_alnum($id)) {
            $query = '
                       DELETE
                       FROM `Salis` 
                       WHERE `Salis`.`id` = "' . $id . '"
                ';

            Db::queryDB($query);                               // Call database's function


            $this->view('country/delete');            // Call function view, that creates a new view

            $this->view->render();                              // Call view's function render, that displays the view's content
        } else{
            $this->error();
        }
    }

    // Displays add view's content
    public function add($id='',$name='')
    {
        $this->view('country/add');               // Call function view, that creates a new view

        $this->view->render();                              // Call view's function render, that displays the view's content
    }

    // Adds a country
    public function doAdd($id='',$name=''){
        if (isset($_POST['name']) && isset($_POST['area']) && isset($_POST['population']) && isset($_POST['phone_code'])){      // Check if these variables have been set (submit button pressed in add view)
            if(ctype_alnum($_POST['name']) && ctype_alnum($_POST['area']) && ctype_alnum($_POST['population']) && ctype_alnum($_POST['phone_code'])) {
                $name = $_POST['name'];
                $area = $_POST['area'];
                $population = $_POST['population'];
                $phone_code = $_POST['phone_code'];
                $sql = 'INSERT INTO `Salis` (`id`, `pavadinimas`, `plotas`, `gyventojai`, `tel_kodas`, `sukurtas`) 
                    VALUES (NULL, \'' . $name . '\', \'' . $area . '\', \'' . $population . '\', \'' . $phone_code . '\', \'' . date("Y-m-d") . '\')';

                Db::queryDB($sql);                             // Call database's function
            } else {
                $this->error();
            }
        }

        $this->index();                                     // Call index function
    }

    // Searches for a country
    public function search($id='',$name=''){
        if (isset($_POST['search']) && ctype_alnum($_POST['search'])){                      // Check if search variable has been set (search button pressed in index view)
            $search = $_POST['search'];
            $query = '
                        SELECT *
                        FROM `Salis`
                        WHERE `pavadinimas` = "'.$search.'"
                        
                        
                ';
            $this->index('','',$query);         // Call index function with given variables
        } else {
            $this->error();
        }
    }

    // Filters data
    public function filter(){
        session_start();                                    // Start a session
        if(isset($_POST['from']) && isset($_POST['to']) ){   // Check if these variables have been set (filter button pressed in index view)
            $_SESSION['from'] = $_POST['from'];             // Set session variables
            $_SESSION['to'] = $_POST['to'];

            $query = "
                        SELECT *
                        FROM `Salis`
                        WHERE `Salis`.`sukurtas` BETWEEN '".$_SESSION['from']."' AND '".$_SESSION['to']."'
                       

                ";

            $this->index('','',$query);           // Call index function with given variables

        } else if($_SESSION['from'] != '' && $_SESSION['to'] != ''){        // If not, check if these session variables have been set (that's for filtering in other pages)
            $query = "
                        SELECT *
                        FROM `Salis`
                        WHERE `Salis`.`sukurtas` BETWEEN '".$_SESSION['from']."' AND '".$_SESSION['to']."'
                       

                ";

            $this->index('','',$query);           // Call index function with given variables

        } else $this->index();                              // If none of the previous statements were true, just call index function

    }

    // Displays error
    public function error(){
        $this->view('error');
        $this->view->render();
    }
    //  Creates a model and a view
    public function execute($query, $funcName){
        $this->model('country',$query);           // Creates a model and a view
        $this->view('country/' . $funcName);                  // Creates a view
        $this->view->render();                                          // Displays the view
    }


}