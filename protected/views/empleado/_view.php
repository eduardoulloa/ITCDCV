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

	<!-- Si el usuario es un administrador, se muestra la contraseña -->
	<?php
	if (Yii::app()->user->rol == 'Admin'){
		echo "<b>Contraseña: </b>";
		echo CHtml::encode($data->password);
		echo "<br />";
	}
	?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('puesto')); ?>:</b>
	<?php echo CHtml::encode($data->puesto); ?>
	<br />

    <?php if(!isset($carreras)) { 

        $carreras = $this->getEmpleadoCarreras($data->nomina);

    } ?>

	    <b><?php echo CHtml::encode("Carreras"); ?>:</b>
        <?php foreach($carreras as $carr){
            echo CHtml::encode($carr)." ";
        }?>
	<br />

	<?php echo CHtml::link('Editar', array('update', 'id'=>$data->nomina)); ?>
	<br />






</div>
