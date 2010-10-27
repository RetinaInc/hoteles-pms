
<?php 
$this->load->view('pms/header'); 
?>

<h3>Usuarios Deshabilitados</h3>

<table width="492" border="1">

  <tr>
    <td width="250">Nombre</td>
    
    <td width="150">Rol</td>
    
    <td width="70">Habilitar</td>
  </tr>
	
  <?php 
  foreach ($usersDis as $row) {
  ?>
  <tr>
  
    <td>
    	<?php 
            echo anchor('users/infoUser/'.$row['id_user'], $row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2']);
        ?>
    </td>
    
    <td>
		<?php 
        echo lang($row['role']);
        ?>
    </td>
   
    <td>
		<?php 
		echo anchor('users/enableUser/'.$row['id_user'], 'Habilitar', array('onClick' => "return confirm('Seguro que desea habilitar?')"));  
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
echo anchor('users/viewUsers/', 'Volver a Usuarios');
?>
