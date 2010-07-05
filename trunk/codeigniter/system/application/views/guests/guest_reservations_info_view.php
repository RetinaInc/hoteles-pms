
<?php 

$this->load->view('header'); 

echo 'INFO HUESPED'; ?><br /><br />

<?php
foreach ($guest as $row)
{
	$guest_id = $row['ID_GUEST'];
	
	echo 'Nombre: ', $row['NAME'].', '.$row['LAST_NAME'];?><br /><?php
	echo 'Teléfono: ', $row['TELEPHONE'];?><br /><?php
	
	if ($row['EMAIL'] != NULL)
	{
		echo 'Correo electrónico: ', $row['EMAIL'];?><br /><?php
	}
	
	if ($row['ADDRESS'] != NULL)
	{
		echo 'Dirección: ', $row['ADDRESS'];?><br /><br /><?php
	}
}
?>



<table width="870" border="1">
  <tr>
    <td width="109">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'guests/info_guest_reservations/'.$guest_id);
		echo form_hidden('order', 'CONFIRM_NUM');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="120">
    	<?php
		echo 'Fecha Check-In';
        echo form_open(base_url().'guests/info_guest_reservations/'.$guest_id);
		echo form_hidden('order', 'CHECK_IN DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="120">
   	 	<?php
		echo 'Fecha Check-Out';
        echo form_open(base_url().'guests/info_guest_reservations/'.$guest_id);
		echo form_hidden('order', 'CHECK_OUT DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="104">
   	 	<?php
		echo 'Estado';
        echo form_open(base_url().'guests/info_guest_reservations/'.$guest_id);
		echo form_hidden('order', 'STATUS');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="67">Adultos</td>
    <td width="61">Niños</td>
    <td width="92">Pago</td>
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
	?>    </td>
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
	?>    </td>
    <td><?php echo $row['STATUS'];?></td>
    <td><?php echo $row['ADULTS'];?></td>
    <td><?php 
		if ($row['CHILDREN'] != NULL) 
		{
			echo $row['CHILDREN'];
		}
		else
		{
			?>&nbsp;<?php 
		}?>
    </td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
</table>

<p><a href="<?php echo base_url().'guests/view_guests/'?>">Volver</a></p>