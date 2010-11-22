
<?php 
$this->load->view('pms/header');
		
if ($month == '1') {
	
	$monthSt = 'Enero';
}

if ($month == '2') {
	
	$monthSt = 'Febrero';
}

if ($month == '3') {
	
	$monthSt = 'Marzo';
}

if ($month == '4') {
	
	$monthSt = 'Abril';
}

if ($month == '5') {
	
	$monthSt = 'Mayo';
}

if ($month == '6') {
	
	$monthSt = 'Junio';
}

if ($month == '7') {
	
	$monthSt = 'Julio';
}

if ($month == '8') {
	
	$monthSt = 'Agosto';
}

if ($month == '9') {
	
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

<h3>Reporte mensual</h3>

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
echo form_open('reports/monthlyReport');
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

$totalStays  = count($styReservations);
$totalCancel = count($canReservations);
$totalNoShow = count($noShowReservations);

$styTotal = 0;
$canTotal = 0;
$nShTotal = 0;

foreach ($resRR as $row) {
	
	$styTotal = $styTotal + $row['total'];
}

foreach ($canReservations as $row) {
	
	$canTotal = $canTotal + $row['totalFee'];
}

foreach ($noShowReservations as $row) {
	
	$nShTotal = $nShTotal + $row['totalFee'];
}

?>

<br />

<table width="282" border="1">

  <tr>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>Total (Bs.F.)</td>
  </tr>
  
  <tr>
    <td width="100" height="30">Estadías</td>
  	<td width="60">
		<?php
        echo $totalStays;
        ?>  	
   	</td>
    <td width="100">
    	<?php
        echo $styTotal;
        ?> 
    </td>
  </tr>
  
  <tr>
    <td height="30">Canceladas</td>
  	<td>
		<?php
		echo $totalCancel;
        ?>   	
   	</td>
    <td>
    	<?php
        echo $canTotal;
        ?> 
    </td>
  </tr>
  
  <tr>
    <td height="30">Olvidadas</td>
  	<td>
		<?php
        echo $totalNoShow;
        ?>  	
   	</td>
    <td>
    	<?php
        echo $nShTotal;
        ?> 
    </td>
  </tr>
  
  <tr>
    <td height="30"><strong>TOTAL</strong></td>
  	<td>
		<?php
		$totalRes = $totalStays + $totalCancel + $totalNoShow;
        echo "<strong>".$totalRes."</strong>";
        ?>  	
   	</td>
    <td>
    	<?php
		$totalRev = $styTotal + $canTotal + nShTotal;
        echo "<strong>".$totalRev.' Bs.F.'."</strong>";
        ?> 
    </td>
  </tr>
</table>

<br /><br />

<?php
echo anchor('reports/selectReport', 'Volver a reportes');
?>
