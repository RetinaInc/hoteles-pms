
<?php
$this->load->view('pms/header'); 
?>

<h3>Disponibilidad</h3>

<?php
if (isset($error)) {

	echo "<span class='Estilo1'>".$error."</span>";
	echo "<br><br>";
}
?>

<table width="289" border="0">

  <tr>
    <td width="96">Tarifa</td>
    <td width="183">
		<?php 
		foreach ($rate as $row) {
		
			echo $row['name'];
		}
		?>
    </td>
  </tr>
  
  <tr>
    <td width="96">Plan</td>
    <td width="183">
    	<?php 
		foreach ($plan as $row) {
		
			echo $row['name'];
		}
		?>
	</td>
  </tr>
  
  <tr>
    <td width="96">Llegada</td>
    <td width="183">
		<?php 
        echo $checkIn; 
        ?>
    </td>
  </tr>
  
  <tr>
    <td>Salida</td>
    <td>
		<?php 
        echo $checkOut; 
        ?>
    </td>
  </tr>
  
   <tr>
    <td>Noches</td>
    <td>
		<?php 
        echo $nights; 
        ?>
    </td>
  </tr>
  
  <tr>
    <td>Habitaciones</td>
    <td>
		<?php 
        echo $roomCount.' ('.$totalP.' pers.) '; 
        ?>
    </td>
  </tr>
  
  <tr>
    <td>Total</td>
    <td>
		<?php 
        echo $totalPrice; 
        ?> 
        Bs.F.
    </td>
  </tr>
  
</table>

<br /><br />

<?php
echo anchor('reservations/createReservation1', 'Volver');
?>


