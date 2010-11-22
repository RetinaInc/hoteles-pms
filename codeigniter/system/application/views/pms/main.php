
<?php

$this->load->view('pms/header'); 
		
$datestring = "%Y-%m-%d";
$time       = time();
$today      = mdate($datestring, $time);
$weekDays   = array('Domingo', 'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado', 'Domingo');
$currDay    = date('l', strtotime($today));
$sCurrDay   = $weekDays[date('N', strtotime($currDay))];

$timestamp       = time();
$timezone        = 'UM45';
$daylight_saving = FALSE;
$time            = gmt_to_local($timestamp, $timezone, $daylight_saving);
//$datestring      = "%d/%m/%Y - %h:%i:%s %a";
$datestring      = "%d/%m/%Y";
$date            = mdate($datestring, $time);

echo $sCurrDay.' '.$date;

echo "<br><br>";

foreach ($hotelInfo as $row)
{
	echo 'HOTEL: ', $row['name']."<br><br>";
}

foreach ($userInfo as $row)
{
	echo 'Usuario: ', $row['name'].' '.$row['lastName']."<br>";
	echo 'Rol: ', lang($row['role'])."<br>";
}


?>
