
<?php 
$this->load->view('pms/header');
?>

<h3>RESERVACIONES</h3>

<?php
echo anchor(base_url().'reservations/addReservation/','Crear Nueva Reservación')."<br><br>";
?>

<table width="1057" border="1">

  <tr>
    <td width="101">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'reservations/viewReservations');
		echo form_hidden('order', 'RE.id_reservation');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="94">
   	<?php
		echo '# Habitación';
        echo form_open(base_url().'reservations/viewReservations');
		echo form_hidden('order', 'RO.number');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
  <td width="101">
    	<?php
		echo 'Tipo habitación';
        echo form_open(base_url().'reservations/viewReservations');
		echo form_hidden('order', 'RT.abrv');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
<td width="205">
        <?php
		echo 'Nombre Cliente ';
        echo form_open(base_url().'reservations/viewReservations');
		echo form_hidden('order', 'G.lastName');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
<td width="114">
    	<?php
		echo 'Fecha Check-In';
        echo form_open(base_url().'reservations/viewReservations');
		echo form_hidden('order', 'RE.checkIn DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
  <td width="114">
    	<?php
		echo 'Fecha Check-Out';
        echo form_open(base_url().'reservations/viewReservations');
		echo form_hidden('order', 'RE.checkOut DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
<td width="163">
    	<?php
		echo 'Estado';
        echo form_open(base_url().'reservations/viewReservations');
		echo form_hidden('order', 'RE.status');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="54">Pago</td>
    <td width="53">Debe</td>
  </tr>
	
  <?php foreach ($reservations as $row) {?>
  <tr>
    <td><?php echo anchor(base_url().'reservations/infoReservation/'.$row['id_reservation'],$row['id_reservation']);?></td>
    <td><?php echo $row['number'];?></td>
    <td><?php echo $row['abrv'];?></td>
    <td><?php echo $row['lastName'].', '.$row['name'];?></td>
    <td>
		<?php
		$checkIn       = $row['checkIn'];
		$checkIn_array = explode (' ',$checkIn);
		$date          = $checkIn_array[0];
		$date_array    = explode ('-',$date);
		$year          = $date_array[0];
		$month         = $date_array[1];
		$day           = $date_array[2];
		echo $day.'-'.$month.'-'.$year;
		?>
    </td>
    <td>
		<?php 
		$checkOut       = $row['checkOut'];
		$checkOut_array = explode (' ',$checkOut);
		$date           = $checkOut_array[0];
		$date_array     = explode ('-',$date);
		$year           = $date_array[0];
		$month          = $date_array[1];
		$day            = $date_array[2];
		echo $day.'-'.$month.'-'.$year;
		?>
    </td>
    <td><?php echo lang($row['status']);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>

</table>

