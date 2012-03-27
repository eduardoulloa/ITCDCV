<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fechahora); ?>
	<br />
	
	<?php
	if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Asistente'){ //si el usuario es director de carrera debe ver tambien la matricula del alumno
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('sugerencia')); ?>:</b>
	<?php echo CHtml::encode($data->sugerencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('respuesta')); ?>:</b>
	<?php echo CHtml::encode($data->respuesta); ?>
	<br />
	
	
	<?php if(Yii::app()->user->rol != 'Alumno' && Yii::app()->user->rol != 'Secretaria'){
		echo CHtml::link('Editar', array('update', 'id'=>$data->id));
	}
	?>
	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('matriculaalumno')); ?>:</b>
	<?php echo CHtml::encode($data->matriculaalumno); ?>
	<br />
	*/ ?>


</div>