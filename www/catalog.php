<?php
$connection = mysql_connect("localhost","store_ro","");
if (!$connection)
  {
   die ("Could not connect <b>".mysql_error());  
  }

mysql_select_db("store", $connection);

$result = mysql_query("SELECT * FROM products");

if (!$result)
{

}
while($row = mysql_fetch_array($result))
  {
  echo $row['name'] . " " . $row['price'];
  echo "<br />";
  }

mysql_close($con);
?> 

