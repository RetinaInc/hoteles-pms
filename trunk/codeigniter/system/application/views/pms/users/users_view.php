
<?php 
$this->load->view('pms/header'); 
?>

<h3>Usuarios</h3>

<?php

if ($usersDis) {
	
	echo anchor('users/viewDisabledUsers/', 'Ver Usuarios Deshabilitados');
	echo "<br>";
}

$userRole = $this->session->userdata('userrole');

if ($userRole == 'Master') {

	echo anchor('users/addUser/', 'Crear Nuevo Usuario');
	echo "<br>";
}

if ($users) {
	?>
    <br />
	<table width="466" border="1">
    
  	  <tr>
    	<td width="300">Nombre</td>
        
        <td width="150">Rol</td>
      </tr>
	
 	  <?php 
  	  foreach ($users as $row) {
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
      </tr>
	  <?php
      }
      ?>
	</table>
 
<br />
 
	<?php

	echo $this->pagination->create_links();

} else {
	
	echo 'No existen usuarios!';
}

?>
