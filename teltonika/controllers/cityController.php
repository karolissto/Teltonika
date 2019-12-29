<?php

include "core/autoload.php";

class cityController extends Controller
{
    // Shows all cities
    public function index($id='',$name='', $query=''){
        session_start();                                    // Start a session

        $sort = $_SESSION["sortCities"];                    // Get sort variable from session

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
            $query = '
                        SELECT *
                        FROM `Miestas`
                        WHERE `Miestas`.`salis_fk` = "'.$id.'"
                        ORDER BY `pavadinimas` '.$sort.'
                        LIMIT  '.$start_from.', '.$limit.'
                ';
            $_SESSION['fromCity'] = '';                     // Set session variables to be empty
            $_SESSION['toCity'] = '';
        } else{                                             // If not, add order and limit parts to it (query comes from filter function)
            $query .= "ORDER BY `pavadinimas` ".$sort."
                        LIMIT $start_from, $limit";

        }

        $this->execute($query, 'index', $id);      // Call execute function with given variables
    }

    // Shows one city
    public function show($id='',$name=''){
        if(ctype_alnum($id)) {
            $query = '
                            SELECT *
                            FROM `Miestas`
                            WHERE `id` = "'.$id.'"
                    ';
            $this->execute($query,  'show');              // Call execute function with given variables
        } else{
            $this->index();
        }
    }

    // Shows one city's edit page with it's information
    public function edit($id='',$name=''){
        if(ctype_alnum($id)) {
            $query = '
                        SELECT *
                        FROM `Miestas`
                        WHERE `id` = "' . $id . '"
                ';
            $this->execute($query, 'edit', $id);          // Call execute function with given variables
        } else{
            $this->error();
        }
    }

    // Edits a city
    public function doEdit($id='',$name='')
    {
        if (isset($_POST['name']) && isset($_POST['area']) && isset($_POST['population']) && isset($_POST['post_code'])) {      // Check if these variables have been set (submit button pressed in edit view)
            if(ctype_alnum($_POST['name']) && ctype_alnum($_POST['area']) && ctype_alnum($_POST['population']) && ctype_alnum($_POST['post_code'])) {
                $name = $_POST['name'];
                $area = $_POST['area'];
                $population = $_POST['population'];
                $post_code = $_POST['post_code'];
                $query = 'UPDATE `Miestas` 
                    SET `pavadinimas` = "' . $name . '" , `plotas` = ' . $area . ', `gyventojai` = ' . $population . ', `pasto_kodas` = ' . $post_code . ', `sukurtas` = "' . date("Y-m-d") . '"
                    WHERE `Miestas`.`id` = ' . $id . '';
                Db::queryDB($query);                           // Call database's function

                $this->show($id);                                   // Call show function with city's id
            } else{
                $this->error();
            }

        }

    }

    // Deletes a city
    public function delete($id='',$name=''){
        if(ctype_alnum($id)) {
            $query = '
                       DELETE
                       FROM `Miestas` 
                       WHERE `Miestas`.`id` = "' . $id . '"
                ';
            $this->execute($query, 'delete');            // Call execute function with given variables
        } else{
            $this->error();
        }
    }

    // Displays add view's content
    public function add($id='',$name=''){
        $this->execute('', 'add', $id);       // Call execute function with given variables
    }

    // Adds a city
    public function doAdd($id='',$name=''){
        if (isset($_POST['name']) && isset($_POST['area']) && isset($_POST['population']) && isset($_POST['post_code'])) {      // Check if these variables have been set (submit button pressed in add view)
            if(ctype_alnum($_POST['name']) && ctype_alnum($_POST['area']) && ctype_alnum($_POST['population']) && ctype_alnum($_POST['post_code'])) {
                $name = $_POST['name'];
                $area = $_POST['area'];
                $population = $_POST['population'];
                $post_code = $_POST['post_code'];
                $query = 'INSERT INTO `Miestas` (`id`, `pavadinimas`, `plotas`, `gyventojai`, `pasto_kodas`, `sukurtas`, `salis_fk`) 
            VALUES (NULL, \'' . $name . '\', \'' . $area . '\', \'' . $population . '\', \'' . $post_code . '\', \'' . date("Y-m-d") . '\', ' . $id . ')';

                Db::queryDB($query);                           // Call database's function

                $this->index($id);                              // Call show function with country's id
            } else{
                $this->error();
            }
        }
    }

    // Sorts countries
    public function sortCities($id='',$name=''){
        session_start();                                    // Start a session

        if (!isset($_GET["page"])) {                        // Check if page number has been pressed
            if($_SESSION["sortCities"] == 'DESC'){          // Check if session's variable 'sortCities' is equal to 'DESC'
                $_SESSION["sortCities"] = 'ASC';            // If yes, change it to 'ASC'
            }
            else{
                $_SESSION["sortCities"] = 'DESC';           // If not, leave it the same
            }
        }

        $this->filter($id);                                 // Call show function with country's id
    }

    // Searches for a country
    public function search($id='',$name=''){
        if (isset($_POST['search']) && ctype_alnum($_POST['search'])){                       // Check if search variable has been set (search button pressed in index view)
            $search = $_POST['search'];
            $query = '
                        SELECT *
                        FROM `Miestas`
                        WHERE `pavadinimas` = "'.$search.'" AND `salis_fk` = "'.$id.'"
                        
                ';

            $this->index($id,'',$query);              // Call index function with given variables
        }
    }

    // Filters data
    public function filter($id='',$name=''){
        session_start();                                    // Start a session

        if(isset($_POST['from']) && isset($_POST['to'])){   // Check if these variables have been set (filter button pressed in index view)
            $_SESSION['fromCity'] = $_POST['from'];         // Set session variables
            $_SESSION['toCity'] = $_POST['to'];

            $query = "
                        SELECT *
                        FROM `Miestas`
                        WHERE `Miestas`.`sukurtas` BETWEEN '".$_SESSION['fromCity']."' AND '".$_SESSION['toCity']."' AND `salis_fk` = ".$id."
                       

                ";

            $this->index($id,'',$query);              // Call index function with given variables
        } else if($_SESSION['fromCity'] != '' && $_SESSION['toCity'] != ''){        // If not, check if these session variables have been set (that's for filtering in other pages)
            $query = "
                        SELECT *
                        FROM `Miestas`
                        WHERE `Miestas`.`sukurtas` BETWEEN '".$_SESSION['fromCity']."' AND '".$_SESSION['toCity']."' AND `salis_fk` = ".$id."
                       

                ";

            $this->index($id,'',$query);             // Call index function with given variables
        } else {
            $this->index($id);                             // If none of the previous statements were true, just call index function
        }
    }

    // Displays error
    public function error(){
        $this->view('error');
        $this->view->render();
    }

    //  Creates a model and a view
    public function execute($query, $funcName, $id=''){
        $this->model('city',$query,$id);                    // Creates a model and a view
        $this->view('city/' . $funcName);                    // Creates a view
        $this->view->render();                                         // Displays the view
    }
}