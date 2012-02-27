<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fechahora); ?>
	<br />
	
	<?php
	if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){ //si el usuario es director de carrera debe ver tambien la matricula del alumno
		echo "<b>";
		echo CHtml::encode($data->getAttributeLabel('Matricula del Alumno')); 
		echo ":</b>";
		echo CHtml::encode($data->matriculaalumno);
		echo "<br />";
		} 
	?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($data->tipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('formato')); ?>:</b>
	<?php echo CHtml::encode($data->formato); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comentarios')); ?>:</b>
	<?php echo CHtml::encode($data->comentarios); ?>
	<br />
	<?php echo CHtml::link('Editar', array('update', 'id'=>$data->id)); ?>
	

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('matriculaalumno')); ?>:</b>
	<?php echo CHtml::encode($data->matriculaalumno); ?>
	<br />
	*/?>
	


</div>