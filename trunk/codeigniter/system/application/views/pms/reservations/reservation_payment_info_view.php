
<html>

<?php 
$this->load->view('pms/header'); 

echo 'PAGO RESERVACIÓN # ';

foreach ($payment as $row) {

	$reservationId = $row['fk_reservation'];
	echo $reservationId."<br>";
?>

<br>
<table width="266" border="1">

  <tr>
    <td width="100" height="40">Fecha</td>
    <td width="150">
	<?php 
		$unixDate = human_to_unix($row['date']);
		echo date ("j/m/Y" , $unixCi); 
	?>    
    </td>
  </tr>
  
  <tr>
    <td height="40">Monto</td>
    <td><?php echo $row['amount'] ?> Bs.F.</td>
  </tr>
  
  <tr>
    <td height="40">Tipo de pago</td>
    <td><?php echo lang($row['type']) ?></td>
  </tr>
  
  <?php 
  if ($row['type'] == 'check') {
  ?>
  <tr>
    <td height="40">Banco</td>
    <td><?php echo $row['bank']; ?></td>
  </tr>
  <?php
  }
  ?>
  
  <?php 
  if (($row['type'] == 'check') || ($row['type'] == 'transfer')) {
  ?>
  <tr>
    <td height="40">Número</td>
    <td><?php echo $row['confirmNum']; ?></td>
  </tr>
  <?php
  }
  ?>
  
  <tr>
    <td height="40">Cliente</td>
    <td>
	<?php 
		echo 'CI: ', $row['persId']."<br>";
		echo $row['persName'];
	?>
    </td>
  </tr>
  
  <?php 
  if ($row['details'] != NULL) {
  ?>
  <tr>
    <td height="40">Detalles</td>
    <td><?php echo $row['details']; ?></td>
  </tr>
  <?php
  }
  ?>
  
  <tr>
    <td height="40">Usuario</td>
    <td>
	<?php 
	$hotel = $this->session->userdata('hotelid');
	$userInfo = getInfo($hotel, 'USER', 'id_user', $row['fk_user'], null, null, null, 1);
	foreach ($userInfo as $row1) {
		echo $row1['name'].' '.$row1['name2'].' '.$row1['lastName'].' '.$row1['lastName2'].' ';
	}
	?>
    </td>
  </tr>
  
</table>
<?php
}

echo "<br>".anchor ('reservations/viewReservationPayments/'.$reservationId, 'Volver')
?>

</html>