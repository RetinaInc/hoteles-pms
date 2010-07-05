
<?php 

$this->load->view('header');

echo anchor(base_url().'reservations/add_reservation/','Crear Nueva Reservación');?><br /><br /><?php

echo 'RESERVACIONES';

?>
<br /><br />

<table width="1057" border="1">

  <tr>
    <td width="101">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'reservations/view_reservations');
		echo form_hidden('order', 'RE.ID_RESERVATION');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="94">
   	<?php
		echo '# Habitación';
        echo form_open(base_url().'reservations/view_reservations');
		echo form_hidden('order', 'RO.NUMBER');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
  <td width="101">
    	<?php
		echo 'Tipo habitación';
        echo form_open(base_url().'reservations/view_reservations');
		echo form_hidden('order', 'RT.ABRV');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
<td width="205">
        <?php
		echo 'Nombre Cliente ';
        echo form_open(base_url().'reservations/view_reservations');
		echo form_hidden('order', 'G.LAST_NAME');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
<td width="114">
    	<?php
		echo 'Fecha Check-In';
        echo form_open(base_url().'reservations/view_reservations');
		echo form_hidden('order', 'RE.CHECK_IN DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
  <td width="114">
    	<?php
		echo 'Fecha Check-Out';
        echo form_open(base_url().'reservations/view_reservations');
		echo form_hidden('order', 'RE.CHECK_OUT DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
<td width="163">
    	<?php
		echo 'Estado';
        echo form_open(base_url().'reservations/view_reservations');
		echo form_hidden('order', 'RE.STATUS');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="54">Pago</td>
    <td width="53">Debe</td>
  </tr>
	
  <?php foreach ($reservations as $row)
  {?>
  <tr>
    <td><?php echo anchor(base_url().'reservations/info_reservation/'.$row['ID_RESERVATION'],$row['ID_RESERVATION']);?></td>
    <td><?php echo $row['NUMBER'];?></td>
    <td><?php echo $row['ABRV'];?></td>
    <td><?php echo $row['LAST_NAME'].', '.$row['NAME'];?></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>

</table>

