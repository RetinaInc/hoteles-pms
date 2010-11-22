
<?php 
$this->load->view('pms/header');
		
if ($month == '01') {
	
	$monthSt = 'Enero';
}

if ($month == '02') {
	
	$monthSt = 'Febrero';
}

if ($month == '03') {
	
	$monthSt = 'Marzo';
}

if ($month == '04') {
	
	$monthSt = 'Abril';
}

if ($month == '05') {
	
	$monthSt = 'Mayo';
}

if ($month == '06') {
	
	$monthSt = 'Junio';
}

if ($month == '07') {
	
	$monthSt = 'Julio';
}

if ($month == '08') {
	
	$monthSt = 'Agosto';
}

if ($month == '09') {
	
	$monthSt = 'Septiembre';
}

if ($month == '10') {
	
	$monthSt = 'Octubre';
}

if ($month == '11') {
	
	$monthSt = 'Noviembre';
}

if ($month == '12') {
	
	$monthSt = 'Diciembre';
}
?>

<h3>Reporte mensual por habitación</h3>

<h4>Reservaciones

<?php
echo $monthSt.' '.$year."</h4>";
?>
 
<span class="Estilo1">
    <?php
    echo validation_errors();
    ?>
</span>
 
<?php
echo form_open('reports/monthlyRoomsReport');
?>

<br />

Mes: 
<?php
$options = array(	
		'01' => 'Enero',
		'02' => 'Febrero',
		'03' => 'Marzo',
		'04' => 'Abril',
		'05' => 'Mayo',
		'06' => 'Junio',
		'07' => 'Julio',
		'08' => 'Agosto',
		'09' => 'Septiembre',
		'10' => 'Octubre',
		'11' => 'Noviembre',
		'12' => 'Diciembre'
		);

$js = 'id="report_month"';
echo form_dropdown('report_month', $options, $month, $js);
?>

Año: 
<input name="report_year" id="report_year" type="text" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)"/>

<?php
echo form_submit('submit', 'Consultar');
echo form_close();
?>

<br />

<table width="386" border="1">
    
  <tr>
    <td width="100">Habitación</td>
    <td width="130">Reservaciones</td>
    <td width="134">Total (Bs.F.)</td>
  </tr>
  
  <?php
  
  $totalRR      = 0;
  $totalRevenue = 0;
  
  foreach ($rooms as $row) {
  	
	$hotel = $this->session->userdata('hotelid');
	
	$RR      = getRoomResReport($hotel, 'RO.id_room', $row['id_room'], 'RE.status !=', 'Canceled', 'RE.status !=', 'No Show', $month, $year);
	$countRR = count($RR);
	
	$roomTotal = 0;
	
	foreach ($RR as $row1) {
		
		$roomTotal = $row1['total'];
	}
  	?>
    
  	<tr>
   
        <td width="100">
            <?php
            echo $row['number'];
            ?> 	
        </td>
        
        <td width="130">
        	<?php
            echo $countRR;
            ?> 
        </td>
        
        <td width="134">
        	<?php
            echo $roomTotal;
            ?>
		</td>
        
  	</tr>
    
  	<?php
	$totalRR      = $totalRR      + $countRR;
	$totalRevenue = $totalRevenue + $roomTotal;
  }
  ?>
  
  <tr>
    <td width="100"><strong>TOTAL</strong></td>
    
    <td width="130">
		<?php
        echo "<strong>".$totalRR."</strong>";
        ?>
    </td>
    
    <td width="134">
    	<?php
        echo "<strong>".$totalRevenue.' Bs.F.'."</strong>";
        ?>
   	</td>
  </tr>
</table>

<br />

<?php
echo $this->pagination->create_links();

echo "<br><br>";

echo anchor('reports/selectReport', 'Volver a reportes');
?>