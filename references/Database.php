<?php

class Database
{

  //Initialize vairables
  private $con;
  private $table;

  //Get connection and database variable
  public function __construct($con)
  {
    $this->con = $con;
  }

  //Method to search for a specific row
  public function searchData($table, $column, $value)
  {
    //Converts value to a usuable form in the SQL statement
    $value = "'" . $value . "'";

    //Creates SQL command to get the data from a specific row 
    $sql = "SELECT * FROM "  . $table . " WHERE " . $column . " = " . $value;
    
    //Executes SQL command
    $res = mysqli_query($this->con, $sql);

    //If command is succesful, return the collected data as an associative array
    if ($res == true)
    {
      $row = mysqli_fetch_assoc($res);
      return $row;
    }

  }

  //Method to search for all data in a column
  public function getData($table, $column)
  {
    //Creates SQL command to get all the data in selected columns
    $sql = "SELECT " . $column ." FROM "  . $table;
    
    //Executes SQL command
    $res = mysqli_query($this->con, $sql);

    //If the command is succeful go down this path
    if ($res == true)
    {
      //Initialize array
      $allData = [];

      //Puts each row of data collected into a value on the array
      while($row = mysqli_fetch_assoc($res))
      {
        array_push($allData, $row);
      }

      //Return data
      return $allData;
    }
  }

  //Method to update selected row
  public function updateData($table, $data, $searchColumn, $searchValue)
  {
    //Converts value to a usuable form in the SQL statement
    $searchValue = "'" . $searchValue . "'";

    //Creates SQL command to update selected data from the selected row
    $sql = "UPDATE " . $table ." SET " . $data . " WHERE " . $searchColumn . " = " . $searchValue;
    
    //Executes SQL command
    $res = mysqli_query($this->con, $sql);

    //If the command was succesful, return true
    if ($res == true)
    {
      return true;
    }

  }

  //Method to delete selected row
  public function deleteData($table, $column, $value)
  {
    //Converts value to a usuable form in the SQL statement
    $value = "'" . $value . "'";

    //Creates SQL command to delete selected rows from the database 
    $sql = "DELETE FROM "  . $table . " WHERE " . $column . " = " . $value;
    
    //Executes SQL command
    $res = mysqli_query($this->con, $sql);

    //If the command was succesful, return true
    if ($res == true)
    {
      return true;
    }

  }

  //Method to insert data into selected table
  public function addData($table, $data)
  {
    //Creates SQL command to insert data into selected table
    $sql = "INSERT INTO " . $table . " SET " . $data;
    
    //Exectues SQL command
    $res = mysqli_query($this->con, $sql);

    //If the command was succesful, return true
    if ($res == true)
    {
      return true;
    }

  }

  public function cartToString($cart)
  {
    $final="";
    foreach($cart as $item)
    {
      $final .= "#" . $item[0] . ",";
      for($i = 1; $i <= count($item)-1; $i++)
      {
        $final .=  $item[$i] ."," ;
        
      }
      trim(",",$final);
    }

    return $final;
  }

  public function cartToArray($cart)
  {
    $final = explode("#",$cart);
    $counter=0;
    foreach($final as $item)
    {
      $final[$counter] = explode(",",$item);
      $counter++;
    }
    array_shift($final);
    return $final;
  }

  public function clearCart($user)
  {
    $userArray = $this->searchData("user", "email", $user);

  }

  public function addItem($cart, $item)
  {
    $newItem = array($item);
    array_push($cart, $newItem);
    return $cart;
  }

  public function removeItem($cart, $index)
  {
    unset($cart[$index]); 
    $cart = array_values($cart);
    return $cart;
  }

  public function addCustom($cart, $cartItem, $customization)
  {
    $itemArray = $cart[$cartItem];
    array_push($itemArray, $customization);
    $cart[$cartItem] = $itemArray;
    return $cart;
  }

  public function removeCustom($cart, $cartItem, $index)
  {
    unset($cart[$cartItem][$index]); 
    $cart[$cartItem] = array_values($cart[$cartItem]);
    return $cart;
  }

}

?>



<?php

//Initalizes database info in variables
$host = "localhost";
$user = "root";
$password = "";
$databaseName = "centervillenutrition";

//Creates connection variable
$con = mysqli_connect($host, $user, $password);

//Selects data
mysqli_select_db($con, $databaseName);

//Creates Database class using connection variable
$dataClass = new Database($con);

// Start Session
ob_start(); 
session_start();

?>