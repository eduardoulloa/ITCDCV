<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'solicitud-problemas-inscripcion-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'periodo'); ?>
		<?php echo $form->dropDownList($model,'periodo',array('Enero-Mayo'=>'Enero-Mayo', 'Verano'=>'Verano', 'Agosto-Diciembre'=>'Agosto-Diciembre')); ?>
		<?php echo $form->error($model,'periodo'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'unidades'); ?>
		<?php echo $form->textField($model,'unidades', array('size'=>4, 'maxlength'=>4)); ?>
		<?php echo $form->error($model,'unidades'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quitar_prioridades'); ?>
		<?php echo $form->dropDownList($model,'quitar_prioridades',array('No'=>'No', 'Si'=>'Si')); ?>
		
		<?php echo $form->error($model,'quitar_prioridades'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comentarios'); ?>
		<?php echo $form->textArea($model,'comentarios',array('rows'=>8, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comentarios'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->