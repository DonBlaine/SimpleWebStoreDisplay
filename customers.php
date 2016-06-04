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
	
$sql = 'SELECT *
        FROM customers
		ORDER BY country';
	
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
	

<?php
echo "<div class = 'dbtable'>
	
<table>
 
 <tr>
 <th>Country</th>
 <th>Customer Name</th>
 </tr>";
 
$row = $results->fetchAll();
foreach($row as $r)
{
	echo "<tr>";
	echo"<td>".htmlspecialchars($r['country'])."</td>";
	echo"<td class = 'clickablerow'>".htmlspecialchars(iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE',$r['customerName']))."</td>";
	echo "</tr>";

	
	echo "<div id ='".htmlspecialchars(iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE',$r['customerName']))."'  ";
	
	echo "data-modal_name ='".htmlspecialchars($r['customerName'])."'  ";
	echo "data-last_name='".htmlspecialchars($r['contactLastName'])."'  ";
	echo "data-first_name='".htmlspecialchars($r['contactFirstName'])."'  ";
	echo "data-phone='".htmlspecialchars($r['phone'])."'  ";
	echo "data-address1='".htmlspecialchars($r['addressLine1'])."'  ";
	echo "data-address2='".htmlspecialchars($r['addressLine2'])."'  ";
	echo "data-city='".htmlspecialchars($r['city'])."'  ";
	echo "data-state='".htmlspecialchars($r['state'])."'  ";
	echo "data-postal_code='".htmlspecialchars($r['postalCode'])."'  ";
	echo "data-country='".htmlspecialchars($r['country'])."'  ";
	echo "data-salesrep='".htmlspecialchars($r['salesRepEmployeeNumber'])."'  ";
	echo "data-credit='".htmlspecialchars($r['creditLimit'])."'  ";
	echo"</div> ";	
 }
 echo"</table>
 </div>";
	
	
?>	
	
	
		
<div id="myModal" class="modal">

  <div class="modal-content">
    <span class="close">x</span>
	  
    <table>
 
		<tr>
		<th colspan = "2">Customer Information</th>
		</tr>
		<td>Customer Name</td>
		<td id = "modal_name"></td>
		<tr>		
		<td>Contact Last Name</td>
		<td id = "last_name"></td>
		</tr>
		<tr>
		<td>Contact First Name</td>
		<td id = "first_name"></td>
		</tr>
		<tr>
		<td>Phone</td>
		<td id = "phone"></td>
		</tr>
		<tr>
		<td>Address Line 1</td>
		<td id = "address1"></td>
		</tr>
		<tr>
		<td>Address Line 2</td>
		<td id = "address2"></td>
		</tr>
		<tr>
		<td>City</td>
		<td id = "city"></td>
		</tr>
		<tr>
		<td>State</td>
		<td id = "state"></td>
		</tr>
		<tr>
		<td>Postal Code</td>
		<td id = "postal_code"></td>
		</tr>
		<tr>
		<td>Country</td>
		<td id = "country"></td></tr>
		<tr>
		<td>Sales Rep Employee Number</td>
		<td id = "salesrep"></td>
		</tr>
		<tr>
		<td>Credit Limit</td>
		<td id = "credit"></td>
		</tr>
	  </table>
		
  </div>

</div>	

<script>
//this code was inspired by the w3schools modal page : http://www.w3schools.com/howto/howto_css_modals.asp


var modal = document.getElementById('myModal');

var start = document.querySelectorAll(".clickablerow");
for (var i = 0; i < start.length; i++) { 
   start[i].onclick = function(){
	   var value = this.innerHTML;
	   var customer = document.getElementById(value);
	   document.getElementById("modal_name").innerHTML = customer.dataset.modal_name;
	   document.getElementById("last_name").innerHTML = customer.dataset.last_name;
	   document.getElementById("first_name").innerHTML = customer.dataset.first_name;
	   document.getElementById("phone").innerHTML = customer.dataset.phone;
	   document.getElementById("address1").innerHTML = customer.dataset.address1;
	   document.getElementById("address2").innerHTML = customer.dataset.address2;
	   document.getElementById("city").innerHTML = customer.dataset.city;
	   document.getElementById("state").innerHTML = customer.dataset.state;
	   document.getElementById("postal_code").innerHTML = customer.dataset.postal_code;
	   document.getElementById("country").innerHTML = customer.dataset.country;
	   document.getElementById("salesrep").innerHTML = customer.dataset.salesrep;
	   document.getElementById("credit").innerHTML = customer.dataset.credit;
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