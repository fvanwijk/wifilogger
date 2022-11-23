<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHP&MySQL Station List</title>
    <meta name="description" content="Temperature, Humidity, Pressure">
    <meta name="keywords" content="Temperature, Humidity, Pressure">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

</head>
<body>

<?php
require_once 'database.php';
$StationsInfoArray;

try{
	$stmt = $db->prepare('SELECT * FROM wifiloggers');
	$stmt->execute();
	$StationsInfoArray = $stmt->fetchAll(PDO::FETCH_BOTH);
	$length = count($StationsInfoArray);
	
	
	
	
   
 
$stmt->closeCursor();
unset($stmt);
$dbh = null;
}catch(Exception $e){

}

?>

	<form action="data.php" method="get">
		<select name="type" id="type">
		<option value="list">List</option>
		<option value="rtd">Real Time Data</option>
		<option value="hilow">Hi & Lows</option>
		<option value="arch">Archive</option>
		</select><br>
		<label for="name">Station:</label>
		<select name="name" id="name">
	<?php	
	for ($i = 0; $i < $length; $i++) {
		echo '<option value="' . $StationsInfoArray[$i]['station_name'] . '">' . $StationsInfoArray[$i]['station_name'] . '</option>';
	}?>
		</select><br>
		<label for="date">Date since:</label><input type="date" id="date" name="date"><br>
		<label for="days">Days:</label><input type="number" id="days" name="days" min="1" max="31" value="1"><br>
		<input type="submit" value="Execute"></form>

<script>
window.onload = function() {
document.getElementById('date').valueAsDate = new Date();
}
</script>

</body>
</html>