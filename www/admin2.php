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

  echo "<table border=2>
       <tr><td>name</td><td>price</td><td>quantity</td></tr>";

while($row = mysql_fetch_array($result))
  {


    
    $id = $row['product_id'] ;
    $quantity = mysql_query("SELECT quantity FROM stocks WHERE product_id = $id");
    $warehouse = mysql_query("SELECT warehouse FROM stocks WHERE product_id = $id"); 
    $rowQ = mysql_fetch_array($quantity);
    if (!$quantity)
    {
	 die ("Could not connect <b>".mysql_error());  
    }

    echo "<tr><td>".$row['name']."</td><td>".$row['price']."</td><td>".$rowQ['quantity']."</TD></TR>";


   }



	echo "</table>";
	mysql_close($connection);
?> 