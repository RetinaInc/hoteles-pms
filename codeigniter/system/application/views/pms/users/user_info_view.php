
<?php 
$this->load->view('pms/header'); 
?>

<h3>Información Usuario</h3>

<?php
$sessionUserRole = $this->session->userdata('userrole');
$sessionUserId   = $this->session->userdata('userid');

foreach ($user as $row) {

	$userId   = $row['id_user'];
	$userRole = $row['role'];
	
	if (($sessionUserRole != 'Employee') || ($sessionUserId == $userId)) {
		
		if ($row['disable'] == 1) {
		
			echo anchor('users/editUser/'.$row['id_user'],'Editar')."<br>";
			
			if (($sessionUserRole == 'Master') && ($userRole != 'Master')) {
			
				echo anchor('users/disableUser/'.$userId, 'Deshabilitar', array('onClick' => "return confirm('Seguro que desea deshabilitar?')"));  
				echo "<br>";
			}
			
		} else if ($row['disable'] == 0){
			
			 echo anchor('users/enableUser/'.$row['id_user'],'Habilitar', array('onClick' => "return confirm('Seguro que desea habilitar?')")); 
			 echo "<br>";
		}
	}
	
	echo "<br>";
	
	echo 'Nombre: ',   $row['name'].' '.$row['name2'].' '.$row['lastName'].' '.$row['lastName2']."<br>";
	
	echo 'Rol: ', lang($row['role'])."<br>";
	
	if (($row['idNum'] != NULL) || ($row['idNum'] != 0)) {
	
		echo 'Id: ', $row['idType'].' - '.$row['idNum']."<br>";
	}
	
	if ($telephones) {
	
		foreach ($telephones as $row1) {
			
			echo $row1['type'].': '.$row1['number']."<br>";
		}
	}
	
	if ($row['email'] != NULL) {
	
		echo 'Correo electrónico: ', $row['email']."<br>";
	}
	
	if ($row['address'] != NULL) {
	
		echo 'Dirección: ', $row['address']."<br>";
	}
}

echo $this->pagination->create_links();

echo "<br>";
echo anchor('users/viewUsers/', 'Volver a Usuarios');
?>







