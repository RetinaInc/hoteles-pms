
<?php 
$this->load->view('pms/header');
?>

<h3>Reportes</h3>

<table width="400" border="0">

  <tr>
    <td width="394" height="40">
    	<?php
		echo anchor('reports/monthlyReport', 'Reporte mensual');
		?>  	</td>
  </tr>
  
  <tr>
    <td height="40">
    	<?php
		echo anchor('reports/monthlyRoomTypesReport', 'Reporte mensual por tipo de habitación');
		?>   	</td>
  </tr>
  
  <tr>
    <td height="40">
    	<?php
		echo anchor('reports/monthlyRoomsReport', 'Reporte mensual por habitación');
		?>   	</td>
  </tr>
</table>
