
<?php
$this->load->view('pms/header'); 
?>

<h3>Nueva Reservación - Información Cliente</h3>

<?php
foreach ($reservationRoomInfo as $row) {

	$unixCi   = human_to_unix($row['checkIn']);
	$unixCo   = human_to_unix($row['checkOut']);
	$checkIn  = date ("D  j/m/Y" , $unixCi);
	$checkOut = date ("D  j/m/Y" , $unixCo);
	break;
}

?>
<table width="482" border="0">
  <tr>
    <td width="62">Llegada:</td>
    
    <td width="159">
		<?php 
        echo $checkIn;
        ?>
    </td>
    
    <td width="87">Habitaciones: </td>
    
    <td width="156">
		<?php 
        echo $reservationRoomCount; 
        ?>
    </td>
  </tr>
  
  <?php
  $total = 0;
  foreach ($reservationRoomInfo as $row) {
  
  	  $total = $total + $row['total'];
  }
  ?>
  
  <tr>
    <td>Salida:</td>
    
    <td>
		<?php 
        echo $checkOut;
        ?>
    </td>
    
    <td>Total: </td>
    
    <td>
		<?php 
        echo $total; 
        ?> 
        Bs.F.
    </td>
  </tr>
</table>

<h4>Buscar Cliente Existente</h4>

<?php
$attributes = array('name' => 'search_guest', 'id' => 'search_guest');
echo form_open('guests/searchGuest/'.$reservationId, $attributes);
?>
ID Cliente: <input name="search_guest_id" type="text" id="search_guest_id" value="<?php echo set_value('search_guest_id'); ?>" size="10" maxlength="10" onKeyPress="return numbersonly(this, event)"/>
<?php
echo form_submit('submit', 'Buscar');
echo form_close();
?>

<span class="Estilo1">
    <?php
    echo validation_errors();
    ?>
</span>

<?php 
if (isset($error1)) {

	echo "<span class='Estilo1'>".$error1."</span>";
}

if (isset($error2)) {

	echo "<br><br>";
	echo "<span class='Estilo1'>".$error2."</span>";
}

if ($guest) {
	
	foreach ($guest as $row) {
		
		$guestId = $row['id_guest'];
	}
	
	$attributes = array('name' => 'guestReservation', 'id' => 'guestReservation');
	echo form_open('reservations/createGuestReservation3/'.$reservationId.'/'.$guestId, $attributes);
	
	foreach ($guest as $row) {
		
		echo "<br>";
		
		echo 'Nombre: ',   $row['name'].' '.$row['name2'].' '.$row['lastName'].' '.$row['lastName2']."<br>";
	
		if (($row['idNum'] != NULL) || ($row['idNum'] != 0)) {
		
			echo 'Id: ', $row['idType'].'-'.$row['idNum']."<br>";
		}
		
		echo 'Teléfono: ', $row['telephone']."<br>";
		
		if ($row['email'] != NULL) {
		
			echo 'Correo electrónico: ', $row['email']."<br>";
		}
		
		if ($row['address'] != NULL) {
		
			echo 'Dirección: ', $row['address']."<br>";
		}
	}
	
} else {

	$attributes = array('name' => 'reservation', 'id' => 'reservation');
	echo form_open('reservations/createReservation3/'.$reservationId, $attributes);

	?>
	
    <span class="Estilo2">
		<br /><br />
    	(*)Campos obligatorios
	</span>

	<table width="1136" border="0">
	
	  <tr>
		<td width="100" height="39">* ID</td>
	  
		<td width="270" id="ci">
            <select name="guest_id_type" id="guest_id_type">
              <option value="V" <?php echo set_select('guest_id_type', 'V', TRUE); ?> >V-</option>
              <option value="E" <?php echo set_select('guest_id_type', 'E'); ?> >E-</option>
              <option value="P" <?php echo set_select('guest_id_type', 'P'); ?> >P-</option>
            </select>
              <input name="guest_id_num" type="text" id="guest_id_num" value="<?php echo set_value('guest_id_num'); ?>" size="10" maxlength="10" onKeyPress="return numbersonly(this, event)"/>		
      	</td>
        
		<td width="100">&nbsp;</td>
		
		<td width="270">&nbsp;</td>
        
	    <td colspan="2">Información Corporación: </td>
      </tr>
	  
	  <tr>
		<td height="41">* Nombre</td>
		
		<td>
			<input name="guest_name" type="text" id="guest_name" value="<?php echo set_value('guest_name'); ?>" size="30" maxlength="30" />
      	</td>
        
		<td>Seg. Nombre</td>
		
		<td>
			<input name="guest_2name" type="text" id="guest_2name" value="<?php echo set_value('guest_2name'); ?>" size="30" maxlength="30" />
      	</td>
        
	    <td width="100">Rif: </td>
        
	    <td width="270">
        	<input name="guest_corp_rif" type="text" id="guest_corp_rif" value="<?php echo set_value('guest_corp_rif'); ?>" size="20" maxlength="20" />
      	</td>
	  </tr>
	  
	  <tr>
		<td height="39">* Apellido</td>
		
		<td>
			<input name="guest_last_name" type="text" id="guest_last_name" value="<?php echo set_value('guest_last_name'); ?>" size="30" maxlength="30" />
       	</td>
		
		<td>Seg. Apellido</td>
		
		<td>
			<input name="guest_2last_name" type="text" id="guest_2last_name" value="<?php echo set_value('guest_2last_name'); ?>" size="30" maxlength="30" />
       	</td>
        
	    <td>Nombre: </td>
        
	    <td>
        	<input name="guest_corp_name" type="text" id="guest_corp_name" value="<?php echo set_value('guest_corp_name'); ?>" size="30" maxlength="100" />
       	</td>
	  </tr>
	  
	  <tr>
		<td height="37">* Tel&eacute;fono</td>
		
		<td>
			<input name="guest_telephone" type="text" id="guest_telephone" value="<?php echo set_value('guest_telephone'); ?>" size="20" maxlength="20" 
			onKeyPress="return numbersonly(this, event)"/>
      	</td>
		
		<td>* Correo electr&oacute;nico</td>
		
		<td>
			<input name="guest_email" type="text" id="guest_email" value="<?php echo set_value('guest_email'); ?>" size="30" maxlength="50" />
       	</td>
        
	    <td>&nbsp;</td>
        
	    <td>&nbsp;</td>
	  </tr>
	  
	  <tr>
		<td height="40">Direcci&oacute;n</td>
        
		<td>
			<textarea name="guest_address" cols="25" rows="2" id="guest_address"><?php echo set_value('guest_address'); ?></textarea>
       	</td>
        
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	  </tr>
	</table>
	
<?php
}
?> 


<table>
  <tr>
    <td width="100" height="76">Detalles reservación:</td>
    <td width="270">
      <textarea name="reservation_details" cols="25" rows="2" id="reservation_details"><?php echo set_value('reservation_details');?></textarea>   	
   	</td>
    <td width="100">
    <?php
	if ($reservationRoomCount == 1) {
	
		foreach ($reservationRoomInfo as $row) {
			
			if (($row['children'] != 0) && ($row['children'] != NULL)) {
				
				echo 'Edad Niño(s): ';
			}
		}
	}
    ?>    </td>
    
    <td width="270">
        <?php
	if ($reservationRoomCount == 1) {
	
		foreach ($reservationRoomInfo as $row) {
			
			if (($row['children'] != 0) && ($row['children'] != NULL)) {
				
				for ($i=1; $i<=$row['children']; $i++) {
					?>
<select name="children_age<?php echo $row['number'].'_'.$i?>" id="children_age<?php echo $row['number'].'_'.$i?>">
						<option value="1"<?php echo set_select('children_age'.$row['number'].$i, '1'); ?> selected>1</option>
						<option value="2"<?php echo set_select('children_age'.$row['number'].$i, '2'); ?>>2</option>
						<option value="3"<?php echo set_select('children_age'.$row['number'].$i, '3'); ?>>3</option>
						<option value="4"<?php echo set_select('children_age'.$row['number'].$i, '4'); ?>>4</option>
						<option value="5"<?php echo set_select('children_age'.$row['number'].$i, '5'); ?>>5</option>
						<option value="6"<?php echo set_select('children_age'.$row['number'].$i, '6'); ?>>6</option>
						<option value="7"<?php echo set_select('children_age'.$row['number'].$i, '7'); ?>>7</option>
						<option value="8"<?php echo set_select('children_age'.$row['number'].$i, '8'); ?>>8</option>
						<option value="9"<?php echo set_select('children_age'.$row['number'].$i, '9'); ?>>9</option>
						<option value="10"<?php echo set_select('children_age'.$row['number'].$i, '10'); ?>>10</option>
						<option value="11"<?php echo set_select('children_age'.$row['number'].$i, '11'); ?>>11</option>
						<option value="12"<?php echo set_select('children_age'.$row['number'].$i, '12'); ?>>12</option>
						<option value="13"<?php echo set_select('children_age'.$row['number'].$i, '13'); ?>>13</option>
						<option value="14"<?php echo set_select('children_age'.$row['number'].$i, '14'); ?>>14</option>
						<option value="15"<?php echo set_select('children_age'.$row['number'].$i, '15'); ?>>15</option>
						<option value="16"<?php echo set_select('children_age'.$row['number'].$i, '16'); ?>>16</option>
						<option value="17"<?php echo set_select('children_age'.$row['number'].$i, '17'); ?>>17</option>
					</select>
					<?php
				}
			}
		}
	}
    ?>
    </td>
  </tr>
</table>

<?php 
if ($reservationRoomCount > 1) {
	
	echo "<br>";
	foreach ($reservationRoomInfo as $row) {
		
		$roomNum = $row['number'];
		?>
        
		<table width="311" border="0">
        
	  	  <tr>
    		<td colspan="4">CLIENTE HABITACIÓN 
				<?php 
                echo $row['number'].' - '.$row['abrv'];
                ?>
            </td>
   		  </tr>
          
          <tr>
    		<td width="106">* ID</td>
            
    		<td width="195">
    		  <select name="guest_id_type<?php echo $roomNum?>" id="guest_id_type<?php echo $roomNum?>">
                <option value="V"<?php echo set_select('guest_id_type'.$roomNum, 'V', TRUE); ?>>V-</option>
                <option value="E"<?php echo set_select('guest_id_type'.$roomNum, 'E'); ?>>E-</option>
                <option value="P"<?php echo set_select('guest_id_type'.$roomNum, 'P'); ?>>P-</option>
              </select>
              
              <input name="guest_id_num<?php echo $roomNum?>" type="text" id="guest_id_num<?php echo $roomNum?>" 
              onKeyPress="return numbersonly(this, event)" value="<?php echo set_value('guest_id_num'.$roomNum); ?>" size="8" maxlength="8" />
            </td>
          </tr>
          
  		  <tr>
    		<td width="106">* Nombres</td>
            
    		<td width="195">
                <input name="guest_name<?php echo $roomNum?>" type="text" id="guest_name<?php echo $roomNum?>" 
                value="<?php echo set_value('guest_name'.$roomNum);?>" size="30" maxlength="30" />
            </td>
  		  </tr>
          
           <tr>
    		<td width="106">* Apellidos</td>
            
    		<td width="195">
                <input name="guest_last_name<?php echo $roomNum?>" type="text" id="guest_last_name<?php echo $roomNum?>" 
                value="<?php echo set_value('guest_last_name'.$roomNum);?>" size="30" maxlength="30" />
            </td>
          </tr>
          
          <?php 
		  if (($row['children'] != 0) && ($row['children'] != NULL)) {
		  ?>
          
		  <tr>
            <td width="106">* Edad Niños</td>
            
   			<td width="195">
            <?php
			for ($i=1; $i<=$row['children']; $i++) {
				?>
                <select name="children_age<?php echo $row['number'].'_'.$i?>" id="children_age<?php echo $row['number'].'_'.$i?>">
                	<option value="1" <?php echo set_select('children_age'.$row['number'].$i, '1'); ?> selected>1</option>
                    <option value="2" <?php echo set_select('children_age'.$row['number'].$i, '2'); ?> >2</option>
                    <option value="3" <?php echo set_select('children_age'.$row['number'].$i, '3'); ?> >3</option>
                    <option value="4" <?php echo set_select('children_age'.$row['number'].$i, '4'); ?> >4</option>
                    <option value="5" <?php echo set_select('children_age'.$row['number'].$i, '5'); ?> >5</option>
                    <option value="6" <?php echo set_select('children_age'.$row['number'].$i, '6'); ?> >6</option>
                    <option value="7" <?php echo set_select('children_age'.$row['number'].$i, '7'); ?> >7</option>
                    <option value="8" <?php echo set_select('children_age'.$row['number'].$i, '8'); ?> >8</option>
                    <option value="9" <?php echo set_select('children_age'.$row['number'].$i, '9'); ?> >9</option>
                    <option value="10" <?php echo set_select('children_age'.$row['number'].$i, '10'); ?> >10</option>
                    <option value="11" <?php echo set_select('children_age'.$row['number'].$i, '11'); ?> >11</option>
                    <option value="12" <?php echo set_select('children_age'.$row['number'].$i, '12'); ?> >12</option>
                    <option value="13" <?php echo set_select('children_age'.$row['number'].$i, '13'); ?> >13</option>
                    <option value="14" <?php echo set_select('children_age'.$row['number'].$i, '14'); ?> >14</option>
                    <option value="15" <?php echo set_select('children_age'.$row['number'].$i, '15'); ?> >15</option>
                    <option value="16" <?php echo set_select('children_age'.$row['number'].$i, '16'); ?> >16</option>
                    <option value="17" <?php echo set_select('children_age'.$row['number'].$i, '17'); ?> >17</option>
                </select>
            	<?php
			}
			?>
            </td>
       	  </tr>
		  <?php
		  }
		  ?>
          
		</table>
        <br />
		<?php
	}
}

$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('reservations/deleteReservation/'.$reservationId, 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));
?>
