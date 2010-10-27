
<?php 
$this->load->view('pms/header'); 
?>

<h3>Clientes Deshabilitados</h3>

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
?>

<table width="774" border="1">

  <tr>
  
    <td width="250">Nombre</td>
    
    <td width="130">Cédula</td>
     
    <td width="130">Teléfono</td>
    
    <td width="150">Correo</td>
    
    <td width="80">Habilitar</td>
    
  </tr>
	
  <?php 
  foreach ($guestsDis as $row) {
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
    
    <td>
		<?php 
		echo anchor('guests/enableGuest/'.$row['id_guest'], 'Habilitar', array('onClick' => "return confirm('Seguro que desea habilitar?')"));  
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

echo "<br><br>";
echo anchor('guests/viewGuests/', 'Volver a Clientes');
?>
