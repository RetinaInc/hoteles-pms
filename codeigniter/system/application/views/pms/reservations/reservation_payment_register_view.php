
<?php
$this->load->view('pms/header'); 
?>

<script type="text/javascript">

	$(function(){
		
		$('#check').hide();
		$('#transfer').hide();
		
		var payType = $('#payment_type').val();
		
		if (payType == 'check') {
			$('#check').show();
		}
			if (payType == 'transfer') {
			$('#transfer').show();
		}
			
		$('#payment_type').change(function(){
			
			var payType = $('#payment_type').val();
			
			if (payType == 'check') {
				$('#transfer').hide();
				$('#check').show();
			}
			if (payType == 'transfer') {
				$('#check').hide();
				$('#transfer').show();
			}
			if ((payType != 'transfer') && (payType != 'check')) {
				$('#check').hide();
				$('#transfer').hide();
			}
		});
		
	});
	
</script>

<h3>Registrar Pago</h3>

<?php 
foreach ($reservation as $row) {

	$reservationId = $row['id_reservation'];
	$status        = $row['status'];
	$totalFee      = $row['totalFee'];
	$guestId       = $row['fk_guest'];
	
	$checkIn  = $row['checkIn'];
	$checkOut = $row['checkOut'];
			
	$checkIn_array = explode (' ',$checkIn);
	$ciDate = $checkIn_array[0];
	
	$checkOut_array = explode (' ',$checkOut);
	$coDate = $checkOut_array[0];
			
	$nights = (strtotime($coDate) - strtotime($ciDate)) / (60 * 60 * 24);
	
	$unixCi = human_to_unix($row['checkIn']);
	$unixCo = human_to_unix($row['checkOut']);
	
	echo 'Reservaci�n # ', $reservationId."<br><br>";
	?>
    
	<table width="764" border="0">
    
	  <tr>
      	<td width="250">
			<?php 
        	foreach ($guest as $row1) {
			
            	if ($row1['id_guest'] == $guestId) {
				
                	echo 'Cliente: ', $row1['name'].' '.$row1['lastName'];		
                }
            }
            ?>
        </td>
        
		<td width="250">
			<?php 
            echo 'Tarifa ', $row['ratename']; 
            ?>
        </td>
        
		<td width="250">
			<?php 
            echo 'Llegada: ', date ("D  j/m/Y" , $unixCi); 
            ?>
        </td>
        
		<td width="250">
			<?php 
            echo 'Cant. noches: ', $nights; 
            ?>
        </td>
	  </tr>
      
	  <tr>
      	<td width="250">
			<?php 
            echo 'Estado: ', lang($row['status']); 
            ?>
        </td>
        
		<td>
			<?php 
            echo 'Plan ', $row['planname']; 
            ?>
        </td>
        
		<td>
			<?php 
            echo 'Salida: ', date ("D  j/m/Y" , $unixCo); 
            ?>
        </td>
        
		<td>
			<?php 
            echo 'Cant. habitaciones: ', $reservationRoomCount;
            ?>
        </td>
	  </tr>
      
	</table>
	
    <br />
	<?php
}

$total = 0;

if (($status == 'Canceled') || ($status == 'No Show')) {
		
		$total = $totalFee;
		
} else {

	foreach ($reservationRoomInfo as $row) {
	
		$total = $total + $row['total'];
	}
}

echo 'Total reservaci�n: ', $total.' Bs.F.'."<br>";

$paid = 0;

foreach ($payments as $row) {

	$paid = $paid + $row['amount'];
}

echo 'Total pagado: ', $paid.' Bs.F.'."<br>";

$amountToPay = $total - $paid;

echo 'Total por pagar: ', $amountToPay.' Bs.F.'."<br><br>";
?>

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php 
    echo validation_errors(); 
    ?>
</span>

<?php
if (isset($error)) {

	if ($error != 1) {
	
		echo "<br><br>";
		echo "<span class='Estilo1'>".$error."</span>";
	}
}

echo form_open('reservations/payReservation/'.$reservationId);
echo form_hidden('to_pay', $amountToPay);
?>

<table width="379" border="0">

  <tr>
    <td width="120" height="35">* Tipo</td>
    
    <td width="250">
    	<select name="pers_type" id="pers_type">
            <option value="N" <?php echo set_select('pers_type','N'); ?> >Natural</option>
            <option value="J" <?php echo set_select('pers_type','J'); ?> >Juridico</option>
    	</select>    
    </td>
  </tr>
  
  <tr>
    <td height="35">* Nombre</td>
    
    <td>
    	<input name="pers_name" type="text" id="pers_name" value="<?php echo set_value('pers_name'); ?>" size="30" maxlength="50" />
    </td>
  </tr>
  
  <tr>
    <td height="35">* CI /RIF</td>
    
    <td>
    	<input name="pers_id" type="text" id="pers_id" value="<?php echo set_value('pers_id'); ?>" size="30" maxlength="15" />
    </td>
  </tr>
  
</table>

<table width="380" border="0">

  <tr>
    <td width="120" height="35">* Monto pago: </td>
    
    <td width="250">
        <input name="payment_amount" type="text" id="payment_amount" value="<?php echo set_value('payment_amount'); ?>" size="30" maxlength="10" 
        onKeyPress="return pricenumbers(this, event)"/> Bs.F.
   	</td>
  </tr>
  
  <tr>
    <td height="35">* Tipo de pago: </td>
    
    <td>
    	<select name="payment_type" id="payment_type">
            <option value=" " selected>Seleccione</option>
            <option value="debit" <?php echo set_select('payment_type','debit'); ?> >D�bito</option>
            <option value="credit" <?php echo set_select('payment_type','credit'); ?> >Cr�dito</option>
            <option value="cash" <?php echo set_select('payment_type','cash'); ?> >Efectivo</option>
            <option value="transfer" <?php echo set_select('payment_type','transfer'); ?> >Transferencia</option>
            <option value="check" <?php echo set_select('payment_type','check'); ?> >Cheque</option>
    	</select> 
    </td>
  </tr>
  
</table>

<div id="check">
    <table width="379" border="0">
      <tr>
        <td width="120" height="35">* Banco</td>
        
        <td width="250">
        	<input name="payment_bank" type="text" id="payment_bank" value="<?php echo set_value('payment_bank'); ?>" size="30" maxlength="50" />
        </td>
      </tr>
      
      <tr>
        <td height="35">* Numero de Cheque</td>
        
        <td>
            <input name="check_num" type="text" id="check_num" value="<?php echo set_value('check_num'); ?>" size="30" maxlength="50" 
            onKeyPress="return numbersonly(this, event)"/>
        </td>
      </tr>
      
    </table>
</div>

<div id="transfer">
    <table width="380" border="0">
    
      <tr>
        <td width="120" height="35">* Numero de transferencia</td>
        
        <td width="250">
            <input name="transfer_num" type="text" id="transfer_num" value="<?php echo set_value('transfer_num'); ?>" size="30" maxlength="50" 
            onKeyPress="return numbersonly(this, event)"/>
        </td>
      </tr>
      
    </table>
</div>

<table>

  <tr>
    <td width="120" height="35">Detalles</td>
    
    <td width="250">
    	<textarea name="payment_details" cols="30" rows="2" id="payment_details"><?php echo set_value('payment_details'); ?></textarea>
    </td>
  </tr>
  
</table>

<br />

<?php 
$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('reservations/infoReservation/'.$reservationId.'/n/', 'Volver', array('onClick' => "return confirm('Seguro que desea volver? Se perder� la informaci�n')"));
?>
