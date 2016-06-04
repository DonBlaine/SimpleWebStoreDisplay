<?php include 'navigation.php';?>

<?php
require_once 'dbconfig.php';
try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	//set the PDO error mode to exception
	$conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
	echo "ERROR Database Connection Failed: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Classic Models</title>
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/web3.css">

</head>
<body>
	
<div class = 'sideform'>
	
	<p>Select a product line to view all products</p>
	
<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><br> 	
  <input type="radio" name="product" value="Classic Cars"> Classic Cars<br>
  <input type="radio" name="product" value="Motorcycles"> Motorcycles<br>
  <input type="radio" name="product" value="Planes"> Planes<br>
  <input type="radio" name="product" value="Ships"> Ships<br>
  <input type="radio" name="product" value="Trains"> Trains<br>
  <input type="radio" name="product" value="Trucks and Buses"> Trucks and Buses<br>
  <input type="radio" name="product" value="Vintage Cars"> Vintage Cars<br><br>
  <input type="submit" value="Submit">
</form>
	
</div>

<?php
	
if (isset($_GET['product'])) 
{
	$product = $_GET["product"];
	$sql = "SELECT *
        FROM products
		WHERE productLine = '$product'";
	
try{
	$results = $conn->query($sql);
	$results ->setFetchMode(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
	echo "ERROR, Sql Query Failed: ". $e->getMessage();
}
	
	
echo "<div class = 'dbtable'>
	
<table>
 
 <tr>
 <th>Product Line</th>
 <th>Product Name</th>
 <th>Product Code</th>
 <th>Product Scale</th>
 <th>Product Vendor</th>
 <th>Quantity in Stock</th>
 <th>Buy Price</th>
 <th>MSRP</th>
 <th style = 'width:250%;'>Product Description</th>
 </tr>";
 
$row = $results->fetchAll();
foreach($row as $r)
{
 echo "<tr>";
 echo"<td>".htmlspecialchars($r['productLine'])."</td>";
 echo"<td>".htmlspecialchars($r['productName'])."</td>";
 echo"<td>".htmlspecialchars($r['productCode'])."</td>";
 echo"<td>".htmlspecialchars($r['productScale'])."</td>";
 echo"<td>".htmlspecialchars($r['productVendor'])."</td>";
 echo"<td>".htmlspecialchars($r['quantityInStock'])."</td>";
 echo"<td>".htmlspecialchars($r['buyPrice'])."</td>";
 echo"<td>".htmlspecialchars($r['MSRP'])."</td>";
 echo"<td>".htmlspecialchars($r['productDescription'])."</td>";
 echo "</tr>";
 }
 echo"</table>
 </div>";
	
}

?>

	
<?php include 'footer.php';?>
	
</body>
</html>