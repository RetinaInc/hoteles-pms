
<?php 

$this->load->view('pms/header'); 

echo 'TARIFAS'."<br><br>";

echo anchor(base_url().'rates/addRate/','Agregar Nueva Tarifa')."<br><br>";
?>


<table width="570" border="1">
  <tr>
    <td width="125" height="45">NOMBRE</td>
    <td width="358">DESCRIPCIÓN</td>
    <td width="65">EDITAR</td>
  </tr>
	
<?php
foreach ($rates as $row) { 
?>    
  	<tr>
      <td height="46"><?php echo $row['name'];?></td> 
      <td><?php echo $row['description'];?></td>
      <td><?php echo anchor(base_url().'rates/editRate/'.$row['id_rate'],'Editar');?></td>
    </tr>
  
<?php
}
?>
</table>

