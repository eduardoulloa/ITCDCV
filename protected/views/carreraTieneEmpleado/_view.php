<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('nomina')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->nomina), array('view', 'id'=>$data->nomina)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idcarrera')); ?>:</b>
	<?php echo CHtml::encode($data->idcarrera); ?>
	<br />


</div>