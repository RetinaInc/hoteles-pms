
<?php 

$this->load->view('header');

echo 'RESERVACIONES PENDIENTES'."<br>";
echo anchor(base_url().'reservations/view_all_reservations/','Ver Todas')."<br><br>";
echo anchor(base_url().'reservations/create_reservation_1/','Crear Nueva Reservación')."<br><br>";?>

<table width="852" border="1">
  <tr>
    <td width="101">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'reservations/view_pending_reservations');
		echo form_hidden('order', 'ID_RESERVATION');
		echo form_submit('sumit', '^');
        echo form_close();
		?>  	</td>
	<td width="187">
        <?php
		echo 'Nombre Cliente ';
        echo form_open(base_url().'reservations/view_pending_reservations');
		echo form_hidden('order', 'GLNAME');
		echo form_submit('sumit', '^');
        echo form_close();
		?>   	</td>
	<td width="110">
    	<?php
		echo 'Fecha Check-In';
        echo form_open(base_url().'reservations/view_pending_reservations');
		echo form_hidden('order', 'CHECK_IN');
		echo form_submit('sumit', '^');
        echo form_close();
		?>  	</td>
	<td width="119">
    	<?php
		echo 'Fecha Check-Out';
        echo form_open(base_url().'reservations/view_pending_reservations');
		echo form_hidden('order', 'CHECK_OUT');
		echo form_submit('sumit', '^');
        echo form_close();
		?> 	</td>
	<td width="150">
    	<?php
		echo 'Estado';
        echo form_open(base_url().'reservations/view_pending_reservations');
		echo form_hidden('order', 'STATUS');
		echo form_submit('sumit', '^');
        echo form_close();
		?>   	</td>
    <td width="59">Habitación(nes)</td>
    <td width="37">Pago</td>
    <td width="37">Debe</td>
  </tr>
	
  <?php foreach ($reservations as $row)
  {$reservation_rooms = get_count('ROOM_RESERVATION', 'FK_ID_RESERVATION', $row['ID_RESERVATION'], null, null);?>
  <tr>
    <td><?php echo anchor(base_url().'reservations/info_reservation/'.$row['ID_RESERVATION'],$row['ID_RESERVATION']);?></td>
    <td>
    	<?php 
		foreach ($guests as $row1)
		{
			if ($row1['ID_GUEST'] == $row['FK_ID_GUEST'])
			{
				if ($row1['DISABLE'] == 1)
				{
					echo anchor(base_url().'guests/info_guest_reservations/'.$row1['ID_GUEST'],$row1['LAST_NAME'].', '.$row1['NAME']);
				}
				else
				{
					echo $row1['LAST_NAME'].', '.$row1['NAME'];
				}
			}
		}
		?>
    </td>
    <td>
		<?php
		$check_in = $row['CHECK_IN'];
		$check_in_array = explode (' ',$check_in);
		$date = $check_in_array[0];
		$date_array = explode ('-',$date);
		$year = $date_array[0];
		$month = $date_array[1];
		$day = $date_array[2];
		echo $day.'-'.$month.'-'.$year;
		?>
    </td>
    <td>
		<?php 
		$check_out = $row['CHECK_OUT'];
		$check_out_array = explode (' ',$check_out);
		$date = $check_out_array[0];
		$date_array = explode ('-',$date);
		$year = $date_array[0];
		$month = $date_array[1];
		$day = $date_array[2];
		echo $day.'-'.$month.'-'.$year;
		?>
    </td>
    <td><?php echo lang($row['STATUS']);?></td>
    <td>
    <?php 
	echo $reservation_rooms;
    foreach($rooms as $row1)
	{
		if ($row1['ID_RESERVATION'] == $row['ID_RESERVATION'])
		{
			echo ' ('.$row1 ['NUMBER'].')';
		}
	}?>
   </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
</table>

