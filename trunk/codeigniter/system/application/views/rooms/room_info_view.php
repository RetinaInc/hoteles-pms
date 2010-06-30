

<?php 

$this->load->view('header'); 

foreach ($room as $row)
{
	$room_id = $row['ID_ROOM'];
	$room_number = $row['NUMBER'];
}

echo 'INFO HABITACIÓN #'.$room_number;?><br /><br /><?php

foreach ($room as $row)
{
	echo 'Número: ', $row['NUMBER'];?><br /><?php
	
	if ($row['NAME'] != NULL)
	{
		echo 'Nombre: ', $row['NAME'];?><br /><?php
	}
	
	echo 'Estado: ', lang($row['STATUS']);?><br /><?php
	
	echo 'Tipo de habitación: ', $row['RTNAME'];?><br /><?php
	
	foreach ($room_types as $row1)
	{
		if ($row1['ID_ROOM_TYPE'] == $row['FK_ID_ROOM_TYPE'] && $row1['DETAILS'] != NULL)
		{
			echo 'Detalles tipo de habitación: ',$row1['DETAILS'];?><br /><br /><?php
		}
	}
	
	?><a href="<?php echo base_url().'rooms/edit_room/'.$room_id?>">Editar Info</a><br /><br /><?php
	?><a href="<?php echo base_url().'rooms/delete_room/'.$room_id ?>" onClick="return confirm('Seguro que desea eliminar?')">Eliminar Habitación</a><br /><br /><?php
}

?>



<table width="900" border="1">
  <tr>
    <td width="106">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'rooms/info_room/'.$room_id);
		echo form_hidden('order', 'RE.CONFIRM_NUM');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="117">
    	<?php
		echo 'Fecha Check-In';
        echo form_open(base_url().'rooms/info_room/'.$room_id);
		echo form_hidden('order', 'RE.CHECK_IN DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="117">
    	<?php
		echo 'Fecha Check-Out';
        echo form_open(base_url().'rooms/info_room/'.$room_id);
		echo form_hidden('order', 'RE.CHECK_OUT DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="194">
    	<?php
		echo 'Nombre Cliente';
        echo form_open(base_url().'rooms/info_room/'.$room_id);
		echo form_hidden('order', 'G.LAST_NAME');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="103">
    	<?php
		echo 'Estado';
        echo form_open(base_url().'rooms/info_room/'.$room_id);
		echo form_hidden('order', 'RE.STATUS');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="60">Adultos</td>
    <td width="63">Niños</td>
    <td width="88">Pago</td>
  </tr>
 
 <?php 
 foreach ($reservations as $row)
 {
 ?>
  <tr>
    <td><?php echo anchor(base_url().'reservations/info_reservation/'.$row['ID_RESERVATION'],$row['CONFIRM_NUM']);?></td>
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
    <td><?php foreach ($guest as $row1)
		{
			if ($row1['ID_GUEST'] == $row['FK_ID_GUEST'])
			{
				echo $row1['LAST_NAME'].', '.$row1['NAME'];?><br /><?php
				echo $row1['TELEPHONE'];?><br /><?php
				echo $row1['EMAIL'];?><br /><br /><?php
			}
		}
		?>    </td>
    <td><?php echo lang($row['STATUS']);?></td>
    <td><?php echo $row['ADULTS'];?></td>
    <td><?php echo $row['CHILDREN'];?></td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
</table>



<p><a href="<?php echo base_url().'rooms/view_rooms/'?>">Volver</a></p>