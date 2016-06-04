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
	
$sql = 'SELECT productLine, textDescription
        FROM productlines';
	

try{
	$results = $conn->query($sql);
	$results ->setFetchMode(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
	echo "ERROR, Sql Query Failed: ". $e->getMessage();
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
	

<div class = "dbtable">
	
<table>
 
 <tr>
 <th>Product Line</th>
 <th style="width:200%;">Description</th>
 </tr>
 
 <?php while ($r = $results->fetch()): ?>
 <tr>
 <td><?php echo htmlspecialchars($r['productLine'])?></td>
 <td><?php echo htmlspecialchars($r['textDescription']); ?></td>
 </tr>
 <?php endwhile; ?>
	
</table>
	
	
</div>	

	
<?php include 'footer.php';?>
	
</body>
</html>