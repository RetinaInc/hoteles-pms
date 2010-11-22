 
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
	});

</script>


<h3>Precios</h3>

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
	echo 'Plan ', $row['name']."<br><br>";
}
?>

<div id="noWeekdays">

    <strong>Precio por noche:</strong>
    <br /><br />
    
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
                echo $row['name']; 
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
				<?php 
                echo $pricePerNight; 
                ?>
            </td>
            
            <td>Bs.F.</td>
        </tr>
        
        <?php
        }
        
        foreach ($prices as $row) {
		
            if ($row['persType'] == 'Children') {
			
                $priceChildren = $row['pricePerNight'];
            }
        }
        ?>
        
        <tr>
            <td width="163"><strong>Niños</strong></td>
            
            <td width="72">
				<?php 
                if ($priceChildren == NULL) {
                    echo '--';
                } else {
                    echo $priceChildren; 
                }
                ?>
            </td>
            
            <td width="46">Bs.F.</td>
        </tr>		
        
    </table>
</div>


<div id="hasWeekdays">

   <strong>Precio por noche según el día:</strong>
    <br /><br />
    
	<table width="861" border="1">
   	  <tr>
   		<td width="125">&nbsp;</td>
        
        <td width="88">Lunes</td>
        
        <td width="89">Martes</td>
        
        <td width="92">Miércoles</td>
        
        <td width="88">Jueves</td>
        
        <td width="90">Viernes</td>
        
        <td width="90">Sábado</td>
        
        <td width="91">Domingo</td>
        
        <td width="50">&nbsp;</td>
      </tr>
      
  	  <?php 
  	  foreach ($roomTypes as $row) {
	  
      	  $roomTypeId = $row['id_room_type'];
    	  ?>
          <tr>
            <td>
				<?php 
                echo $row['name']; 
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
				<?php 
                echo $monPrice; 
                ?>
            </td>
            
            <td>
				<?php 
                echo $tuePrice; 
                ?>
            </td>
            
            <td>
				<?php 
                echo $wedPrice; 
                ?>
            </td>
            
            <td>
				<?php 
                echo $thuPrice; 
                ?>
            </td>
            
            <td>
				<?php 
                echo $friPrice; 
                ?>
            </td>
            
            <td>
				<?php 
                echo $satPrice; 
                ?>
            </td>
            
            <td>
				<?php 
                echo $sunPrice; 
                ?>
            </td>
            
            <td>Bs.F.</td>
	  	</tr>
	  <?php
	  }
      ?>
      
	  <tr>
		<td><strong>Niños</strong></td>
        
        <?php
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
        
        <td>
			<?php 
            if ($monPriceC == NULL) {
                echo '--';
            } else {
                echo $monPriceC; 
            }
            ?>
        </td>
        
        <td>
			<?php 
            if ($tuePriceC == NULL) {
                echo '--';
            } else {
                echo $tuePriceC; 
            }
            ?>
        </td>
        
        <td>
			<?php 
            if ($wedPriceC == NULL) {
                echo '--';
            } else {
                echo $wedPriceC; 
            }
            ?>
        </td>
        
        <td>
			<?php 
            if ($thuPriceC == NULL) {
                echo '--';
            } else {
                echo $thuPriceC; 
            }
            ?>
        </td>
        
        <td>
			<?php 
            if ($friPriceC == NULL) {
                echo '--';
            } else {
                echo $friPriceC; 
            }
            ?>
        </td>
        
        <td>
			<?php 
            if ($satPriceC == NULL) {
                echo '--';
            } else {
                echo $satPriceC; 
            }
            ?>
        </td>
        
        <td>
			<?php 
            if ($sunPriceC == NULL) {
                echo '--';
            } else {
                echo $sunPriceC; 
            }
            ?>
        </td>
        
        <td>Bs.F.</td>
      </tr>
  
    </table>
</div>

<br />

<?php
$userRole = $this->session->userdata('userrole');
				
if ($userRole != 'Employee') {

	echo anchor('prices/editPrices/'.$seasonId.'/'.$rateId.'/'.$planId, 'Editar Precios');
	echo "<br><br>";
}

echo anchor('prices/selectPlanPrices/'.$seasonId.'/'.$rateId, 'Volver');
?>

