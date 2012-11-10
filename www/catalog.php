<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);


$connection = mysql_connect("localhost","store_ro","");
if (!$connection)
  {
   die ("Could not connect <b>".mysql_error());  
  }

mysql_select_db("store", $connection);

$result = mysql_query("SELECT * FROM products");

if (!$result)
{
 die ("Could not connect <b>".mysql_error());  
}

  echo "name &nbsp;&nbsp;&nbsp;&nbsp;price &nbsp;&nbsp;&nbsp;&nbsp;quantity";
  echo "<br />";
while($row = mysql_fetch_array($result))
  {
    
    $id = $row['product_id'] ;
    $quantity = mysql_query("SELECT quantity FROM stocks WHERE product_id = $id");
    $rowQ = mysql_fetch_array($quantity);
    if (!$quantity)
    {
	 die ("Could not connect <b>".mysql_error());  
    }
    echo $row['name'] ."&nbsp;&nbsp;". $row['price'];
    echo "&nbsp;&nbsp;";
    echo $rowQ['quantity'];
    echo "<br />";
  }

mysql_close($connection);
?> 

