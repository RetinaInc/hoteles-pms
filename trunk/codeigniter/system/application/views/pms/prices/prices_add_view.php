
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
		} else {
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

<h3>Agregar Precios</h3>

<?php
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
    echo form_open('prices/addPricesPerNight/'.$seasonId.'/'.$rateId.'/'.$planId, $attributesPN);
    ?>
    
    <br />
    <strong>Precio por noche:</strong>
    <br />
   
	<span class="Estilo2">
		(*)Campos obligatorios
	</span>
    
    <br /><br />
    
    <?php
	if (isset($error)) {
		
		if ($error != 1) {
	
			echo "<span class='Estilo1'>".$error."</span>";
			echo "<br><br>";
		}
	}
	?>
	<table width="295" border="1">
      <tr>
        <td width="163">Tipo de Hab</td>
        
        <td width="72">Precio</td>
        
        <td width="38">&nbsp;</td>
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
            
            <td>
                <input name="pricepn<?php echo $roomTypeId?>" type="text" id="pricepn<?php echo $roomTypeId?>" 
                onKeyPress="return pricenumbers(this, event)" value="<?php echo set_value('pricepn'.$roomTypeId); ?>" size="12" maxlength="12"/>    	
            </td>
            
            <td>Bs.F.</td>
            
          </tr>
	  <?php
	  }
	  ?>
      
      <tr>
        <td width="163"><strong>* Niños</strong></td>
        
        <td width="72">
            <input name="pricepn_children" type="text" id="pricepn_children" 
            onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('pricepn_children'); ?>" size="12" maxlength="12"/>    
        </td>
        
        <td width="38">Bs.F.</td>
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
    echo form_open('prices/addPricesEachDay/'.$seasonId.'/'.$rateId.'/'.$planId, $attributesED);
    ?> 
    
    <br />
   	<strong>Precio por noche según el día:</strong>
    <br />
    
    <span class="Estilo2">
		(*)Campos obligatorios
	</span>
    
    <br /><br />
    
    <?php
	if ($error != 1) {
	
		echo "<span class='Estilo1'>".$error."</span>";
		echo "<br><br>";
	}
	?>
    
    <table width="929" border="1">
      <tr>
        <td width="150">&nbsp;</td>
        
        <td width="80">Lunes</td>
        
        <td width="80">Martes</td>
        
        <td width="80">Miércoles</td>
        
        <td width="80">Jueves</td>
        
        <td width="80">Viernes</td>
        
        <td width="80">Sábado</td>
        
        <td width="80">Domingo</td>
        
        <td width="50">&nbsp;</td>
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
            
            <td>
                <input name="mon_price<?php echo $roomTypeId?>" type="text" id="mon_price<?php echo $roomTypeId?>" 
                onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('mon_price'.$roomTypeId); ?>" size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="tue_price<?php echo $roomTypeId?>" type="text" id="tue_price<?php echo $roomTypeId?>" 
                onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('tue_price'.$roomTypeId); ?>" size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="wed_price<?php echo $roomTypeId?>" type="text" id="wed_price<?php echo $roomTypeId?>" 
                onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('wed_price'.$roomTypeId); ?>" size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="thu_price<?php echo $roomTypeId?>" type="text" id="thu_price<?php echo $roomTypeId?>" 
                onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('thu_price'.$roomTypeId); ?>" size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="fri_price<?php echo $roomTypeId?>" type="text" id="fri_price<?php echo $roomTypeId?>" 
                onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('fri_price'.$roomTypeId); ?>" size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="sat_price<?php echo $roomTypeId?>" type="text" id="sat_price<?php echo $roomTypeId?>" 
                onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('sat_price'.$roomTypeId); ?>" size="12" maxlength="12"/>
            </td>
            
            <td>
                <input name="sun_price<?php echo $roomTypeId?>" type="text" id="sun_price<?php echo $roomTypeId?>" 
                onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('sun_price'.$roomTypeId); ?>" size="12" maxlength="12"/>
            </td>
            
            <td>Bs.F.</td>
            
          </tr>
      <?php
      }
      ?>
      
      <tr>
      
        <td><strong>* Niños</strong></td>
        
        <td>
            <input name="mon_price_children" type="text" id="mon_price_children" 
            onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('mon_price_children'); ?>" size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="tue_price_children" type="text" id="tue_price_children" 
            onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('tue_price_children'); ?>" size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="wed_price_children" type="text" id="wed_price_children" 
            onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('wed_price_children'); ?>" size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="thu_price_children" type="text" id="thu_price_children" 
            onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('thu_price_children'); ?>" size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="fri_price_children" type="text" id="fri_price_children" 
            onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('fri_price_children'); ?>" size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="sat_price_children" type="text" id="sat_price_children" 
            onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('sat_price_children'); ?>" size="12" maxlength="12"/>
        </td>
        
        <td>
            <input name="sun_price_children" type="text" id="sun_price_children" onkeypress="return pricenumbers(this, event)" value="<?php echo set_value('sun_price_children'); ?>" size="12" maxlength="12"/>
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
echo anchor('prices/selectPlanPrices/'.$seasonId.'/'.$rateId, 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));
?>