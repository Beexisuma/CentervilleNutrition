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


  //Method to convert the cart array to a string to store into the database
  public function cartToString($cart)
  {
    //initialize final
    $final="";


    //loops through each item in the cart
    foreach($cart as $item)
    {
      //# marks the beginning of a new item
      $final .= "#" . $item[0] . ",";


      //First in item is the items ID the rest are Customizations
      for($i = 1; $i <= count($item)-1; $i++)
      {
        $final .=  $item[$i] ."," ;
       
      }


      //Remove the extra , at the end
      trim(",",$final);
    }
    return $final;
  }


  //Method to convert the string cart stored in the database to a multidimensional array
  public function cartToArray($cart)
  {
    //Splits string by item which is marked with #
    $final = explode("#",$cart);


    //Loop to create each item array
    $counter=0;
    for($i = 0; $i < count($final); $i++)
    {
      //Splits item at each , which creates an empty customization at the end which is popped
      $final[$i] = explode(",",$final[$i]);
      array_pop($final[$i]);
    }


    //Removes the extra empty item at the start
    array_shift($final);
   
    return $final;
  }


  //Adds new item to an array
  public function addItem($cart, $item)
  {
    $newItem = array($item);
    array_push($cart, $newItem);
    return $cart;
  }


  //Removes the item at a given index
  public function removeItem($cart, $index)
  {
    unset($cart[$index]);
    $cart = array_values($cart);
    return $cart;
  }


  //Adds a customization to an item
  public function addCustom($cart, $cartItem, $customization)
  {
    $itemArray = $cart[$cartItem];
    array_push($itemArray, $customization);
    $cart[$cartItem] = $itemArray;
    return $cart;
  }


  //Removes an customization at a given index
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
$databaseName = "completecentervillenutrition";


//Creates connection variable
$con = mysqli_connect($host, $user, $password);


//Selects data
mysqli_select_db($con, $databaseName);


//Creates Database class using connection variable
$dataClass = new Database($con);




//Function to format and return a time
function getTime()
{
    date_default_timezone_set("America/New_York");
    //hour:minute am/pm month date, year
    $formatedTime = date("g:ia F j, Y");


    return($formatedTime);
}


?>




