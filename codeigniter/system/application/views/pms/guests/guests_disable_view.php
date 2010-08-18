
<?php 

$this->load->view('pms/header'); 

echo 'CLIENTES DESHABILITADOS'."<br><br>";

?>

<table width="911" border="1">

  <tr>
    <td width="132">Nombre</td>
    <td width="142">Teléfono</td>
    <td width="150">Correo</td>
    <td width="229">Dirección</td>
    <td width="131">Ver Reservaciones</td>
    <td width="87">Habilitar</td>
  </tr>
	
  <?php 
  foreach ($guests as $row) {?>
  <tr>
    <td><?php echo $row['lastName'].', '.$row['name'];?></td>
    <td><?php echo $row['telephone'];?></td>
    <td><?php echo $row['email'];?></td>
    <td><?php echo $row['address'];?></td>
    <td><?php echo anchor(base_url().'guests/infoGuestReservations/'.$row['id_guest'],'Ver Reservaciones');?></td>
    <td><a href="<?php echo base_url().'guests/enableGuest/'.$row['id_guest'] ?>" onclick="return confirm('Seguro que desea habilitar?')">  Habilitar</a></td>
  </tr>
  <?php
  }
  ?>

</table>

<p><a href="<?php echo base_url().'guests/viewGuests/'?>">Volver a Clientes</a></p>

