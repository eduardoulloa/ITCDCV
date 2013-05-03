<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('nomina')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->nomina), array('view', 'id'=>$data->nomina)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apellido_paterno')); ?>:</b>
	<?php echo CHtml::encode($data->apellido_paterno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apellido_materno')); ?>:</b>
	<?php echo CHtml::encode($data->apellido_materno); ?>
	<br />

	<?php
	
	// Valida si el usuario actual es un administrador general. En este caso,
	// se despliega la contraseña del empleado.
	if (Yii::app()->user->rol == 'Admin'){
		echo "<b>Contraseña: </b>";
		echo CHtml::encode($data->password);
		echo "<br />";
	}
	?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('puesto')); ?>:</b>
	<?php echo CHtml::encode($data->puesto); ?>
	<br />
	
    <?php 
	
	// Valida si no se recibió el arreglo con las carreras en las que
	// labora el empleado.
	if(!isset($carreras)) {
	
		// Almacena las carreras en las que labora el empleado, en
		// base a su nombre de usuario.
        $carreras = $this->getEmpleadoCarreras($data->nomina);

    } ?>

	    <b><?php echo CHtml::encode("Carreras"); ?>:</b>
        <?php 
		
		// Despliega las siglas de cada carrera en la que
		// labora el empleado.
		foreach($carreras as $carr){
            echo CHtml::encode($carr)." ";
        }?>
	<br />

	<?php 
	// Despliega una liga para editar los datos del empleado.
	echo CHtml::link('Editar', array('update', 'id'=>$data->nomina)); ?>
	<br />

</div>