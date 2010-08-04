
<?php

$this->load->view('pms/header'); 

foreach ($hotelInfo as $row)
{
	echo 'HOTEL: ', $row['name']."<br><br>";
}

foreach ($userInfo as $row)
{
	echo 'Usuario: ', $row['name'].' '.$row['lastName']."<br>";
	echo 'Rol: ', $row['role']."<br>";
}



?>
