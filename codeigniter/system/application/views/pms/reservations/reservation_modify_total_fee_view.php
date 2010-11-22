
<?php
$this->load->view('pms/header');
?>

<h3>Modificar Monto Habitación</h3>

<span class="Estilo1">
	<?php
    echo validation_errors();
    ?>
</span>

<?php  
foreach ($reservation as $row) {
	
	$reservationId = $row['id_reservation'];
	$status        = $row['status'];
	$totalFee      = $row['totalFee'];
	$checkIn       = $row['checkIn'];
	$checkOut      = $row['checkOut'];
}

$total = 0;

foreach ($reservationRoomInfo as $row) {
		
	$total = $total + $row['total'];
}

?>

<table width="318" border="0">

  <tr>
	<td width="120">Reservación</td>
	<td width="188"># 
		<?php 
		echo $reservationId;
		?>          	
	</td>
  </tr>
  
  <?php
  $checkIn_array = explode (' ', $checkIn);
  $ciDate        = $checkIn_array[0];

  $checkOut_array = explode (' ', $checkOut);
  $coDate         = $checkOut_array[0];
  
  $nights = (strtotime($coDate) - strtotime($ciDate)) / (60 * 60 * 24);
  
  $weekDays = array('Dom', 'Lun','Mar','Mie','Jue','Vie','Sab', 'Dom');
  
  $checkInDate = date('l', strtotime($ciDate));
  $checkInDay  = $weekDays[date('N', strtotime($checkInDate))];
  $unixInDate  = human_to_unix($checkIn);
  $checkInDate = date ("j/m/Y" , $unixInDate);

  $checkOutDate = date('l', strtotime($coDate));
  $checkOutDay  = $weekDays[date('N', strtotime($checkOutDate))];
  $unixCoDate   = human_to_unix($checkOut);
  $checkOutDate = date ("j/m/Y" , $unixCoDate);
  ?>
  
  <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  
  <tr>
	<td>Estado: </td>
	<td>
		<?php 
		echo lang($status);
		?>           	
	</td>
  </tr>
  
  <tr>
	<td>Fecha llegada:</td>
	<td>
		<?php 
		echo $checkInDay.' '.$checkInDate;;
		?>          	
	</td>
  </tr>
  
  <tr>
	<td>Fecha salida: </td>
	<td>
		<?php 
		echo $checkOutDay.' '.$checkOutDate;
		?>           	
	</td>
  </tr>
  
  <tr>
	<td>Noches: </td>
	<td>
		<?php
		echo $nights;
		?>          	
	</td>
  </tr>
  
  <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  
  <tr>
	<td>Total reservación</td>
	<td>
		<?php 
		echo $total.' Bs.F.';
		?> 
	</td>
  </tr>
  <tr>
	<td>Recargo: </td>
	<td>
		<?php
		echo $cancelFee.'%';
		?>
	</td>
  </tr>
  <tr>
	<td>Monto a pagar: </td>
	<td>
		<?php
		echo $totalFee.' Bs.F.';
		?>
	</td>
  </tr>
</table>
    
<br />

<?php
echo form_open('reservations/modifyReservationFee/'.$reservationId);
?>

<table width="424" border="0">
  <tr>
    <td width="170">Nuevo monto a pagar: </td>
    
    <td width="140">
      <input type="text" name="new_total_fee" id="new_total_fee" value="<?php echo set_value('new_total_fee')?>" maxlength="10" size="10" 
        onKeyPress="return pricenumbers(this, event)"/> Bs.F. 
    </td>
    
    <td width="100">
		<?php 
		$att = array(
			'name'        => 'submit',
    		'id'          => 'submit',
    		'onClick'     => "return confirm('Seguro que desea guardar?')"
			);
		echo form_submit($att, 'Guardar');
        ?>    </td>
  </tr>
</table>

<?php
echo form_close();

echo anchor('reservations/infoReservation/'.$reservationId.'/n/', 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));
?>
