
<?php 
$this->load->view('pms/header'); 
?>

<h3>Clientes</h3>

<?php
if ($guests) {
	?>
	<table width="911" border="1">
  	  <tr>
    	<td width="132">Nombre</td>
        <td width="142">Teléfono</td>
        <td width="150">Correo</td>
        <td width="229">Dirección</td>
        <td width="131">Ver Reservaciones</td>
        <td width="87">Editar</td>
      </tr>
	
 	  <?php 
  	  foreach ($guests as $row) {?>
      <tr>
        <td><?php echo $row['lastName'].', '.$row['name'];?></td>
        <td><?php echo $row['telephone'];?></td>
        <td><?php echo $row['email'];?></td>
        <td><?php echo $row['address'];?></td>
        <td><?php echo anchor(base_url().'guests/infoGuestReservations/'.$row['id_guest'],'Ver Reservaciones');?></td>
        <td><?php echo anchor(base_url().'guests/editGuest/'.$row['id_guest'],'Editar');?></td>
      </tr>
	  <?php
      }
      ?>
</table>

<p><a href="<?php echo base_url().'guests/viewDisableGuests/'?>">Ver Clientes Deshabilitados</a></p>
 
<?php
} else {
	
	echo 'No existen clientes!';
}
?>
