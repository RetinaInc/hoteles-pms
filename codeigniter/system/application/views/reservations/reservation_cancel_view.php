

<?php 

$this->load->view('pms/header'); 


foreach ($guest as $row)
{
	echo 'Cliente: '.$row['NAME'].' '.$row['LAST_NAME']."<br>";	
}

foreach ($reservation as $row)
{
	echo 'Reservaci�n #: ', $row['ID_RESERVATION']."<br>";
	echo 'Estado: ', lang($row['STATUS'])."<br>"; 
	$unix_ci = human_to_unix($row['CHECK_IN']);
	$unix_co = human_to_unix($row['CHECK_OUT']);
	echo 'Check In: ', date ("D  j/m/Y  g:i a" , $unix_ci)."<br>";
	echo 'Check Out: ', date ("D  j/m/Y  g:i a" , $unix_co)."<br>";
	
	foreach ($room as $row1)
	{
		echo '# Habitaci�n: ', $row1['NUMBER']."<br>";
		if ($row1['RNAME'] != NULL)
		{
			echo 'Habitaci�n: ', $row1['RNAME']."<br>";
		}
		echo 'Tipo habitaci�n: ', $row1['ABRV']."<br>";
		
		foreach ($reservation_room_info as $row2)
		{
			if ($row2['FK_ID_ROOM'] == $row1['ID_ROOM'])
			{
				echo 'N�mero de adultos: ', $row2['ADULTS']."<br>";
				if ($row2['CHILDREN'] != NULL)
				{
					echo 'N�mero de ni�os: ', $row2['CHILDREN']."<br><br>";
				}
			}
		}
	}

}
   
echo anchor(base_url().'reservations/cancelReservation/'.$reservation_id,'Cancelar Reservaci�n')."<br>";

$referer = $_SERVER['HTTP_REFERER'];
echo "<a href='" . $referer . "'> Volver</a><br>";

?>
