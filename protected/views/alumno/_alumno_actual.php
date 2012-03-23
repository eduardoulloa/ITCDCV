

<div class="row">
	<?php echo $form->labelEx($model,'semestre'); ?>
	<?php echo $form->textField($model,'semestre'); ?>
	<?php echo $form->error($model,'semestre'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'plan'); ?>
	<?php echo $form->textField($model,'plan',array('size'=>10,'maxlength'=>10)); ?>
	<?php echo $form->error($model,'plan'); ?>
</div>

