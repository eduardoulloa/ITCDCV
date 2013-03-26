<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />
	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('subject')); ?>:</b>
	<?php echo CHtml::encode($data->subject); ?>
	<br />
	*/
	?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('mensaje')); ?>:</b>
	<?php echo CHtml::encode($data->mensaje); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechahora')); ?>:</b>
	<?php echo CHtml::encode($data->fechahora); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre1')); ?>:</b>
	<?php echo CHtml::encode($data->semestre1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre2')); ?>:</b>
	<?php echo CHtml::encode($data->semestre2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre3')); ?>:</b>
	<?php echo CHtml::encode($data->semestre3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre4')); ?>:</b>
	<?php echo CHtml::encode($data->semestre4); ?>
	<br />
	*/
	?>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre5')); ?>:</b>
	<?php echo CHtml::encode($data->semestre5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre6')); ?>:</b>
	<?php echo CHtml::encode($data->semestre6); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre7')); ?>:</b>
	<?php echo CHtml::encode($data->semestre7); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre8')); ?>:</b>
	<?php echo CHtml::encode($data->semestre8); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre9')); ?>:</b>
	<?php echo CHtml::encode($data->semestre9); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exatec')); ?>:</b>
	<?php echo CHtml::encode($data->exatec); ?>
	<br />
	*/
	?>
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('idcarrera')); ?>:</b>
	<?php echo CHtml::encode($data->idcarrera); ?>
	<br />


</div>