<?php

header_remove ('X-Powered-By');
header_remove ('Vary');
header_remove ('Content-Type');
header('Content-Type: text/html');
header('Connection: close');

$error = 0;
$status = 'unknown_type';
$result = null;
$contentdata = null;
$results = 0;

 function wh_log($log_msg) {
    file_put_contents('log.txt', $log_msg . "\n", FILE_APPEND);
}

 function data_log($log_msg) {
    file_put_contents('data.txt', $log_msg . "");
}

//data_log('no error');

/*
print_r($_SERVER);
data_log(ob_get_contents() );
ob_clean();
*/



if($_SERVER['HTTP_USER_AGENT'] !== 'WiFilogger'){
    header($_SERVER["SERVER_PROTOCOL"].' 403 Forbidden', true, 403);
    echo "Only for WiFiLogger!\n";
    exit();
}

/* PUT data comes in on the stdin stream */
$putdata = fopen("php://input", "r");
while ($data = fread($putdata, 1024)){
	$json_source = $json_source.$data;
}
/*
$fp = fopen("wflsql.json", "w");
fwrite($fp, $json_source);
fclose($fp);
*/
fclose($putdata);




$json = json_decode($json_source, true);

if($json['type'] == 'registration'){
	require_once 'database.php';
	
	$stmt = $db->prepare('SELECT COUNT(wid) FROM wifiloggers WHERE wid = :wid');
	$stmt->bindValue(':wid', $json['wid'], PDO::PARAM_INT);	
	$stmt->execute();
	$result = $stmt->fetchColumn();
	$stmt->closeCursor();
	$status = $result;
	if($result == 0){
		$SQL = 'INSERT IGNORE INTO wifiloggers(wid, station_name, station_model, station_fw_ver, station_lati, station_longi, station_elevation, station_bar_red_met, station_time_zone, station_units, station_setup_bits, station_rain_season_start, station_archive_period, station_wind_cup_size, station_log_avg_temp, station_usetx, station_retransmit_tx, station_daylight_m_a, station_daylight_saving, station_transmitter_1, station_transmitter_2, station_transmitter_3, station_transmitter_4, station_transmitter_5, station_transmitter_6, station_transmitter_7, station_transmitter_8, wfl_mac_st, wfl_mac_ap, wfl_time_loc, wfl_time_utc, wfl_lastboot, wfl_uptime, wfl_ip, wfl_ssid, wfl_rssi, wfl_wifi_mode, wfl_model, wfl_ver, wfl_lati, wfl_longi, rtd_int )
							   VALUES(        :wid,:station_name,:station_model,:station_fw_ver,:station_lati,:station_longi,:station_elevation,:station_bar_red_met,:station_time_zone,:station_units,:station_setup_bits,:station_rain_season_start,:station_archive_period,:station_wind_cup_size,:station_log_avg_temp,:station_usetx,:station_retransmit_tx,:station_daylight_m_a,:station_daylight_saving,:station_transmitter_1,:station_transmitter_2,:station_transmitter_3,:station_transmitter_4,:station_transmitter_5,:station_transmitter_6,:station_transmitter_7,:station_transmitter_8,:wfl_mac_st,:wfl_mac_ap,:wfl_time_loc,:wfl_time_utc,:wfl_lastboot,:wfl_uptime,:wfl_ip,:wfl_ssid,:wfl_rssi,:wfl_wifi_mode,:wfl_model,:wfl_ver,:wfl_lati,:wfl_longi, :rtdinterval )';
    }else{		
		$SQL = 'UPDATE wifiloggers SET  station_name = :station_name, station_model = :station_model, station_fw_ver = :station_fw_ver, station_lati = :station_lati, station_longi = :station_longi, station_elevation =:station_elevation, station_bar_red_met = :station_bar_red_met, station_time_zone = :station_time_zone, station_units = :station_units, station_setup_bits = :station_setup_bits, station_rain_season_start = :station_rain_season_start, station_archive_period = :station_archive_period, station_wind_cup_size = :station_wind_cup_size, station_log_avg_temp = :station_log_avg_temp, station_usetx = :station_usetx, station_retransmit_tx = :station_retransmit_tx, station_daylight_m_a = :station_daylight_m_a, station_daylight_saving = :station_daylight_saving, station_transmitter_1 = :station_transmitter_1, station_transmitter_2 = :station_transmitter_2, station_transmitter_3 = :station_transmitter_3, station_transmitter_4 = :station_transmitter_4, station_transmitter_5 = :station_transmitter_5, station_transmitter_6 = :station_transmitter_6, station_transmitter_7 = :station_transmitter_7, station_transmitter_8 = :station_transmitter_8, wfl_mac_st = :wfl_mac_st, wfl_mac_ap = :wfl_mac_ap, wfl_time_loc = :wfl_time_loc, wfl_time_utc = :wfl_time_utc, wfl_lastboot = :wfl_lastboot, wfl_uptime = :wfl_uptime, wfl_ip = :wfl_ip, wfl_ssid = :wfl_ssid, wfl_rssi = :wfl_rssi, wfl_wifi_mode = :wfl_wifi_mode, wfl_model = :wfl_model, wfl_ver = :wfl_ver, wfl_lati = :wfl_lati, wfl_longi = :wfl_longi, rtd_int = :rtdinterval
							   WHERE `wid`= :wid';
	}
 
	try{
	 $stmt = $db->prepare($SQL);
		$stmt->bindValue(':wid',  $json['wid'], PDO::PARAM_INT);						   
		$stmt->bindValue(':station_name',  $json['stnname'], PDO::PARAM_STR);	
		$stmt->bindValue(':station_model',  $json['stnmod'], PDO::PARAM_INT);	
		$stmt->bindValue(':station_fw_ver',  $json['ver'], PDO::PARAM_INT);	
		$stmt->bindValue(':station_lati', $json['conlati'], PDO::PARAM_INT);
		$stmt->bindValue(':station_longi', $json['conlongi'], PDO::PARAM_INT);
		$stmt->bindValue(':station_elevation', $json['conelev'], PDO::PARAM_INT);
		$stmt->bindValue(':station_bar_red_met', $json['conbrm'], PDO::PARAM_INT);
		$stmt->bindValue(':station_time_zone', $json['tzone'], PDO::PARAM_INT);
		$stmt->bindValue(':station_units', $json['units'], PDO::PARAM_INT);
		$stmt->bindValue(':station_setup_bits', $json['setbit'], PDO::PARAM_INT);
		$stmt->bindValue(':station_rain_season_start', $json['rainseason'], PDO::PARAM_INT);
		$stmt->bindValue(':station_archive_period', $json['archper'], PDO::PARAM_INT);
		$stmt->bindValue(':station_wind_cup_size', $json['windcupsize'], PDO::PARAM_INT);
		$stmt->bindValue(':station_log_avg_temp', $json['logavg'], PDO::PARAM_INT);
		$stmt->bindValue(':station_usetx', $json['usetx'], PDO::PARAM_INT);
		$stmt->bindValue(':station_retransmit_tx', $json['retranstx'], PDO::PARAM_INT);
		$stmt->bindValue(':station_daylight_m_a', $json['daylma'], PDO::PARAM_INT);
		$stmt->bindValue(':station_daylight_saving', $json['dayls'], PDO::PARAM_INT);
		$stmt->bindValue(':station_transmitter_1', $json['statlist'][0], PDO::PARAM_INT);
		$stmt->bindValue(':station_transmitter_2', $json['statlist'][1], PDO::PARAM_INT);
		$stmt->bindValue(':station_transmitter_3', $json['statlist'][2], PDO::PARAM_INT);
		$stmt->bindValue(':station_transmitter_4', $json['statlist'][3], PDO::PARAM_INT);
		$stmt->bindValue(':station_transmitter_5', $json['statlist'][4], PDO::PARAM_INT);
		$stmt->bindValue(':station_transmitter_6', $json['statlist'][5], PDO::PARAM_INT);
		$stmt->bindValue(':station_transmitter_7', $json['statlist'][6], PDO::PARAM_INT);
		$stmt->bindValue(':station_transmitter_8', $json['statlist'][7], PDO::PARAM_INT);
		$stmt->bindValue(':wfl_mac_st',  $json['mac'], PDO::PARAM_STR);
		$stmt->bindValue(':wfl_mac_ap',  $json['apmac'], PDO::PARAM_STR);
		$stmt->bindValue(':wfl_time_loc', $json['loctime'], PDO::PARAM_INT);
		$stmt->bindValue(':wfl_time_utc', $json['utctime'], PDO::PARAM_INT);
		$stmt->bindValue(':wfl_lastboot', $json['lastboot'], PDO::PARAM_INT);
		$stmt->bindValue(':wfl_uptime', $json['uptime'], PDO::PARAM_INT);
		$stmt->bindValue(':wfl_ip',  $json['ip'], PDO::PARAM_STR);
		$stmt->bindValue(':wfl_ssid', $json['ssid'], PDO::PARAM_STR);
		$stmt->bindValue(':wfl_rssi', $json['rssi'], PDO::PARAM_INT);
		$stmt->bindValue(':wfl_wifi_mode', $json['wifimod'], PDO::PARAM_INT);
		$stmt->bindValue(':wfl_model', $json['wflmod'], PDO::PARAM_STR);
		$stmt->bindValue(':wfl_ver', $json['wflver'], PDO::PARAM_STR);
		$stmt->bindValue(':wfl_lati', $json['wfllati'], PDO::PARAM_INT);
		$stmt->bindValue(':wfl_longi', $json['wfllongi'], PDO::PARAM_INT);
		$stmt->bindValue(':rtdinterval', $json['phpinterval'], PDO::PARAM_INT);
		
		$result = $stmt->execute();
		$results = $stmt->rowCount();
		$stmt->closeCursor();
		
	}catch(Exception $e){
		$error++;
		//$e->getMessage( );// , (int)$Exception->getCode( )
		var_dump($e->getMessage());
		data_log('RTD: '.ob_get_contents() );
		ob_clean();
	}
	
	$stmt = $db->prepare('SELECT COUNT(wid) FROM rtd WHERE wid = :wid');
	$stmt->bindValue(':wid', $json['wid'], PDO::PARAM_INT);	
	$stmt->execute();
	$result = $stmt->fetchColumn();
	$stmt->closeCursor();
	$status = $result;
	if($result == 0){
		$stmt = $db->query('INSERT IGNORE INTO rtd(wid, time_utc, time_loc, date_loc) VALUES('. $json['wid'].', 0, 0, 0)');
		$stmt->closeCursor();
	}
	
	
unset($stmt);
//$db = null;
$status = 'registration_ok';
$contentdata = null;
	
}

if($json['type'] == 'rtd'){
	require_once 'database.php';
	try{
	 $stmt = $db->prepare('UPDATE rtd SET time_loc = :time, date_loc = :date, time_utc = :time_utc, temp_out= :temp_out, temp_in= :temp_in, hum_out= :hum_out, hum_in= :hum_in, barometer = :barometer, altimeter = :altimeter, raw_bar = :raw_bar, bar_trend = :bar_trend, wind_spd= :wind_spd, wind_dir= :wind_dir, wind_avg_2min= :wind_avg_2min, wind_avg_10min= :wind_avg_10min, wind_gust_10min= :wind_gust_10min, wind_gust_dir= :wind_gust_dir, rain_rate= :rain_rate, rain_15min= :rain_15min, rain_1h = :rain_1h, rain_day = :rain_day, rain_daily = :rain_daily, rain_24= :rain_24, rain_month= :rain_month, rain_year= :rain_year, storm_rain= :storm_rain, dew_point= :dew_point, dew_point_cal= :dew_point_cal, wind_chill= :wind_chill, heat_index= :heat_index, thsw_index= :thsw_index, solar_radiation= :solar_radiation, uv = :uv, et_day= :et_day, et_month= :et_month, et_year= :et_year, temp_extra_0 = :temp_extra_0, temp_extra_1 = :temp_extra_1, temp_extra_2 = :temp_extra_2, temp_extra_3 = :temp_extra_3, temp_extra_4 = :temp_extra_4, temp_extra_5 = :temp_extra_5, temp_extra_6 = :temp_extra_6, hum_extra_0 = :hum_extra_0, hum_extra_1 = :hum_extra_1, hum_extra_2 = :hum_extra_2, hum_extra_3 = :hum_extra_3, hum_extra_4 = :hum_extra_4, hum_extra_5 = :hum_extra_5, hum_extra_6 = :hum_extra_6, temp_soil_0 = :temp_soil_0, temp_soil_1 = :temp_soil_1, temp_soil_2 = :temp_soil_2, temp_soil_3 = :temp_soil_3, temp_leaf_0 = :temp_leaf_0, temp_leaf_1 = :temp_leaf_1, temp_leaf_2 = :temp_leaf_2, temp_leaf_3 = :temp_leaf_3, wet_leaf_0 = :wet_leaf_0, wet_leaf_1 = :wet_leaf_1, wet_leaf_2 = :wet_leaf_2, wet_leaf_3 = :wet_leaf_3, soil_moist_0 = :soil_moist_0, soil_moist_1 = :soil_moist_1, soil_moist_2 = :soil_moist_2, soil_moist_3 = :soil_moist_3, stations_batt_status= :stations_batt_status, console_batt= :console_batt, forecast_icon= :forecast_icon, forecast_rule= :forecast_rule, sunrise_loc_time= :sunrise_loc_time, sunset_loc_time= :sunset_loc_time 
		WHERE `wid`= :wid');
						   
		$stmt->bindValue(':wid', $json['wid'], PDO::PARAM_INT);						   
		$stmt->bindValue(':time', $json['time'], PDO::PARAM_INT);	
		$stmt->bindValue(':date', $json['date'], PDO::PARAM_INT);	
		$stmt->bindValue(':time_utc', $json['tutc'], PDO::PARAM_INT);	
		$stmt->bindValue(':temp_out', $json['tempout'], PDO::PARAM_INT);
		$stmt->bindValue(':temp_in', $json['tempin'], PDO::PARAM_INT);
		$stmt->bindValue(':hum_out', $json['humout'], PDO::PARAM_INT);
		$stmt->bindValue(':hum_in', $json['humin'], PDO::PARAM_INT);
		$stmt->bindValue(':barometer', $json['bar'], PDO::PARAM_INT);
		$stmt->bindValue(':altimeter', $json['altime'], PDO::PARAM_INT);
		$stmt->bindValue(':raw_bar', $json['rawbar'], PDO::PARAM_INT);
		$stmt->bindValue(':bar_trend', $json['bartr'], PDO::PARAM_INT);
		$stmt->bindValue(':wind_spd', $json['windspd'], PDO::PARAM_INT);
		$stmt->bindValue(':wind_dir', $json['winddir'], PDO::PARAM_INT);
		$stmt->bindValue(':wind_avg_2min', $json['windavg2'], PDO::PARAM_INT);
		$stmt->bindValue(':wind_avg_10min', $json['windavg10'], PDO::PARAM_INT);
		$stmt->bindValue(':wind_gust_10min', $json['gust'], PDO::PARAM_INT);
		$stmt->bindValue(':wind_gust_dir', $json['gustdir'], PDO::PARAM_INT);
		$stmt->bindValue(':dew_point', $json['dew'], PDO::PARAM_INT);
		$stmt->bindValue(':dew_point_cal', $json['cdew'], PDO::PARAM_INT);
		$stmt->bindValue(':wind_chill', $json['chill'], PDO::PARAM_INT);
		$stmt->bindValue(':heat_index', $json['heat'], PDO::PARAM_INT);
		$stmt->bindValue(':thsw_index', $json['thsw'], PDO::PARAM_INT);
		$stmt->bindValue(':uv', $json['uv'], PDO::PARAM_INT);
		$stmt->bindValue(':solar_radiation', $json['solar'], PDO::PARAM_INT);
		$stmt->bindValue(':rain_rate', $json['rainr'], PDO::PARAM_INT);
		$stmt->bindValue(':storm_rain', $json['storm'], PDO::PARAM_INT);
		$stmt->bindValue(':rain_15min', $json['rain15'], PDO::PARAM_INT);
		$stmt->bindValue(':rain_1h', $json['rain1h'], PDO::PARAM_INT);
		$stmt->bindValue(':rain_day', $json['raind'], PDO::PARAM_INT);
		$stmt->bindValue(':rain_daily', $json['raindly'], PDO::PARAM_INT);
		$stmt->bindValue(':rain_24', $json['rain24'], PDO::PARAM_INT);
		$stmt->bindValue(':rain_month', $json['rainmon'], PDO::PARAM_INT);
		$stmt->bindValue(':rain_year', $json['rainyear'], PDO::PARAM_INT);
		$stmt->bindValue(':et_day', $json['etday'], PDO::PARAM_INT);
		$stmt->bindValue(':et_month', $json['etmon'], PDO::PARAM_INT);
		$stmt->bindValue(':et_year', $json['etyear'], PDO::PARAM_INT);
		$stmt->bindValue(':temp_extra_0', $json['xt'][0], PDO::PARAM_INT);
		$stmt->bindValue(':temp_extra_1', $json['xt'][1], PDO::PARAM_INT);
		$stmt->bindValue(':temp_extra_2', $json['xt'][2], PDO::PARAM_INT);
		$stmt->bindValue(':temp_extra_3', $json['xt'][3], PDO::PARAM_INT);
		$stmt->bindValue(':temp_extra_4', $json['xt'][4], PDO::PARAM_INT);
		$stmt->bindValue(':temp_extra_5', $json['xt'][5], PDO::PARAM_INT);
		$stmt->bindValue(':temp_extra_6', $json['xt'][6], PDO::PARAM_INT);
		$stmt->bindValue(':temp_leaf_0', $json['xlt'][0], PDO::PARAM_INT);
		$stmt->bindValue(':temp_leaf_1', $json['xlt'][1], PDO::PARAM_INT);
		$stmt->bindValue(':temp_leaf_2', $json['xlt'][2], PDO::PARAM_INT);
		$stmt->bindValue(':temp_leaf_3', $json['xlt'][3], PDO::PARAM_INT);
		$stmt->bindValue(':temp_soil_0', $json['xst'][0], PDO::PARAM_INT);
		$stmt->bindValue(':temp_soil_1', $json['xst'][1], PDO::PARAM_INT);
		$stmt->bindValue(':temp_soil_2', $json['xst'][2], PDO::PARAM_INT);
		$stmt->bindValue(':temp_soil_3', $json['xst'][3], PDO::PARAM_INT);
		$stmt->bindValue(':hum_extra_0', $json['xh'][0], PDO::PARAM_INT);
		$stmt->bindValue(':hum_extra_1', $json['xh'][1], PDO::PARAM_INT);
		$stmt->bindValue(':hum_extra_2', $json['xh'][2], PDO::PARAM_INT);
		$stmt->bindValue(':hum_extra_3', $json['xh'][3], PDO::PARAM_INT);
		$stmt->bindValue(':hum_extra_4', $json['xh'][4], PDO::PARAM_INT);
		$stmt->bindValue(':hum_extra_5', $json['xh'][5], PDO::PARAM_INT);
		$stmt->bindValue(':hum_extra_6', $json['xh'][6], PDO::PARAM_INT);
		$stmt->bindValue(':soil_moist_0', $json['xsm'][0], PDO::PARAM_INT);
		$stmt->bindValue(':soil_moist_1', $json['xsm'][1], PDO::PARAM_INT);
		$stmt->bindValue(':soil_moist_2', $json['xsm'][2], PDO::PARAM_INT);
		$stmt->bindValue(':soil_moist_3', $json['xsm'][3], PDO::PARAM_INT);
		$stmt->bindValue(':wet_leaf_0', $json['xlw'][0], PDO::PARAM_INT);
		$stmt->bindValue(':wet_leaf_1', $json['xlw'][1], PDO::PARAM_INT);
		$stmt->bindValue(':wet_leaf_2', $json['xlw'][2], PDO::PARAM_INT);
		$stmt->bindValue(':wet_leaf_3', $json['xlw'][3], PDO::PARAM_INT);
		$stmt->bindValue(':console_batt', $json['bat'], PDO::PARAM_INT);
		$stmt->bindValue(':stations_batt_status', $json['trbat'], PDO::PARAM_INT);
		$stmt->bindValue(':forecast_icon', $json['foreico'], PDO::PARAM_INT);
		$stmt->bindValue(':forecast_rule', $json['forrule'], PDO::PARAM_INT);
		$stmt->bindValue(':sunrise_loc_time', $json['sunrt'], PDO::PARAM_INT);
		$stmt->bindValue(':sunset_loc_time', $json['sunst'], PDO::PARAM_INT);
					
		$result = $stmt->execute();
		$results = $stmt->rowCount();
		$stmt->closeCursor();
						
	}catch(Exception $e){
		$error++;
		//$e->getMessage( );// , (int)$Exception->getCode( )
		var_dump($e->getMessage());
		data_log('RTD: '.ob_get_contents() );
		ob_clean();
	}
	

unset($stmt);
//$db = null;
$status = 'rtd_ok';
$contentdata = null;
	
}

if($json['type'] == 'hilows'){
	require_once 'database.php';
	
	$stmt = $db->prepare('SELECT COUNT(wid) FROM hilows WHERE wid = :wid AND date_loc = :date_loc');
	$stmt->bindValue(':wid', $json['wid'], PDO::PARAM_INT);	
	$stmt->bindValue(':date_loc', $json['date'], PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchColumn();
	$stmt->closeCursor();
	$status = $result;
	if($result == 0){
		$SQL = 'INSERT INTO hilows(wid, time_utc, time_loc, date_loc, bar_tl, bar_l, bar_th, bar_h, wind_th, wind_h, tempin_tl, tempin_l, tempin_th, tempin_h, humin_tl, humin_l, humin_th, humin_h, tempout_tl, tempout_l, tempout_th, tempout_h, humout_tl, humout_l, humout_th, humout_h, dew_tl, dew_l, dew_th, dew_h, chill_tl, chill_l, heat_th, heat_h, thsw_th, thsw_h, solar_th, solar_h, uv_th, uv_h, rainr_th, rainr_h, rain_day, rain_mon, rain_year, et_day, et_mon, et_year)
						VALUES(   :wid,:time_utc,:time_loc,:date_loc,:bar_tl,:bar_l,:bar_th,:bar_h,:wind_th,:wind_h,:tempin_tl,:tempin_l,:tempin_th,:tempin_h,:humin_tl,:humin_l,:humin_th,:humin_h,:tempout_tl,:tempout_l,:tempout_th,:tempout_h,:humout_tl,:humout_l,:humout_th,:humout_h,:dew_tl,:dew_l,:dew_th,:dew_h,:chill_tl,:chill_l,:heat_th,:heat_h,:thsw_th,:thsw_h,:solar_th,:solar_h,:uv_th,:uv_h,:rainr_th,:rainr_h,:rain_day,:rain_mon,:rain_year,:et_day,:et_mon,:et_year)';
	}else{						
		$SQL = 'UPDATE hilows SET time_utc = :time_utc, time_loc = :time_loc, bar_tl = :bar_tl, bar_l = :bar_l, bar_th = :bar_th, bar_h = :bar_h, wind_th = :wind_th, wind_h = :wind_h, tempin_tl = :tempin_tl, tempin_l = :tempin_l, tempin_th = :tempin_th, tempin_h = :tempin_h, humin_tl = :humin_tl, humin_l = :humin_l, humin_th = :humin_th, humin_h = :humin_h, tempout_tl = :tempout_tl, tempout_l = :tempout_l, tempout_th = :tempout_th, tempout_h = :tempout_h, humout_tl = :humout_tl, humout_l = :humout_l, humout_th = :humout_th, humout_h = :humout_h, dew_tl = :dew_tl, dew_l = :dew_l, dew_th = :dew_th, dew_h = :dew_h, chill_tl = :chill_tl, chill_l = :chill_l, heat_th = :heat_th, heat_h = :heat_h, thsw_th = :thsw_th, thsw_h = :thsw_h, solar_th = :solar_th, solar_h = :solar_h, uv_th = :uv_th, uv_h = :uv_h, rainr_th = :rainr_th, rainr_h = :rainr_h, rain_day = :rain_day, rain_mon = :rain_mon, rain_year = :rain_year, et_day = :et_day, et_mon = :et_mon, et_year = :et_year
								WHERE wid = :wid AND date_loc = :date_loc';
	}
	try{
	 $stmt = $db->prepare($SQL);
		$stmt->bindValue(':wid',  $json['wid'], PDO::PARAM_INT);
		$stmt->bindValue(':time_utc',  $json['tutc'], PDO::PARAM_INT);
		$stmt->bindValue(':time_loc',  $json['time'], PDO::PARAM_INT);
		$stmt->bindValue(':date_loc',  $json['date'], PDO::PARAM_INT);
		$stmt->bindValue(':bar_tl',  $json['hlbar'][0], PDO::PARAM_INT);
		$stmt->bindValue(':bar_l',  $json['hlbar'][1], PDO::PARAM_INT);
		$stmt->bindValue(':bar_th',  $json['hlbar'][2], PDO::PARAM_INT);
		$stmt->bindValue(':bar_h',  $json['hlbar'][3], PDO::PARAM_INT);
		$stmt->bindValue(':wind_th',  $json['hlwind'][0], PDO::PARAM_INT);
		$stmt->bindValue(':wind_h',  $json['hlwind'][1], PDO::PARAM_INT);
		$stmt->bindValue(':tempin_tl',  $json['hltempin'][0], PDO::PARAM_INT);
		$stmt->bindValue(':tempin_l',  $json['hltempin'][1], PDO::PARAM_INT);
		$stmt->bindValue(':tempin_th',  $json['hltempin'][2], PDO::PARAM_INT);
		$stmt->bindValue(':tempin_h',  $json['hltempin'][3], PDO::PARAM_INT);
		$stmt->bindValue(':humin_tl',  $json['hlhumin'][0], PDO::PARAM_INT);
		$stmt->bindValue(':humin_l',  $json['hlhumin'][1], PDO::PARAM_INT);
		$stmt->bindValue(':humin_th',  $json['hlhumin'][2], PDO::PARAM_INT);
		$stmt->bindValue(':humin_h',  $json['hlhumin'][3], PDO::PARAM_INT);
		$stmt->bindValue(':tempout_tl',  $json['hltempout'][0], PDO::PARAM_INT);
		$stmt->bindValue(':tempout_l',  $json['hltempout'][1], PDO::PARAM_INT);
		$stmt->bindValue(':tempout_th',  $json['hltempout'][2], PDO::PARAM_INT);
		$stmt->bindValue(':tempout_h',  $json['hltempout'][3], PDO::PARAM_INT);
		$stmt->bindValue(':humout_tl',  $json['hlhumout'][0], PDO::PARAM_INT);
		$stmt->bindValue(':humout_l',  $json['hlhumout'][1], PDO::PARAM_INT);
		$stmt->bindValue(':humout_th',  $json['hlhumout'][2], PDO::PARAM_INT);
		$stmt->bindValue(':humout_h',  $json['hlhumout'][3], PDO::PARAM_INT);
		$stmt->bindValue(':dew_tl',  $json['hldew'][0], PDO::PARAM_INT);
		$stmt->bindValue(':dew_l',  $json['hldew'][1], PDO::PARAM_INT);
		$stmt->bindValue(':dew_th',  $json['hldew'][2], PDO::PARAM_INT);
		$stmt->bindValue(':dew_h',  $json['hldew'][3], PDO::PARAM_INT);
		$stmt->bindValue(':chill_tl',  $json['hlchill'][0], PDO::PARAM_INT);
		$stmt->bindValue(':chill_l',  $json['hlchill'][1], PDO::PARAM_INT);
		$stmt->bindValue(':heat_th',  $json['hlheat'][0], PDO::PARAM_INT);
		$stmt->bindValue(':heat_h',  $json['hlheat'][1], PDO::PARAM_INT);
		$stmt->bindValue(':thsw_th',  $json['hlthsw'][0], PDO::PARAM_INT);
		$stmt->bindValue(':thsw_h',  $json['hlthsw'][1], PDO::PARAM_INT);
		$stmt->bindValue(':solar_th',  $json['hlsolar'][0], PDO::PARAM_INT);
		$stmt->bindValue(':solar_h',  $json['hlsolar'][1], PDO::PARAM_INT);
		$stmt->bindValue(':uv_th',  $json['hluv'][0], PDO::PARAM_INT);
		$stmt->bindValue(':uv_h',  $json['hluv'][1], PDO::PARAM_INT);
		$stmt->bindValue(':rainr_th',  $json['hlrainr'][0], PDO::PARAM_INT);
		$stmt->bindValue(':rainr_h',  $json['hlrainr'][1], PDO::PARAM_INT);
		$stmt->bindValue(':rain_day',  $json['hlraindly'], PDO::PARAM_INT);
		$stmt->bindValue(':rain_mon',  $json['hlrainmon'], PDO::PARAM_INT);
		$stmt->bindValue(':rain_year',  $json['hlrainyear'], PDO::PARAM_INT);
		$stmt->bindValue(':et_day',  $json['hletday'], PDO::PARAM_INT);
		$stmt->bindValue(':et_mon',  $json['hletmon'], PDO::PARAM_INT);
		$stmt->bindValue(':et_year',  $json['hletyear'], PDO::PARAM_INT);
		
		$result = $stmt->execute();
		$results = $stmt->rowCount();
		$stmt->closeCursor();
						
	}catch(Exception $e){
		$error++;
		//$e->getMessage( );// , (int)$Exception->getCode( )
		var_dump($e->getMessage());
		data_log('HILOWS: '.ob_get_contents() );
		ob_clean();
	}
	

unset($stmt);
//$db = null;
$status = 'hilows_ok';
$contentdata = null;
	
}


if($json['type'] == 'hilowex'){
	require_once 'database.php';
	
	$stmt = $db->prepare('SELECT COUNT(wid) FROM hilowex WHERE wid = :wid AND date_loc = :date_loc');
	$stmt->bindValue(':wid', $json['wid'], PDO::PARAM_INT);	
	$stmt->bindValue(':date_loc', $json['date'], PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetchColumn();
	$stmt->closeCursor();
	$status = $result;
	if($result == 0){
		$SQL = 'INSERT INTO hilowex(wid, time_utc, time_loc, date_loc, xt0_tl, xt0_l, xt0_th, xt0_h, xt1_tl, xt1_l, xt1_th, xt1_h, xt2_tl, xt2_l, xt2_th, xt2_h, xt3_tl, xt3_l, xt3_th, xt3_h, xt4_tl, xt4_l, xt4_th, xt4_h, xt5_tl, xt5_l, xt5_th, xt5_h, xt6_tl, xt6_l, xt6_th, xt6_h, xh0_tl, xh0_l, xh0_th, xh0_h, xh1_tl, xh1_l, xh1_th, xh1_h, xh2_tl, xh2_l, xh2_th, xh2_h, xh3_tl, xh3_l, xh3_th, xh3_h, xh4_tl, xh4_l, xh4_th, xh4_h, xh5_tl, xh5_l, xh5_th, xh5_h, xh6_tl, xh6_l, xh6_th, xh6_h, xst0_tl, xst0_l, xst0_th, xst0_h, xst1_tl, xst1_l, xst1_th, xst1_h, xst2_tl, xst2_l, xst2_th, xst2_h, xst3_tl, xst3_l, xst3_th, xst3_h, xlt0_tl, xlt0_l, xlt0_th, xlt0_h, xlt1_tl, xlt1_l, xlt1_th, xlt1_h, xlt2_tl, xlt2_l, xlt2_th, xlt2_h, xlt3_tl, xlt3_l, xlt3_th, xlt3_h, xsm0_tl, xsm0_l, xsm0_th, xsm0_h, xsm1_tl, xsm1_l, xsm1_th, xsm1_h, xsm2_tl, xsm2_l, xsm2_th, xsm2_h, xsm3_tl, xsm3_l, xsm3_th, xsm3_h, xlw0_tl, xlw0_l, xlw0_th, xlw0_h, xlw1_tl, xlw1_l, xlw1_th, xlw1_h, xlw2_tl, xlw2_l, xlw2_th, xlw2_h, xlw3_tl, xlw3_l, xlw3_th, xlw3_h)
						VALUES(   :wid,:time_utc,:time_loc,:date_loc,:xt0_tl,:xt0_l,:xt0_th,:xt0_h,:xt1_tl,:xt1_l,:xt1_th,:xt1_h,:xt2_tl,:xt2_l,:xt2_th,:xt2_h,:xt3_tl,:xt3_l,:xt3_th,:xt3_h,:xt4_tl,:xt4_l,:xt4_th,:xt4_h,:xt5_tl,:xt5_l,:xt5_th,:xt5_h,:xt6_tl,:xt6_l,:xt6_th,:xt6_h,:xh0_tl,:xh0_l,:xh0_th,:xh0_h,:xh1_tl,:xh1_l,:xh1_th,:xh1_h,:xh2_tl,:xh2_l,:xh2_th,:xh2_h,:xh3_tl,:xh3_l,:xh3_th,:xh3_h,:xh4_tl,:xh4_l,:xh4_th,:xh4_h,:xh5_tl,:xh5_l,:xh5_th,:xh5_h,:xh6_tl,:xh6_l,:xh6_th,:xh6_h,:xst0_tl,:xst0_l,:xst0_th,:xst0_h,:xst1_tl,:xst1_l,:xst1_th,:xst1_h,:xst2_tl,:xst2_l,:xst2_th,:xst2_h,:xst3_tl,:xst3_l,:xst3_th,:xst3_h,:xlt0_tl,:xlt0_l,:xlt0_th,:xlt0_h,:xlt1_tl,:xlt1_l,:xlt1_th,:xlt1_h,:xlt2_tl,:xlt2_l,:xlt2_th,:xlt2_h,:xlt3_tl,:xlt3_l,:xlt3_th,:xlt3_h,:xsm0_tl,:xsm0_l,:xsm0_th,:xsm0_h,:xsm1_tl,:xsm1_l,:xsm1_th,:xsm1_h,:xsm2_tl,:xsm2_l,:xsm2_th,:xsm2_h,:xsm3_tl,:xsm3_l,:xsm3_th,:xsm3_h,:xlw0_tl,:xlw0_l,:xlw0_th,:xlw0_h,:xlw1_tl,:xlw1_l,:xlw1_th,:xlw1_h,:xlw2_tl,:xlw2_l,:xlw2_th,:xlw2_h,:xlw3_tl,:xlw3_l,:xlw3_th,:xlw3_h)';
	}else{						
		$SQL = 'UPDATE hilowex SET time_utc = :time_utc, time_loc = :time_loc, xt0_tl = :xt0_tl, xt0_l = :xt0_l, xt0_th = :xt0_th, xt0_h = :xt0_h, xt1_tl = :xt1_tl, xt1_l = :xt1_l, xt1_th = :xt1_th, xt1_h = :xt1_h, xt2_tl = :xt2_tl, xt2_l = :xt2_l, xt2_th = :xt2_th, xt2_h = :xt2_h, xt3_tl = :xt3_tl, xt3_l = :xt3_l, xt3_th = :xt3_th, xt3_h = :xt3_h, xt4_tl = :xt4_tl, xt4_l = :xt4_l, xt4_th = :xt4_th, xt4_h = :xt4_h, xt5_tl = :xt5_tl, xt5_l = :xt5_l, xt5_th = :xt5_th, xt5_h = :xt5_h, xt6_tl = :xt6_tl, xt6_l = :xt6_l, xt6_th = :xt6_th, xt6_h = :xt6_h, xh0_tl = :xh0_tl, xh0_l = :xh0_l, xh0_th = :xh0_th, xh0_h = :xh0_h, xh1_tl = :xh1_tl, xh1_l = :xh1_l, xh1_th = :xh1_th, xh1_h = :xh1_h, xh2_tl = :xh2_tl, xh2_l = :xh2_l, xh2_th = :xh2_th, xh2_h = :xh2_h, xh3_tl = :xh3_tl, xh3_l = :xh3_l, xh3_th = :xh3_th, xh3_h = :xh3_h, xh4_tl = :xh4_tl, xh4_l = :xh4_l, xh4_th = :xh4_th, xh4_h = :xh4_h, xh5_tl = :xh5_tl, xh5_l = :xh5_l, xh5_th = :xh5_th, xh5_h = :xh5_h, xh6_tl = :xh6_tl, xh6_l = :xh6_l, xh6_th = :xh6_th, xh6_h = :xh6_h, xst0_tl = :xst0_tl, xst0_l = :xst0_l, xst0_th = :xst0_th, xst0_h = :xst0_h, xst1_tl = :xst1_tl, xst1_l = :xst1_l, xst1_th = :xst1_th, xst1_h = :xst1_h, xst2_tl = :xst2_tl, xst2_l = :xst2_l, xst2_th = :xst2_th, xst2_h = :xst2_h, xst3_tl = :xst3_tl, xst3_l = :xst3_l, xst3_th = :xst3_th, xst3_h = :xst3_h, xlt0_tl = :xlt0_tl, xlt0_l = :xlt0_l, xlt0_th = :xlt0_th, xlt0_h = :xlt0_h, xlt1_tl = :xlt1_tl, xlt1_l = :xlt1_l, xlt1_th = :xlt1_th, xlt1_h = :xlt1_h, xlt2_tl = :xlt2_tl, xlt2_l = :xlt2_l, xlt2_th = :xlt2_th, xlt2_h = :xlt2_h, xlt3_tl = :xlt3_tl, xlt3_l = :xlt3_l, xlt3_th = :xlt3_th, xlt3_h = :xlt3_h, xsm0_tl = :xsm0_tl, xsm0_l = :xsm0_l, xsm0_th = :xsm0_th, xsm0_h = :xsm0_h, xsm1_tl = :xsm1_tl, xsm1_l = :xsm1_l, xsm1_th = :xsm1_th, xsm1_h = :xsm1_h, xsm2_tl = :xsm2_tl, xsm2_l = :xsm2_l, xsm2_th = :xsm2_th, xsm2_h = :xsm2_h, xsm3_tl = :xsm3_tl, xsm3_l = :xsm3_l, xsm3_th = :xsm3_th, xsm3_h = :xsm3_h, xlw0_tl = :xlw0_tl, xlw0_l = :xlw0_l, xlw0_th = :xlw0_th, xlw0_h = :xlw0_h, xlw1_tl = :xlw1_tl, xlw1_l = :xlw1_l, xlw1_th = :xlw1_th, xlw1_h = :xlw1_h, xlw2_tl = :xlw2_tl, xlw2_l = :xlw2_l, xlw2_th = :xlw2_th, xlw2_h = :xlw2_h, xlw3_tl = :xlw3_tl, xlw3_l = :xlw3_l, xlw3_th = :xlw3_th, xlw3_h = :xlw3_h
								WHERE wid = :wid AND date_loc = :date_loc';
	}
	try{
	 $stmt = $db->prepare($SQL);
		$stmt->bindValue(':wid',  $json['wid'], PDO::PARAM_INT);
		$stmt->bindValue(':time_utc',  $json['tutc'], PDO::PARAM_INT);
		$stmt->bindValue(':time_loc',  $json['time'], PDO::PARAM_INT);
		$stmt->bindValue(':date_loc',  $json['date'], PDO::PARAM_INT);
		$stmt->bindValue(':xt0_tl',  $json['hlxt0'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xt0_l',  $json['hlxt0'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xt0_th',  $json['hlxt0'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xt0_h',  $json['hlxt0'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xt1_tl',  $json['hlxt1'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xt1_l',  $json['hlxt1'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xt1_th',  $json['hlxt1'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xt1_h',  $json['hlxt1'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xt2_tl',  $json['hlxt2'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xt2_l',  $json['hlxt2'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xt2_th',  $json['hlxt2'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xt2_h',  $json['hlxt2'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xt3_tl',  $json['hlxt3'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xt3_l',  $json['hlxt3'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xt3_th',  $json['hlxt3'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xt3_h',  $json['hlxt3'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xt4_tl',  $json['hlxt4'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xt4_l',  $json['hlxt4'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xt4_th',  $json['hlxt4'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xt4_h',  $json['hlxt4'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xt5_tl',  $json['hlxt5'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xt5_l',  $json['hlxt5'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xt5_th',  $json['hlxt5'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xt5_h',  $json['hlxt5'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xt6_tl',  $json['hlxt6'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xt6_l',  $json['hlxt6'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xt6_th',  $json['hlxt6'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xt6_h',  $json['hlxt6'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xh0_tl',  $json['hlxh0'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xh0_l',  $json['hlxh0'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xh0_th',  $json['hlxh0'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xh0_h',  $json['hlxh0'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xh1_tl',  $json['hlxh1'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xh1_l',  $json['hlxh1'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xh1_th',  $json['hlxh1'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xh1_h',  $json['hlxh1'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xh2_tl',  $json['hlxh2'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xh2_l',  $json['hlxh2'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xh2_th',  $json['hlxh2'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xh2_h',  $json['hlxh2'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xh3_tl',  $json['hlxh3'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xh3_l',  $json['hlxh3'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xh3_th',  $json['hlxh3'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xh3_h',  $json['hlxh3'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xh4_tl',  $json['hlxh4'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xh4_l',  $json['hlxh4'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xh4_th',  $json['hlxh4'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xh4_h',  $json['hlxh4'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xh5_tl',  $json['hlxh5'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xh5_l',  $json['hlxh5'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xh5_th',  $json['hlxh5'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xh5_h',  $json['hlxh5'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xh6_tl',  $json['hlxh6'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xh6_l',  $json['hlxh6'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xh6_th',  $json['hlxh6'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xh6_h',  $json['hlxh6'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xst0_tl',  $json['hlxst0'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xst0_l',  $json['hlxst0'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xst0_th',  $json['hlxst0'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xst0_h',  $json['hlxst0'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xst1_tl',  $json['hlxst1'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xst1_l',  $json['hlxst1'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xst1_th',  $json['hlxst1'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xst1_h',  $json['hlxst1'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xst2_tl',  $json['hlxst2'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xst2_l',  $json['hlxst2'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xst2_th',  $json['hlxst2'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xst2_h',  $json['hlxst2'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xst3_tl',  $json['hlxst3'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xst3_l',  $json['hlxst3'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xst3_th',  $json['hlxst3'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xst3_h',  $json['hlxst3'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xlt0_tl',  $json['hlxlt0'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xlt0_l',  $json['hlxlt0'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xlt0_th',  $json['hlxlt0'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xlt0_h',  $json['hlxlt0'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xlt1_tl',  $json['hlxlt1'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xlt1_l',  $json['hlxlt1'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xlt1_th',  $json['hlxlt1'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xlt1_h',  $json['hlxlt1'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xlt2_tl',  $json['hlxlt2'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xlt2_l',  $json['hlxlt2'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xlt2_th',  $json['hlxlt2'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xlt2_h',  $json['hlxlt2'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xlt3_tl',  $json['hlxlt3'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xlt3_l',  $json['hlxlt3'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xlt3_th',  $json['hlxlt3'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xlt3_h',  $json['hlxlt3'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xsm0_tl',  $json['hlxsm0'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xsm0_l',  $json['hlxsm0'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xsm0_th',  $json['hlxsm0'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xsm0_h',  $json['hlxsm0'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xsm1_tl',  $json['hlxsm1'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xsm1_l',  $json['hlxsm1'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xsm1_th',  $json['hlxsm1'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xsm1_h',  $json['hlxsm1'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xsm2_tl',  $json['hlxsm2'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xsm2_l',  $json['hlxsm2'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xsm2_th',  $json['hlxsm2'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xsm2_h',  $json['hlxsm2'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xsm3_tl',  $json['hlxsm3'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xsm3_l',  $json['hlxsm3'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xsm3_th',  $json['hlxsm3'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xsm3_h',  $json['hlxsm3'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xlw0_tl',  $json['hlxlw0'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xlw0_l',  $json['hlxlw0'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xlw0_th',  $json['hlxlw0'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xlw0_h',  $json['hlxlw0'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xlw1_tl',  $json['hlxlw1'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xlw1_l',  $json['hlxlw1'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xlw1_th',  $json['hlxlw1'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xlw1_h',  $json['hlxlw1'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xlw2_tl',  $json['hlxlw2'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xlw2_l',  $json['hlxlw2'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xlw2_th',  $json['hlxlw2'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xlw2_h',  $json['hlxlw2'][3], PDO::PARAM_INT);
		$stmt->bindValue(':xlw3_tl',  $json['hlxlw3'][0], PDO::PARAM_INT);
		$stmt->bindValue(':xlw3_l',  $json['hlxlw3'][1], PDO::PARAM_INT);
		$stmt->bindValue(':xlw3_th',  $json['hlxlw3'][2], PDO::PARAM_INT);
		$stmt->bindValue(':xlw3_h',  $json['hlxlw3'][3], PDO::PARAM_INT);
		$result = $stmt->execute();
		$results = $stmt->rowCount();
		$stmt->closeCursor();
						
	}catch(Exception $e){
		$error++;
		//$e->getMessage( );// , (int)$Exception->getCode( )
		var_dump($e->getMessage());
		data_log('HILOWEX: '.ob_get_contents() );
		ob_clean();
	}
	

unset($stmt);
//$db = null;
$status = 'hilowex_ok';
$contentdata = null;
	
}
	
if($json['type'] == 'logger' && $json['data'] != null && $_SERVER[HTTP_X_WIFILOGGER_STA_MAC] == $json['data'][0]['lwid']){
require_once 'database.php';
// Add new logger entries


 $stmt = $db->prepare('INSERT INTO logger(wid, time, date, time_utc, davis_timestamp, temp_out, temp_high_out, temp_low_out, temp_in, hum_out, hum_in, barometer, rainfall, rain_high_rate, wind_avg, wind_dir_avg, wind_high, wind_dir_high, uv_avg, uv_high, et, solar_radiation, solar_high, temp_leaf_0, temp_leaf_1, wet_leaf_0, wet_leaf_1, temp_soil_0, temp_soil_1, temp_soil_2, temp_soil_3, hum_extra_0, hum_extra_1, temp_extra_0, temp_extra_1, temp_extra_2, soil_moist_0, soil_moist_1, soil_moist_2, soil_moist_3, forecast_rule, wind_samples)
                         VALUES(         :wid,:time,:date,:time_utc,:davis_timestamp,:temp_out,:temp_high_out,:temp_low_out,:temp_in,:hum_out,:hum_in,:barometer,:rainfall,:rain_high_rate,:wind_avg,:wind_dir_avg,:wind_high,:wind_dir_high,:uv_avg,:uv_high,:et,:solar_radiation,:solar_high,:temp_leaf_0,:temp_leaf_1,:wet_leaf_0,:wet_leaf_1,:temp_soil_0,:temp_soil_1,:temp_soil_2,:temp_soil_3,:hum_extra_0,:hum_extra_1,:temp_extra_0,:temp_extra_1,:temp_extra_2,:soil_moist_0,:soil_moist_1,:soil_moist_2,:soil_moist_3,:forecast_rule,:wind_samples
						 
                        )');
	foreach ($json['data'] as $k=>$archjson){
		try {
			$stmt->bindValue(':wid', $archjson['lwid'], PDO::PARAM_INT);	
			$stmt->bindValue(':time', $archjson['ltime'], PDO::PARAM_INT);
			$stmt->bindValue(':date', $archjson['ldate'], PDO::PARAM_STR);
			$stmt->bindValue(':time_utc', $archjson['ltutc'], PDO::PARAM_INT);
			$stmt->bindValue(':davis_timestamp', $archjson['ldavists'], PDO::PARAM_INT);
			$stmt->bindValue(':temp_out', $archjson['ltempout'], PDO::PARAM_INT);
			$stmt->bindValue(':temp_high_out', $archjson['lhtempout'], PDO::PARAM_INT);
			$stmt->bindValue(':temp_low_out', $archjson['lltempout'], PDO::PARAM_INT);
			$stmt->bindValue(':rainfall', $archjson['lrain'], PDO::PARAM_INT);
			$stmt->bindValue(':rain_high_rate', $archjson['lrainrate'], PDO::PARAM_INT);
			$stmt->bindValue(':barometer', $archjson['lbar'], PDO::PARAM_INT);
			$stmt->bindValue(':temp_in', $archjson['ltempin'], PDO::PARAM_INT);
			$stmt->bindValue(':hum_in', $archjson['lhumin'], PDO::PARAM_INT);
			$stmt->bindValue(':hum_out', $archjson['lhumout'], PDO::PARAM_INT);
			$stmt->bindValue(':wind_avg', $archjson['lwindspd'], PDO::PARAM_INT);
			$stmt->bindValue(':wind_dir_avg', $archjson['lwinddir'], PDO::PARAM_INT);
			$stmt->bindValue(':wind_high', $archjson['lgust'], PDO::PARAM_INT);
			$stmt->bindValue(':wind_dir_high', $archjson['lgustdir'], PDO::PARAM_INT);
			$stmt->bindValue(':uv_avg', $archjson['luv'], PDO::PARAM_INT);
			$stmt->bindValue(':uv_high', $archjson['lhuv'], PDO::PARAM_INT);
			$stmt->bindValue(':solar_radiation', $archjson['lsolar'], PDO::PARAM_INT);
			$stmt->bindValue(':solar_high', $archjson['lhsolar'], PDO::PARAM_INT);
			$stmt->bindValue(':et', $archjson['let'], PDO::PARAM_INT);
			$stmt->bindValue(':temp_leaf_0', $archjson['lxlt'][0], PDO::PARAM_INT);
			$stmt->bindValue(':temp_leaf_1', $archjson['lxlt'][1], PDO::PARAM_INT);
			$stmt->bindValue(':wet_leaf_0', $archjson['lxlw'][0], PDO::PARAM_INT);
			$stmt->bindValue(':wet_leaf_1', $archjson['lxlw'][1], PDO::PARAM_INT);
			$stmt->bindValue(':temp_soil_0', $archjson['lxst'][0], PDO::PARAM_INT);
			$stmt->bindValue(':temp_soil_1', $archjson['lxst'][1], PDO::PARAM_INT);
			$stmt->bindValue(':temp_soil_2', $archjson['lxst'][2], PDO::PARAM_INT);
			$stmt->bindValue(':temp_soil_3', $archjson['lxst'][3], PDO::PARAM_INT);
			$stmt->bindValue(':soil_moist_0', $archjson['lxsm'][0], PDO::PARAM_INT);
			$stmt->bindValue(':soil_moist_1', $archjson['lxsm'][1], PDO::PARAM_INT);
			$stmt->bindValue(':soil_moist_2', $archjson['lxsm'][2], PDO::PARAM_INT);
			$stmt->bindValue(':soil_moist_3', $archjson['lxsm'][3], PDO::PARAM_INT);
			$stmt->bindValue(':hum_extra_0', $archjson['lxh'][0], PDO::PARAM_INT);
			$stmt->bindValue(':hum_extra_1', $archjson['lxh'][1], PDO::PARAM_INT);
			$stmt->bindValue(':temp_extra_0', $archjson['lxt'][0], PDO::PARAM_INT);
			$stmt->bindValue(':temp_extra_1', $archjson['lxt'][1], PDO::PARAM_INT);
			$stmt->bindValue(':temp_extra_2', $archjson['lxt'][2], PDO::PARAM_INT);
			$stmt->bindValue(':wind_samples', $archjson['lwsamp'], PDO::PARAM_INT);
			$stmt->bindValue(':forecast_rule', $archjson['lfrule'], PDO::PARAM_INT);
			$result = $stmt->execute();
			$results += $stmt->rowCount();
			$stmt->closeCursor();
	
		} catch (Exception $e) {
			$error++;
			var_dump($e->getMessage());
			data_log('LOGGER: '.ob_get_contents() );
			ob_clean();
		}
	}


unset($stmt);
//$db = null;
$status = 'logger_ok';
$contentdata = null;
}


//Return time of last data entry
if($json['type'] == 'lastlog' && $_SERVER[HTTP_X_WIFILOGGER_STA_MAC] == $json['wid']){
require_once 'database.php';

try{
		$stmt = $db->prepare('SELECT log_id, wid, davis_timestamp, time_utc FROM logger WHERE wid= :wid ORDER BY time_utc DESC LIMIT 1');
		$stmt->bindValue(':wid', $json['wid'], PDO::PARAM_INT);
		$result = $stmt->execute();
		$results = $stmt->rowCount();
		if($results == 0){
			$contentdata = 637534208;
		}else{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
			 //wh_log($row['log_id']." ".$row['wid']." ".$row['davis_timestamp']." ".$row['time_utc']);
			  $contentdata = $row['davis_timestamp'];

			}
		}
		$stmt->closeCursor();		
}catch (Exception $e) {	
			$error++;
			var_dump($e->getMessage());
			data_log('LASTLOG: '.ob_get_contents() );
			ob_clean();
		}
unset($stmt);
$db = null;
$status = 'lastlog_ok';

}


$exitjson = array('error' => $error, 'status' => $status, 'content' => $contentdata, 'results' => $results);
echo json_encode($exitjson);
?>