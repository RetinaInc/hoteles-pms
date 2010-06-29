

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
	echo 'Número: ', $row['NUMBER'];?><br /><br /><?php
	
	if ($row['NAME'] != NULL)
	{
		echo 'Nombre: ', $row['NAME'];?><br /><br /><?php
	}
	
	echo 'Estado: ', lang($row['STATUS']);?><br /><br /><?php
	
	echo 'Tipo de habitación: ', $row['RTNAME'];?><br /><br /><?php
	
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



<table width="870" border="1">
  <tr>
    <td width="109"># Confirmación</td>
    <td width="120">Fecha Llegada</td>
    <td width="120">Fecha Salida</td>
    <td width="163">Nombre</td>
    <td width="104">Status</td>
    <td width="67">Adultos</td>
    <td width="61">Niños</td>
    <td width="92">Pago</td>
  </tr>
 
 <?php 
 foreach ($reservation as $row)
 {
 ?>
  <tr>
    <td><?php echo $row['CONFIRM_NUM'];?></td>
    <td>
	<?php 
		$check_in = $row['CHECK_IN'];
		$check_in_array = explode ('-',$check_in);
		$year = $check_in_array[0];
		$month = $check_in_array[1];
		$day = $check_in_array[2];
		echo $day.'-'.$month.'-'.$year;
	?>
    </td>
    <td>
	<?php 
		$check_out = $row['CHECK_OUT'];
		$check_out_array = explode ('-',$check_out);
		$year = $check_out_array[0];
		$month = $check_out_array[1];
		$day = $check_out_array[2];
		echo $day.'-'.$month.'-'.$year;
	?>
    </td>
    <td><?php foreach ($guest as $row1)
		{
			if ($row1['ID_GUEST'] == $row['FK_ID_GUEST'])
			{
				echo $row1['NAME'].' '.$row1['LAST_NAME'];?><br /><?php
				echo $row1['TELEPHONE'];?><br /><?php
				echo $row1['EMAIL'];?><br /><br /><?php
			}
		}
		?>    </td>
    <td><?php echo $row['STATUS'];?></td>
    <td><?php echo $row['ADULTS'];?></td>
    <td><?php echo $row['CHILDREN'];?></td>
    <td></td>
  </tr>
  <?php
  }
  ?>
</table>










<a href="<?php echo base_url().'rooms/view_rooms/'?>">Volver</a>