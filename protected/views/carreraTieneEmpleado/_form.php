<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'carrera-tiene-empleado-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'idcarrera'); ?>
		<?php echo $form->textField($model,'idcarrera'); ?>
		<?php echo $form->error($model,'idcarrera'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nomina'); ?>
		<?php echo $form->textField($model,'nomina',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'nomina'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->