<?php
$dataType;
if(!isset($_GET['type'])){
	echo 'No type of data was choosed';
	exit();
}else{
	if(isset($_GET['days'])) $days = $_GET['days'];
	$dataType = $_GET['type'];	
	if(!isset($_GET['date'])) $start_date = new DateTime();
	else $start_date = new DateTime($_GET['date']);
	if(!isset($_GET['days'])){
		$stop_date = new DateTime();
	}
	else{
		if($days <= 1) $days = 1;
		$stop_date = new DateTime($_GET['date']);
		$days--;
		$stop_date->add(new DateInterval('P'.$days.'D'));
	}
	
	//date_add($stop_date, $_GET['days']); 
	
}
ini_set('memory_limit', '1024M');
require_once 'database.php';
//echo $start_date->format('Y-m-d') . '<BR>';
//echo $stop_date->format('Y-m-d') . '<BR>';

$stationInfoAndDataArray;



try{
	//Take out list of WiFiLoggers in database
	if($dataType == 'list'){
		$stmt = $db->prepare('SELECT * FROM wifiloggers ORDER BY station_name');
		$stmt->execute();
//		$data_from_database = $stmt->fetchAll(PDO::FETCH_ASSOC);
//		echo json_encode($data_from_database);
		echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
		$stmt->closeCursor();
		unset($stmt);
	}
	
	
	// Take info data from WiFiLoggers table
	$select = 'SELECT * FROM wifiloggers where station_name = :StationName';
	if(isset($_GET['wid'])){$select = 'SELECT * FROM wifiloggers where wid = :wid';}
	$stmt = $db->prepare($select);
	if(isset($_GET['wid'])){$stmt->bindValue(':wid', $_GET['wid'], PDO::PARAM_STR);}else{$stmt->bindValue(':StationName', $_GET['name'], PDO::PARAM_STR);}
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	   $stationInfoAndDataArray['StationInfo'] = $row;
	}
	$stmt->closeCursor();
	unset($stmt);
	
	// Take out real time data JSON
	if($dataType == 'rtd'){
		$stmt = $db->prepare('SELECT * FROM rtd where wid = :wid');
		$stmt->bindValue(':wid', $stationInfoAndDataArray['StationInfo']['wid'], PDO::PARAM_INT);
		$stmt->execute();
		$data_from_database = $stmt->fetch(PDO::FETCH_ASSOC);
		$stationInfoAndDataArray['RTD'] = $data_from_database;
		echo json_encode($stationInfoAndDataArray);
		$stmt->closeCursor();
		unset($stmt);
	}
	
	// Take out HiLows and HiLowEx to JSON
	if($dataType == 'hilow'){
		$stmt = $db->prepare('SELECT * FROM hilows where wid = :wid ORDER BY hl_id DESC LIMIT 1');
		$stmt->bindValue(':wid', $stationInfoAndDataArray['StationInfo']['wid'], PDO::PARAM_INT);
		$stmt->execute();
		$data_from_database = $stmt->fetch(PDO::FETCH_ASSOC);
		$stationInfoAndDataArray['HiLow'] = $data_from_database;
		$stmt->closeCursor();
		
		//Take out JSOB with HiLowEX for VantagePro2 modules like extra temp, leave wetness etc.
		if($stationInfoAndDataArray['StationInfo']['station_model'] == 16){
		$stmt = $db->prepare('SELECT * FROM hilowex where wid = :wid ORDER BY hlex_id DESC LIMIT 1');
		$stmt->bindValue(':wid', $stationInfoAndDataArray['StationInfo']['wid'], PDO::PARAM_INT);
		$stmt->execute();
		$data_from_database = $stmt->fetch(PDO::FETCH_ASSOC);
		$stationInfoAndDataArray['HiLowEx'] = $data_from_database;
		$stmt->closeCursor();
		unset($stmt);
		}
		echo json_encode($stationInfoAndDataArray);
	}

	//Take out arch data, put it into JSON
	if($dataType == 'arch'){
		$stmt = $db->prepare('SELECT * FROM logger where wid = :wid AND date BETWEEN :start_date AND :stop_date ORDER BY `davis_timestamp` ASC');
		if($stationInfoAndDataArray['StationInfo']['station_model'] == 17){
			$stmt = $db->prepare('SELECT * FROM logger where wid = :wid AND date BETWEEN :start_date AND :stop_date ORDER BY `davis_timestamp` ASC');
		}
		$stmt->bindValue(':wid', $stationInfoAndDataArray['StationInfo']['wid'], PDO::PARAM_INT);
		$stmt->bindValue(':start_date', $start_date->format('Y-m-d'), PDO::PARAM_INT);
		$stmt->bindValue(':stop_date', $stop_date->format('Y-m-d'), PDO::PARAM_INT);
		$stmt->execute();
		$data_from_database = $stmt->fetchAll(PDO::FETCH_NUM);
				
		for ($i = 0; $i < $stmt->columnCount(); $i++) {
			$col = $stmt->getColumnMeta($i);
			$columnsName[] = $col['name'];
		}
		$stationInfoAndDataArray['ColumnName'] = $columnsName;
		$stationInfoAndDataArray['ArchiveData'] = $data_from_database;
		echo json_encode($stationInfoAndDataArray); // print data on HTML
		$stmt->closeCursor();
		unset($stmt);
	}

	$dbh = null;
}catch(Exception $e){
		var_dump($e->getMessage());
		file_put_contents('exportdata.txt', ob_get_contents());
		//data_log('RTD: '.ob_get_contents() );
		ob_clean();

}

?>