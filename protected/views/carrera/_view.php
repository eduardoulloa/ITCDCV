<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('siglas')); ?>:</b>
	<?php echo CHtml::encode($data->siglas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />
	
	<?php if(Yii::app()->user->rol == 'Admin'){
		echo CHtml::link('Editar', array('update', 'id'=>$data->id));
	}
	?>

</div>