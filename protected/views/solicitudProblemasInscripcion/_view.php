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

	<b><?php echo CHtml::encode($data->getAttributeLabel('unidades')); ?>:</b>
	<?php echo CHtml::encode($data->unidades); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quitar_prioridades')); ?>:</b>
	<?php echo CHtml::encode($data->quitar_prioridades); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('comentarios')); ?>:</b>
	<?php echo CHtml::encode($data->comentarios); ?>
	<br />
	
	<?php 
	// Valida si el usuario actual es un director de carrera, un administrador general, un asistente o una secretaria. En este caso
	// se despliega una liga para editar la solicitud.
	if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria'){
		echo CHtml::link('Editar', array('update', 'id'=>$data->id));
	}
	?>
	
	<!--
	<b><?php /*echo CHtml::encode($data->getAttributeLabel('matriculaalumno')); */?>:</b>
	<?php /*echo CHtml::encode($data->matriculaalumno); */?>
	<br />
	-->

</div>