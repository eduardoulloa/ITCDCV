<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fechahora); ?>
	<br />
	
	<?php
	// Valida si el usuario actual es un director de carrera, un administrador general o un asistente. En este
	// caso se despliega la matrícula del alumno que creó la sugerencia.
	if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Asistente'){
		echo "<b>";
		echo "Matrícula"; 
		echo ": </b>";
		echo CHtml::encode($data->matriculaalumno);
		echo "<br />";	
	} 	
	?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sugerencia')); ?>:</b>
	<?php echo CHtml::encode($data->sugerencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('respuesta')); ?>:</b>
	<?php echo CHtml::encode($data->respuesta); ?>
	<br />
	
	<?php 
	// Valida si el usuario actual no es un alumno ni una secretaria. En este caso
	// se despliega una liga para editar la sugerencia.
	if(Yii::app()->user->rol != 'Alumno' && Yii::app()->user->rol != 'Secretaria'){
		echo CHtml::link('Editar', array('update', 'id'=>$data->id));
	}
	?>
	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('matriculaalumno')); ?>:</b>
	<?php echo CHtml::encode($data->matriculaalumno); ?>
	<br />
	*/ ?>
</div>