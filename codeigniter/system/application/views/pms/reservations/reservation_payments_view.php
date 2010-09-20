
<html>

<?php 
$this->load->view('pms/header'); 

echo 'PAGOS RESERVACIÓN'."<br>";

foreach ($reservation as $row) {

	$reservationId = $row['id_reservation'];
	$guestId       = $row['fk_guest'];
	
	$checkIn  = $row['checkIn'];
	$checkOut = $row['checkOut'];
			
	$checkIn_array = explode (' ',$checkIn);
	$ciDate = $checkIn_array[0];
	
	$checkOut_array = explode (' ',$checkOut);
	$coDate = $checkOut_array[0];
			
	$nights = (strtotime($coDate) - strtotime($ciDate)) / (60 * 60 * 24);
	
	$unixCi = human_to_unix($row['checkIn']);
	$unixCo = human_to_unix($row['checkOut']);
	
	echo 'Reservación # ', $reservationId."<br><br>";
	?>
	<table width="940" border="0">
	  <tr>
      	<td width="284">
		<?php 
			foreach ($guest as $row1) {
				if ($row1['id_guest'] == $guestId) {
					echo 'Cliente: ', $row1['name'].' '.$row1['name2'].' '.$row1['lastName'].' '.$row1['lastName2'];		
				}
			}
		?>        </td>
		<td width="229"><?php echo 'Tarifa ', $row['ratename']; ?></td>
		<td width="195"><?php echo 'Llegada: ', date ("D  j/m/Y" , $unixCi); ?></td>
		<td width="214"><?php echo 'Cant. noches: ', $nights; ?></td>
	  </tr>
	  <tr>
      	<td width="284"><?php echo 'Estado: ', lang($row['status']); ?></td>
		<td><?php echo 'Plan ', $row['planname']; ?></td>
		<td><?php echo 'Salida: ', date ("D  j/m/Y" , $unixCo); ?></td>
		<td><?php echo 'Cant. habitaciones: ', $reservationRoomCount;?></td>
	  </tr>
</table>
<br />
<?php
}

$total = 0;
foreach ($reservationRoomInfo as $row) {
	$total = $total + $row['total'];
}

echo 'Total reservación: ', $total.' Bs.F.'."<br>";

$paid = 0;
foreach ($payments as $row) {
	$paid = $paid + $row['amount'];
}

echo 'Total pagado: ', $paid.' Bs.F.'."<br>";

$amountToPay = $total - $paid;

echo 'Total por pagar: ', $amountToPay.' Bs.F.'."<br><br>";

?>

<table width="487" border="1">
  <tr>
    <td width="100">Fecha</td>
    <td width="150">Tipo de Pago</td>
    <td width="150">Monto</td>
    <td width="59">Detalles</td>
  </tr>
  <tr>
  	<?php
	foreach ($payments as $row) {
    ?>
    <td>
	<?php 
		$unixDate = human_to_unix($row['date']);
		echo date ("j/m/Y" , $unixCi); 
	?>    </td>
    <td><?php echo lang($row['type']) ?></td>
    <td><?php echo $row['amount'] ?> Bs.F.</td>
    <td><?php echo anchor('reservations/viewPaymentDetails/'.$row['fk_reservation'].'/'.$row['id_payment'], 'Ver');?></td>
    <?php
	}
	?>
  </tr>
</table>
<br>

<?php
echo anchor ('reservations/infoReservation/'.$reservationId, 'Volver')
?>

</html>