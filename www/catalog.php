<html>

<head><title>Web Server catalog</title></head>

<body>

<a href="admin.php">admin</a>
<a href="catalog.php">catalog</a>
<a href="whoami.php">whoami</a>
<br>
<br>
<?php
try {

error_reporting(E_ALL | E_STRICT);

$connection = mysql_connect("10.250.14.130","store_ro","");
if (!$connection)
  {
   die ("Could not connect <b>".mysql_error());  
  }

mysql_select_db("store", $connection);

$result = mysql_query("SELECT *
	  	FROM products
		INNER JOIN stocks ON products.product_id = stocks.product_id");

if (!$result)
{
 die ("Could not connect <b>".mysql_error());  
}

echo "<table border=2>
     <tr><td>Name</td><td>Price</td><td>Quantity</td><td>Warehouse</td></tr>";

while ($row = mysql_fetch_array($result))
    printf("<tr><td>%s</td><td>%d</td><td>%d</td><td>%s</td></tr>",
		$row['name'], $row['price'], $row['quantity'], $row['warehouse']);

echo "</table>";
mysql_close($connection);

} catch (Exception $e) {
}
?> 
