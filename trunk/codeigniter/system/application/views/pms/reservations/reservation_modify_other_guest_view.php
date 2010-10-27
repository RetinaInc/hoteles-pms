
<?php
$this->load->view('pms/header');
?>

<h3>Modificar Cliente</h3>

<?php

foreach ($otherGuest as $row1) {
		
	$otherGuestId = $row1['id_other_guest'];
}

echo form_open('reservations/modifyRoomReservationOtherGuest/'.$reservationId.'/'.$otherGuestId);

foreach ($roomReservationInfo as $row) {
	
	foreach ($otherGuest as $row1) {
		
		if ($row['fk_room'] == $row1['fk_room']) {
			
			$otherGuestId = $row1['id_other_guest'];
			echo '<strong>Habitación: </strong>', $row['number'].' - '.$row['abrv']."<br><br>";
			
			?>
            
            <span class="Estilo2">
                (*)Campos obligatorios
            </span>
            
            <br /><br />
            
            <span class="Estilo1">
                <?php
                echo validation_errors();
                ?>
            </span>
            
            <table width="311" border="0">

              <tr>
                <td width="106">* ID:</td>
                
                <td width="195">
                	<?php
					$options = array(	
							'V' => 'V-',
							'E' => 'E-',
							'P' => 'P-'
							);
					
					$js = 'id="other_guest_id_type"';
					echo form_dropdown('other_guest_id_type', $options, $row1['idType'], $js);
					?>
                    
                  <input name="other_guest_id_num" type="text" id="other_guest_id_num" value="<?php echo $row1['idNum']; ?>" size="10" maxlength="10" onKeyPress="return numbersonly(this, event)"/>			
                </td>
              </tr>
              
              <tr>
                <td width="106">* Nombres:</td>
                
                <td width="195">
                    <input name="other_guest_names" type="text" id="other_guest_names" 
                    value="<?php echo $row1['name']; ?>" size="30" maxlength="30" />			
                </td>
              </tr>
              
               <tr>
                <td width="106">* Apellidos:</td>
                
                <td width="195">
                    <input name="other_guest_last_names" type="text" id="other_guest_last_names" 
                    value="<?php echo $row1['lastName'] ?>" size="30" maxlength="30" />			
                </td>
              </tr>
              
            </table>
            
            <br />
            
            <?php
		}
	}
}

$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('reservations/infoReservation/'.$reservationId.'/n/', 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));
?>