

<?php 

$this->load->view('header'); 

foreach ($reservation as $row)
{
	$reservation_id = $row['ID_RESERVATION'];
}

echo 'RESERVACI�N #'.$reservation_id;?><br /><br /><?php

echo 'Informaci�n del Cliente';?><br /><br /><?php
foreach ($guest as $row)
{
	echo 'Nombre: '.$row['NAME'].' '.$row['LAST_NAME'];?><br /><?php
	echo 'Tel�fono: '.$row['TELEPHONE'];?><br /><?php
	if ($row['EMAIL'] != NULL)
	{
		echo 'Correo: '.$row['EMAIL'];?><br /><?php
	}
	if ($row['ADDRESS'] != NULL)
	{
		echo 'Direcci�n: '.$row['ADDRESS'];?><br /><br /><?php
	}
}

echo 'Informaci�n de Habitaci�n';?><br /><br /><?php
foreach ($reservation as $row)
{
	echo '# Confirmaci�n: ', $row['ID_RESERVATION'];?><br /><?php
	echo '# Habitaci�n: ', $row['NUMBER'];?><br /><?php
	echo 'Tipo habitaci�n: ', $row['RTNAME'];?><br /><?php
	
	$unix_ci = human_to_unix($row['CHECK_IN']);
	$unix_co = human_to_unix($row['CHECK_OUT']);
	echo 'Check In: ', date ("D  j/m/Y  g:i a" , $unix_ci);?><br /><?php
	echo 'Check Out: ', date ("D  j/m/Y  g:i a" , $unix_co);?><br /><?php
	
	echo 'Cant. noches: ', $nights; ?><br /><?php
	echo 'Cant. habitaciones: ', $row['NUMBER'];?><br /><?php
	echo 'N�mero de adultos: ', $row['NUMBER'];?><br /><?php
	echo 'N�mero de ni�os: ', $row['NUMBER'];?><br /><?php
	echo 'Informaci�n de tarifa: ', $row['NUMBER'];?><br /><?php
	echo 'Politica de cancelacion: ', $row['NUMBER'];?><br /><?php
	

	echo 'Estado: ', lang($row['STATUS']);?><br /><br /><?php
}
   
$referer = $_SERVER['HTTP_REFERER'];
echo "<a href='" . $referer . "'> Volver</a><br>";

?>
