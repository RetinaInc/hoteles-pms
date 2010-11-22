
<?php 
$this->load->view('pms/header'); 
?>

<h3>Información Hotel</h3>

<?php
$sessionUserRole = $this->session->userdata('userrole');

foreach ($hotelInfo as $row) {

	$hotelId = $row['id_hotel'];
	$cityId  = $row['fk_place']; 
	
	foreach ($places as $row1) {
		
		if ($row1['id_place'] == $row['fk_place']) {
			
			$countryId = $row1['fk_place'];
		}
	}
	
	$city    = getInfo(null, 'PLACE', 'id_place', $cityId,    null, null, null, null);
	$country = getInfo(null, 'PLACE', 'id_place', $countryId, null, null, null, null);
	
	if ($sessionUserRole == 'Master') {
			
		if ($row['disable'] == 1) {
		
			echo anchor('hotels/editHotel/'.$row['id_hotel'],'Editar Información Hotel')."<br>";
			
			if ($hotelImages) {
			
				echo anchor('hotels/viewImagesHotel/'.$row['id_hotel'], 'Ver Imagenes')."<br>";
			}
			
			echo anchor('hotels/addHotelImage/'.$row['id_hotel'], 'Agregar Imagen')."<br>";
		} 
		
		echo anchor('hotels/cancelHotelAccount/'.$row['id_hotel'],'Cancelar Cuenta Hotel', array('onClick' => "return confirm('Seguro que desea cancelar la cuenta? Se eliminará toda la información del hotel')"))."<br><br>";
	}
	
	?>
	<table width="568" border="2">
	  <tr>
		<td width="150" height="45"><strong>Nombre</strong></td>
		<td width="400">
			<?php
			echo $row['name'];
			?>        </td>
	  </tr>
	  
	  <tr>
		<td height="45"><strong>Tipo</strong></td>
	  	<td>
			<?php
			echo $row['type']; 
			?>
		</td>
	  </tr>
	  
      <?php
	  if ($row['description'] != NULL) {
		  ?>
		  <tr>
			<td height="45"><strong>Descripción</strong></td>
			<td>
				<?php
				echo $row['description']; 
				?>
			</td>
		  </tr>
		  <?php
	  }
	  ?>
      
	  <tr>
		<td height="45"><strong>Dirección</strong></td>
	  	<td>
			<?php
			echo $row['address']."<br>";
			foreach ($city as $row1) {
				
				foreach ($country as $row2)
				
				echo $row1['name'].', '.$row2['name'];
			} 
			?>
		</td>
	  </tr>
	  
	  <?php
	  if ($row['refAddress'] != NULL) {
		  ?>
		  <tr>
			<td height="45"><strong>Referencias</strong></td>
			<td>
				<?php
				echo $row['refAddress']; 
				?>
			</td>
		  </tr>
		  <?php
	  }

	  if ($row['webPage'] != NULL) {
		  ?>
		  <tr>
			<td height="45"><strong>Página Web</strong></td>
			<td>
				<?php
				echo $row['webPage']; 
				?>
			</td>
		  </tr>
		  <?php
	  }
	  
	  if ($row['email'] != NULL) {
		  ?>
		  <tr>
			<td height="45"><strong>Correo electrónico</strong></td>
			<td>
				<?php
				echo $row['email']; 
				?>
			</td>
		  </tr>
		  <?php
	  }
	  
	  if ($telephones) {
	  	?>
         <tr>
			<td height="45"><strong>Teléfonos</strong></td>
			<td>
				<?php
				foreach ($telephones as $row1) {
	  				
					echo $row1['type'].': '.$row1['number']."<br>";
				}
				?>
			</td>
		  </tr>
          <?php
	  }
	  
	   if ($row['info'] != NULL) {
		  ?>
		  <tr>
			<td height="45"><strong>Información</strong></td>
			<td>
				<?php
				echo $row['info']; 
				?>
			</td>
		  </tr>
		  <?php
	  }
	  
	  if ($row['cancelHours'] != NULL) {
		  ?>
		  <tr>
			<td height="45"><strong>Política de cancelación</strong></td>
			<td>
				<?php
				echo 'Cancelar '.$row['cancelHours'].' horas antes para evitar recargo'; 
				?>
			</td>
		  </tr>
		  <?php
	  }
	  
	  if ($row['cancelFee'] != NULL) {
		  ?>
		  <tr>
			<td height="45"><strong>Recargo</strong></td>
			<td>
				<?php
				echo 'Recargo del '.$row['cancelFee'].'% por cancelación tardía o falta de presencia''; 
				?>
			</td>
		  </tr>
		  <?php
	  }
	  ?>
	</table>
<?php
}
?>


