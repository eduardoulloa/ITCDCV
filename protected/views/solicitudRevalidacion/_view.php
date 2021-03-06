<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fechahora); ?>
	<br />
	
	<?php
	// Valida si el usuario actual es un director de carrera, un administrador general, un asistente o una secretaria. En este caso se
	// despliega la matrícula del alumno que creó la solicitud.
	if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria'){
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodo')); ?>:</b>
	<?php echo CHtml::encode($data->periodo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anio')); ?>:</b>
	<?php echo CHtml::encode($data->anio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clave_revalidar')); ?>:</b>
	<?php echo CHtml::encode($data->clave_revalidar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_revalidar')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_revalidar); ?>
	<br />
	
	<?php 
	// Valida si el usuario actual es un director de carrera, un administrador general, una secretaria o un asistente. En este caso se
	// despliega una liga para actualizar la solicitud.
	if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Secretaria' || Yii::app()->user->rol == 'Asistente'){
		echo CHtml::link('Editar', array('update', 'id'=>$data->id));
	}
	?>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('clave_cursada')); ?>:</b>
	<?php echo CHtml::encode($data->clave_cursada); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_cursada')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_cursada); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('universidad')); ?>:</b>
	<?php echo CHtml::encode($data->universidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('matriculaalumno')); ?>:</b>
	<?php echo CHtml::encode($data->matriculaalumno); ?>
	<br />

	*/ ?>

</div>