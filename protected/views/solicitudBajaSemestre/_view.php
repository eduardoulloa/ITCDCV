<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fechahora); ?>
	<br />
	
	<?php
	// Valida si el usuario actual es un director de carrera o un administrador general. En este
	// caso se despliega la matrícula del alumno que creó la solicitud.
	if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){
		echo "<b>";
		echo "Matrícula del alumno";
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('domicilio')); ?>:</b>
	<?php echo CHtml::encode($data->domicilio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('motivo')); ?>:</b>
	<?php echo CHtml::encode($data->motivo); ?>
	<br />
	
	<?php 
	// Valida si el usuario actual es un director de carrera, un administrador general, una secretaria o un asistente. En este
	// caso se despliega una liga para editar la solicitud.
	if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Secretaria' || Yii::app()->user->rol == 'Asistente' ){
		echo CHtml::link('Editar', array('update', 'id'=>$data->id));
	}
	?>
	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono')); ?>:</b>
	<?php echo CHtml::encode($data->telefono); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extranjero')); ?>:</b>
	<?php echo CHtml::encode($data->extranjero); ?>
	<br />

	

	*/ ?>

</div>