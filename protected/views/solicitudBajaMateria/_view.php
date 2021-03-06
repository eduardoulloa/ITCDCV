
<div class="view" >

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
		echo "Matrícula";
		echo ": </b>";
		echo CHtml::encode($data->matriculaalumno);
		echo "<br />";
	} 
		
	?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('motivo')); ?>:</b>
	<?php echo CHtml::encode($data->motivo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clave_materia')); ?>:</b>
	<?php echo CHtml::encode($data->clave_materia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_materia')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_materia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unidades_materia')); ?>:</b>
	<?php echo CHtml::encode($data->unidades_materia); ?>
	<br />
	
	<?php if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){
		echo CHtml::link('Editar', array('update', 'id'=>$data->id));
	}
	?>
	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('grupo')); ?>:</b>
	<?php echo CHtml::encode($data->grupo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('atributo')); ?>:</b>
	<?php echo CHtml::encode($data->atributo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unidades')); ?>:</b>
	<?php echo CHtml::encode($data->unidades); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodo')); ?>:</b>
	<?php echo CHtml::encode($data->periodo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anio')); ?>:</b>
	<?php echo CHtml::encode($data->anio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('matriculaalumno')); ?>:</b>
	<?php echo CHtml::encode($data->matriculaalumno); ?>
	<br />

	*/ ?>

</div>