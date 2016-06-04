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
	
$sql = 'SELECT orders.orderNumber, orders.orderDate, orders.status, orderdetails.productCode, products.productLine, products.productName, orders.comments
FROM orders
JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber 
JOIN products ON orderdetails.productCode = products.productCode
ORDER BY orderDate DESC';
	
try{
	$results = $conn->query($sql);
	$results ->setFetchMode(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
	echo "ERROR, Sql Query Failed: ". $e->getMessage();
}

$in_process = array();
$cancelled = array();
$recent = array();
$i = 0;
$j = 0;

$row = $results->fetchAll();
foreach($row as $r){
	if ($r['status'] == 'Cancelled'){
		if ($r['orderNumber'] != end($cancelled)['orderNumber']){
			array_push($cancelled, $r);
			$j = 1;
		}else{
			$j = 1;
		}

	}
	if ($r['status'] == 'In Process'){
		if ($r['orderNumber'] != end($in_process)['orderNumber']){
			array_push($in_process, $r);
			$j = 1;	
		}else{
			$j = 1;
		}
	}
	if ($i < 20) {
		if ($r['orderNumber'] != end($recent)['orderNumber']){
			array_push($recent, $r);
			$j = 1;
			$i +=1;
		}else{
			$j = 1;
		}
	}
	if ($j == 1){
		echo "<div id ='".htmlspecialchars($r['orderNumber']).htmlspecialchars($r['productCode'])."'  ";
		echo "data-order_number ='".htmlspecialchars($r['orderNumber'])."'  ";
		echo "data-order_date='".htmlspecialchars($r['orderDate'])."'  ";
		echo "data-status='".htmlspecialchars($r['status'])."'  ";
		echo "data-product_code='".htmlspecialchars($r['productCode'])."'  ";
		echo "data-product_line='".htmlspecialchars($r['productLine'])."'  ";
		echo "data-product_name='".htmlspecialchars($r['productName'])."'  ";
		echo "data-comments='".htmlspecialchars($r['comments'])."'  ";
		echo"</div> ";
		$j = 0;
	}

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
	
<div class = 'prodtableholder'>
<?php
echo "<div class = 'prodtable'>
<table>
 <tr>
 <th colspan = '3'>Recent Orders</th>
 </tr>
 <tr>
 <th>Order Number</th>
 <th>Order Date</th>
 <th>Status</th>
 </tr>";
 

foreach($recent as $r)
{
	echo "<tr>";
	echo"<td class = 'clickablerow'>".htmlspecialchars($r['orderNumber'])."</td>";
	echo"<td>".htmlspecialchars($r['orderDate'])."</td>";
	echo"<td>".htmlspecialchars($r['status'])."</td>";
	echo "</tr>";	
 }
 echo"</table>
  </div>";
?>

	
<?php
echo "<div class = 'prodtable'>
<table>
 <tr>
 <th colspan = '3'>In Process Orders</th>
 </tr>
 <tr>
 <th>Order Number</th>
 <th>Order Date</th>
 <th>Status</th>
 </tr>";
 

foreach($in_process as $r)
{
	echo "<tr>";
	echo"<td class = 'clickablerow'>".htmlspecialchars($r['orderNumber'])."</td>";
	echo"<td>".htmlspecialchars($r['orderDate'])."</td>";
	echo"<td>".htmlspecialchars($r['status'])."</td>";
	echo "</tr>";	
 }
 echo"</table>
  </div>";
?>

<?php
echo "<div class = 'prodtable'>
<table>
 <tr>
 <th colspan = '3'>Cancelled Orders</th>
 </tr>
 <tr>
 <th>Order Number</th>
 <th>Order Date</th>
 <th>Status</th>
 </tr>";
 

foreach($cancelled as $r)
{
	echo "<tr>";
	echo"<td class = 'clickablerow'>".htmlspecialchars($r['orderNumber'])."</td>";
	echo"<td>".htmlspecialchars($r['orderDate'])."</td>";
	echo"<td>".htmlspecialchars($r['status'])."</td>";
	echo "</tr>";	
 }
 echo"</table>
  </div>";
?>
	
</div>	
		
<div id="myModal" class="modal">

  <div class="modal-content">
    <span class="close">x</span>
	
	  <div id = datatables></div>
    	
  </div>

</div>	
	
<script>
//this code was inspired by the w3schools modal page : http://www.w3schools.com/howto/howto_css_modals.asp

var modal = document.getElementById('myModal');

var start = document.querySelectorAll(".clickablerow");
for (var i = 0; i < start.length; i++) { 
   start[i].onclick = function(){
	   var value = this.innerHTML;
	   var tabledata = document.querySelectorAll("[data-order_number='"+value+"']");
	   var tableinfo = "";
	   console.log(tabledata);
	   for (var i = 0; i < tabledata.length; i++) {
			tableinfo += "<table> <tr> <th colspan = '2'>Order Information</th> </tr><tr> <td>Order Number</td> <td>"+tabledata[i].dataset.order_number+"</td> </tr> <tr> <td>Order Date</td> <td>"+tabledata[i].dataset.order_date+"</td> </tr> <tr> <td>Status</td> <td>"+tabledata[i].dataset.status+"</td> </tr> <tr> <td>Product Code</td> <td>"+tabledata[i].dataset.product_code+"</td> </tr> <tr> <td>Product Line</td> <td>"+tabledata[i].dataset.product_line+"</td> </tr> <tr> <td>Product Name</td> <td>"+tabledata[i].dataset.product_name+"</td> </tr> <tr> <td>Comments</td> <td>"+tabledata[i].dataset.comments+"</td> </tr> </table>";
	   }
	   document.getElementById('datatables').innerHTML = tableinfo;
	   modal.style.display = "block";
   }
}
	
	
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
	
<?php include 'footer.php';?>
	
</body>
</html>