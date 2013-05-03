<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('matricula')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->matricula), array('view', 'id'=>$data->matricula)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('plan')); ?>:</b>
	<?php echo CHtml::encode($data->plan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre')); ?>:</b>
	<?php echo CHtml::encode($data->semestre); ?>
	<br />

	<?php
	
	// Valida si el usuario actual es un administrador general. En este
	// caso se despliega la contraseña del alumno o exalumno.
	if (Yii::app()->user->rol == 'Admin'){
		echo "<b>Contraseña: </b>";
		echo CHtml::encode($data->password);
		echo "<br />";
	}
	?>
	
	<?php
	
	// Valida si el usuario actual es un director de carrera o un administrador general. En este
	// caso se despliega una liga a la acción 'update', para editar los datos del alumno o
	// exalumno.
	if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){
		echo CHtml::link('Editar', array('update', 'id'=>$data->matricula));
	}
	?>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('anio_graduado')); ?>:</b>
	<?php echo CHtml::encode($data->anio_graduado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idcarrera')); ?>:</b>
	<?php echo CHtml::encode($data->idcarrera); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	*/?>

</div>