
<?php 

$this->load->view('header'); 

echo 'CLIENTES';

?>
<br /><br />

<table width="911" border="1">

  <tr>
    <td width="132">Nombre</td>
    <td width="142">Teléfono</td>
    <td width="150">Correo</td>
    <td width="229">Dirección</td>
    <td width="131">Ver Reservaciones</td>
    <td width="87">Editar</td>
  </tr>
	
  <?php foreach ($guests as $row)
  {?>
  <tr>
    <td><?php echo $row['LAST_NAME'].', '.$row['NAME'];?></td>
    <td><?php echo $row['TELEPHONE'];?></td>
    <td><?php echo $row['EMAIL'];?></td>
    <td><?php echo $row['ADDRESS'];?></td>
    <td><?php echo anchor(base_url().'guests/info_guest_reservations/'.$row['ID_GUEST'],'Ver Reservaciones');?></td>
    <td><?php echo anchor(base_url().'guests/edit_guest/'.$row['ID_GUEST'],'Editar');?></td>
  </tr>
  <?php
  }
  ?>

</table>

