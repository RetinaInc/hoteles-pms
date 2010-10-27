
<?php 
$this->load->view('pms/header'); 
?>

<script type="text/javascript">

	$(function(){
		
		<?php 
		if ($type == 'hasWeekdays') {
			?>
				$('#noWeekdays').hide();
				$('#hasWeekdays').show();
			<?php
		}
		else {
		?>
			$('#hasWeekdays').hide();
			$('#noWeekdays').show();

		<?php
		}
		?>
		
		$('#noWeekdays a').click(function(){
				$('#noWeekdays').hide();
				$('#hasWeekdays').show();
		});
		
		$('#hasWeekdays a').click(function(){
				$('#hasWeekdays').hide();
				$('#noWeekdays').show();
		});
	});

</script>

<h3>Editar Precios</h3>
(*)Campos Obligatorios
<br /><br />

<?php
if (isset($error)) {

	if ($error != 1) {
	
		echo "<span class='Estilo1'>".$error."</span><br><br>";
	}
}

foreach ($season as $row) {
	
	$seasonId   = $row['id_season'];
	$seasonName = $row['name'];
	$dateStart  = $row['dateStart'];
	$dateEnd    = $row['dateEnd'];
	
	$dS_array = explode ('-',$dateStart);
	$year     = $dS_array[0];
	$month    = $dS_array[1];
	$day      = $dS_array[2];
	$dateS    = $day.'-'.$month.'-'.$year;
	
	$dE_array = explode ('-',$dateEnd);
	$year     = $dE_array[0];
	$month    = $dE_array[1];
	$day      = $dE_array[2];
	$dateE    = $day.'-'.$month.'-'.$year;	
	
	echo $seasonName.' ('.$dateS.' al '.$dateE.') <br>';
}

foreach ($rate as $row) {
	
	$rateId = $row['id_rate'];
	echo 'Tarifa ', $row['name']."<br>";
}

foreach ($plan as $row) {
	
	$planId = $row['id_plan'];
	echo 'Plan ', $row['name']."<br>";
}
?>

<div id="noWeekdays">

	<?php
	$attributesPN = array('id' => 'perNight');
    echo form_open('prices/editPricesPerNight/'.$seasonId.'/'.$rateId.'/'.$planId, $attributesPN);
    ?>
    
    <br />
    Precio por noche:
    <br />
    
     <table width="303" border="1">
     
      <tr>
      
        <td width="163">Tipo de Hab</td>
        
        <td width="72">Precio</td>
        
        <td width="46">&nbsp;</td>
        
      </tr>
      
	  <?php 
      foreach ($roomTypes as $row) {
	  
		  $roomTypeId = $row['id_room_type'];
		  ?>
          
		  <tr>
          
			<td width="163">
				<?php 
                echo '* '.$row['name']; 
                ?>
			</td>
			
			<?php 
			foreach ($prices as $row1) {
			
				if ($row1['fk_room_type'] == $row['id_room_type']) {
				
					$pricePerNight = $row1['pricePerNight'];
				}
			}
			?>
			
			<td>
                <input name="pricepn<?php echo $roomTypeId?>" type="text" id="pricepn<?php echo $roomTypeId?>" onKeyPress="return pricenumbers(this, event)" 
                value="<?php 
                        if ($pricePerNight == NULL) {
                            echo set_value('pricepn'.$roomTypeId);
                        } else {
                            echo $pricePerNight; 
                        }
                        ?>" 
                size="12" maxlength="12"/>  
			</td>
			
			<td>Bs.F.</td>
			
	  	</tr>
      <?php
      } 
      ?>
      
      <tr>
		<td width="163"><strong>* Niños</strong></td>
        
		<?php
        foreach ($prices as $row) {
        	if ($row['persType'] == 'Children') {
            	$priceChildren = $row['pricePerNight'];
             }
 		}
    	?>
        
        <td width="72">
            <input name="pricepn_children" type="text" id="pricepn_children" onKeyPress="return pricenumbers(this, event)" 
            value="<?php 
                if ($priceChildren == NULL) {
                    echo set_value('pricepn_children');
                } else {
                    echo $priceChildren; 
                }
                ?>" 
            size="12" maxlength="12"/>
       	</td>
        
		<td width="46">Bs.F.</td>
        
      </tr>
        
    </table>
    
    <br />
    <a href="#">Agregar precios según día</a>
    <br /><br />
    
    <?php
    $att = array(
        'name'        => 'submit',
        'id'          => 'submit',
        'onClick'     => "return confirm('Seguro que desea guardar?')"
    );
    echo form_submit($att, 'Guardar');
    echo form_close();
    ?>
    
</div>


<div id="hasWeekdays">

	<?php
    $attributesED = array('id' => 'eachDay');
    echo form_open('prices/editPricesEachDay/'.$seasonId.'/'.$rateId.'/'.$planId, $attributesED);
    ?> 
    
    <br />
    Precio por noche según el día:
    <br />
    
    <table width="926" border="1">
      <tr>
      
        <td width="256">&nbsp;</td>
        
        <td width="87">Lunes</td>
        
        <td width="78">Martes</td>
        
        <td width="72">Miércoles</td>
        
        <td width="72">Jueves</td>
        
        <td width="72">Viernes</td>
        
        <td width="72">Sábado</td>
        
        <td width="72">Domingo</td>
        
        <td width="87">&nbsp;</td>
        
      </tr>
      
	  <?php 
      foreach ($roomTypes as $row) {
	  
	  	$roomTypeId = $row['id_room_type'];
      	?>
        
      	<tr>
			<td>
				<?php 
                echo '* '.$row['name']; 
                ?>
        	</td>
        
			<?php
            foreach ($prices as $row1) {
			
                if ($row1['fk_room_type'] == $row['id_room_type']) {
				
                    $monPrice = $row1['monPrice'];
                    $tuePrice = $row1['tuePrice'];
                    $wedPrice = $row1['wedPrice'];
                    $thuPrice = $row1['thuPrice'];
                    $friPrice = $row1['friPrice'];
                    $satPrice = $row1['satPrice'];
                    $sunPrice = $row1['sunPrice'];
                }
            }
            ?>
        
            <td>
                <input name="mon_price<?php echo $roomTypeId?>" type="text" id="mon_price<?php echo $roomTypeId?>" onKeyPress="return pricenumbers(this, event)" 
                value="<?php 
                        if ($monPrice == NULL) {
                            echo set_value('mon_price'.$roomTypeId);
                        } else {
                            echo $monPrice; 
                        }
                    ?>" 
                size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="tue_price<?php echo $roomTypeId?>" type="text" id="tue_price<?php echo $roomTypeId?>" onKeyPress="return pricenumbers(this, event)" 
                value="<?php 
                        if ($tuePrice == NULL) {
                            echo set_value('tue_price'.$roomTypeId);
                        } else {
                            echo $tuePrice; 
                        }			
                        ?>" 
                size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="wed_price<?php echo $roomTypeId?>" type="text" id="wed_price<?php echo $roomTypeId?>" onKeyPress="return pricenumbers(this, event)" 
                value="<?php 
                        if ($wedPrice == NULL) {
                            echo set_value('wed_price'.$roomTypeId);
                        } else {
                            echo $wedPrice; 
                        } 
                        ?>" 
                size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="thu_price<?php echo $roomTypeId?>" type="text" id="thu_price<?php echo $roomTypeId?>" onKeyPress="return pricenumbers(this, event)" 
                value="<?php 
                        if ($thuPrice == NULL) {
                            echo set_value('thu_price'.$roomTypeId);
                        } else {
                            echo $thuPrice; 
                        }
                        ?>" 
                size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="fri_price<?php echo $roomTypeId?>" type="text" id="fri_price<?php echo $roomTypeId?>" onKeyPress="return pricenumbers(this, event)" 
                value="<?php 
                        if ($friPrice == NULL) {
                            echo set_value('fri_price'.$roomTypeId);
                        } else {
                            echo $friPrice; 
                        }
                        ?>" 
                size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="sat_price<?php echo $roomTypeId?>" type="text" id="sat_price<?php echo $roomTypeId?>" onKeyPress="return pricenumbers(this, event)" 
                value="<?php 
                        if ($satPrice == NULL) {
                            echo set_value('sat_price'.$roomTypeId);
                        } else {
                            echo $satPrice; 
                        } 
                        ?>" 
                size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="sun_price<?php echo $roomTypeId?>" type="text" id="sun_price<?php echo $roomTypeId?>" onKeyPress="return pricenumbers(this, event)" 
                value="<?php 
                        if ($sunPrice == NULL) {
                            echo set_value('sun_price'.$roomTypeId);
                        } else {
                            echo $sunPrice; 
                        }
                        ?>" 
                size="12" maxlength="12"/>
            </td>
            
            <td>Bs.F.</td>
        
	  	</tr>
	  <?php
	  }
    
	  foreach ($prices as $row) {
	  
	  	if ($row['persType'] == 'Children') {
		
			$monPriceC = $row['monPrice'];
			$tuePriceC = $row['tuePrice'];
			$wedPriceC = $row['wedPrice'];
			$thuPriceC = $row['thuPrice'];
			$friPriceC = $row['friPrice'];
			$satPriceC = $row['satPrice'];
			$sunPriceC = $row['sunPrice'];
	  	}
	  }
	  ?>
      
	  <tr>
      
		<td><strong>* Niños</strong></td>
        
        <td>
            <input name="mon_price_children" type="text" id="mon_price_children" onKeyPress="return pricenumbers(this, event)" 
            value="<?php 
                    if ($monPriceC == NULL) {
                        echo set_value('mon_price_children');
                    } else {
                        echo $monPriceC; 
                    }
                    ?>" 
            size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="tue_price_children" type="text" id="tue_price_children" onKeyPress="return pricenumbers(this, event)" 
            value="<?php 
                    if ($tuePriceC == NULL) {
                        echo set_value('tue_price_children');
                    } else {
                        echo $tuePriceC; 
                    }
                    ?>" 
            size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="wed_price_children" type="text" id="wed_price_children" onKeyPress="return pricenumbers(this, event)" 
            value="<?php 
                    if ($wedPriceC == NULL) {
                        echo set_value('wed_price_children');
                    } else {
                        echo $wedPriceC; 
                    }
                    ?>" 
            size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="thu_price_children" type="text" id="thu_price_children" onKeyPress="return pricenumbers(this, event)" 
            value="<?php 
                    if ($thuPriceC == NULL) {
                        echo set_value('thu_price_children');
                    } else {
                        echo $thuPriceC; 
                    }
                    ?>" 
            size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="fri_price_children" type="text" id="fri_price_children" onKeyPress="return pricenumbers(this, event)" 
            value="<?php 
                    if ($friPriceC == NULL) {
                        echo set_value('fri_price_children');
                    } else {
                        echo $friPriceC; 
                    }
                    ?>" 
            size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="sat_price_children" type="text" id="sat_price_children" onKeyPress="return pricenumbers(this, event)" 
            value="<?php 
                    if ($satPriceC == NULL) {
                        echo set_value('sat_price_children');
                    } else {
                        echo $satPriceC; 
                    } 
                    ?>" 
            size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="sun_price_children" type="text" id="sun_price_children" onKeyPress="return pricenumbers(this, event)" 
            value="<?php 
                    if ($sunPriceC == NULL) {
                        echo set_value('sun_price_children');
                    } else {
                        echo $sunPriceC; 
                    }
                    ?>" 
            size="12" maxlength="12"/>
        </td>
        
        <td>Bs.F.</td>
        
      </tr>
	  
    </table>
    
    <br />
    <a href="#">Agregar único precio por noche</a>
    <br /><br />
    
    <?php
    $att = array(
        'name'        => 'submit',
        'id'          => 'submit',
        'onClick'     => "return confirm('Seguro que desea guardar?')"
    );
    echo form_submit($att, 'Guardar');
    echo form_close();
    ?>
    
</div>

<?php
echo anchor('prices/checkPrices/'.$seasonId.'/'.$rateId.'/'.$planId, 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));
?>
