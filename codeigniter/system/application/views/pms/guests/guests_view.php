
<?php 
$this->load->view('pms/header'); 
?>

<h3>Clientes</h3>

<?php
$attributes = array('id' => 'form_search');
echo form_open('guests/searchGuests', $attributes);

$data = array(
       'name' => 'search',
       'id'   => 'search',
	   'size' => '30'
       );
echo form_input($data);

echo form_submit('sumit', 'Buscar Cliente');
echo form_close();

if ($guestsDis) {
	
	echo anchor('guests/viewDisableGuests/', 'Ver Clientes Deshabilitados');
	echo "<br><br>";
}

if ($guests) {
	?>
	<table width="688" border="1">
    
  	  <tr>
    	<td width="250">Nombre</td>
        
        <td width="130">Cédula</td>
        
        <td width="130">Teléfono</td>
        
        <td width="150">Correo</td>
      </tr>
	
 	  <?php 
  	  foreach ($guests as $row) {
	  ?>
      <tr>
        <td>
			<?php 
            echo anchor('guests/infoGuestReservations/'.$row['id_guest'].'/checkIn', $row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2']);
            ?>
        </td>
        
        <td>
			<?php 
            echo $row['idType'].'-'.$row['idNum'];
            ?>
        </td>
        
        <td>
			<?php 
            echo $row['telephone'];
            ?>
        </td>
        
        <td>
			<?php 
            echo $row['email'];
            ?>
        </td>
      </tr>
	  <?php
      }
      ?>
	</table>
 
 	<br />
 
	<?php

	echo $this->pagination->create_links();

} else {
	
	echo 'No existen clientes!';
}

?>
