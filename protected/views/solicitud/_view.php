<div class="view <?php echo CHtml::encode($data->status); ?>" >

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('/'.get_class($data)
				.'/view', 'id'=>$data->id)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('Status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode('Tipo')?>:</b>
	<?php echo CHtml::encode(get_class($data)); ?>
	<br />
	
	<!-- fue modificada la condicion para que los alumnos no puedan hacer updates de sus solicitudes.
	a continuacion se muestra como originalmente estaba la solicitud-->
	<?php /*if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Alumno'){
		echo CHtml::link(CHtml::encode('Editar'), array('/'.get_class($data)
				.'/update', 'id'=>$data->id));
	}*/
	?>
	
	<?php if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){
		echo CHtml::link(CHtml::encode('Editar'), array('/'.get_class($data)
				.'/update', 'id'=>$data->id));
	}
	?>
	
	<?php
	
	/*if (Yii::app()->user->rol == 'Alumno'){
		echo(" ");
		echo CHtml::link(CHtml::encode('Eliminar'), array('/'.get_class($data)
				.'/delete', 'id'=>$data->id));
		
		} */
		
		?>

</div>
