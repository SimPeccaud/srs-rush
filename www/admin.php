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

$connection = mysql_connect("10.250.14.102","store_rw","");
if (!$connection)
  {
   die ("Could not connect <b>".mysql_error());  
  }

mysql_select_db("store", $connection);

if ($_GET['action'] == 'delete' && $_GET['product_id'] &&
   ctype_digit($_GET['product_id']))
{
   $query = sprintf("DELETE FROM stocks WHERE product_id = %d",
			mysql_real_escape_string($_GET['product_id']));
   if (!mysql_query($query))
   {
	die ("Could not delete <b>".mysql_error());  
   }   
   $query = sprintf("DELETE FROM products WHERE product_id = %d",
			mysql_real_escape_string($_GET['product_id']));
   if (!mysql_query($query))
   {
	die ("Could not delete <b>".mysql_error());  
   }   
}
elseif ($_GET['action'] == 'update' && $_GET['name'] &&
	strlen($_GET['quantity']) && ctype_digit($_GET['quantity']) &&
	$_GET['warehouse'] &&
	strlen($_GET['price']) && ctype_digit($_GET['price']) &&
	$_GET['product_id'] && ctype_digit($_GET['product_id']))
{
   
   $query = sprintf("UPDATE stocks
		     SET quantity = %d, warehouse = '%s'
		     WHERE product_id = %d",
			mysql_real_escape_string($_GET['quantity']),
			mysql_real_escape_string($_GET['warehouse']),
			mysql_real_escape_string($_GET['product_id']));
   if (!mysql_query($query))
   {
	die ("Could not update <b>".mysql_error());  
   }   
   $query = sprintf("UPDATE products
		     SET price = %d, name = '%s'
		     WHERE product_id = %d",
			mysql_real_escape_string($_GET['price']),
			mysql_real_escape_string($_GET['name']),
			mysql_real_escape_string($_GET['product_id']));
   if (!mysql_query($query))
   {
	die ("Could not update <b>".mysql_error());  
   }   
}
elseif ($_GET['action'] == 'add' && $_GET['name'] &&
	strlen($_GET['quantity']) && ctype_digit($_GET['quantity']) &&
	$_GET['warehouse'] && 
	strlen($_GET['price']) && ctype_digit($_GET['price']))
{
   $query = sprintf("INSERT INTO products (name, price)
		     VALUES ('%s', %d)",
			mysql_real_escape_string($_GET['name']),
			mysql_real_escape_string($_GET['price']));
   if (!mysql_query($query))
   {
	die ("Could not insert <b>".mysql_error());  
   }   
   $query = sprintf("INSERT INTO stocks (product_id, quantity, warehouse)
		     VALUES (%d, %d, '%s')", mysql_insert_id(),
			mysql_real_escape_string($_GET['quantity']),
			mysql_real_escape_string($_GET['warehouse']));
   if (!mysql_query($query))
   {
	die ("Could not insert into stocks <b>".mysql_error());  
   }  
}

$result = mysql_query("SELECT *
	  	FROM products
		INNER JOIN stocks ON products.product_id = stocks.product_id");

if (!$result)
{
 die ("Could not connect <b>".mysql_error());  
}

echo "<table border=2>
     <tr><td>Name</td><td>Price</td><td>Quantity</td><td>Warehouse</td><td>Action</td></tr>";

while ($row = mysql_fetch_array($result))
    printf("<tr>
		<form method='get'>
		  <input type='hidden' name='product_id' value='%d'>
		  <td><input type='text' name='name' value='%s'></td>
		  <td><input type='text' name='price' value='%d'></td>
		  <td><input type='text' name='quantity' value='%d'></td>
		  <td>
		    <select name='warehouse'>
		      <option value='A' %s>A</option>
		      <option value='B' %s>B</option>
		      <option value='C' %s>C</option>
		    </select>
		  <td><input type='submit' name='action' value='update'>
		    <input type='submit' name='action' value='delete'></td>
		</form>
	   </tr>", $row['product_id'], $row['name'], $row['price'],
		$row['quantity'], $row['warehouse'] == 'A' ? "selected='selected'" : '',
		$row['warehouse'] == 'B' ? "selected='selected'" : '',
		$row['warehouse'] == 'C' ? "selected='selected'" : '');

echo "<tr>
   <form method='get'>
     <td><input type='text' name='name'></td>
     <td><input type='text' name='price'></td>
     <td><input type='text' name='quantity'></td>
     <td>
       <select name='warehouse'>
	 <option value='A'>A</option>
	 <option value='B'>B</option>
	 <option value='C'>C</option>
       </select>
     </td>
     <td><input type='submit' name='action' value='add'></td>
   </form>
   </tr></table>";
mysql_close($connection);

} catch (Exception $e) {
}
?> 
