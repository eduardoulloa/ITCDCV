<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechahora')); ?>:</b>
	<?php echo CHtml::encode($data->fechahora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('universidad')); ?>:</b>
	<?php echo CHtml::encode($data->universidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clave_materia_local')); ?>:</b>
	<?php echo CHtml::encode($data->clave_materia_local); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_materia_local')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_materia_local); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clave_materia_cursada')); ?>:</b>
	<?php echo CHtml::encode($data->clave_materia_cursada); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_materia_cursada')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_materia_cursada); ?>
	<br />
	
	<?php
	if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria'){
		$carrera = Carrera::model()->findByPk($data->idcarrera);
		echo "<b>Carrera: </b>";
		echo CHtml::encode($carrera->siglas);
		echo "<br />";
	}
	?>
	
	<?php if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Secretaria' || Yii::app()->user->rol == 'Asistente'){
		echo CHtml::link('Editar', array('update', 'id'=>$data->id));
	}
	?>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('periodo_de_revalidacion')); ?>:</b>
	<?php echo CHtml::encode($data->periodo_de_revalidacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anio_de_revalidacion')); ?>:</b>
	<?php echo CHtml::encode($data->anio_de_revalidacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idcarrera')); ?>:</b>
	<?php echo CHtml::encode($data->idcarrera); ?>
	<br />

	*/ ?>

</div>