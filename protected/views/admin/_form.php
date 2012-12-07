<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php if($model->isNewRecord){
	echo("<div class=\"row\">");
		echo $form->labelEx($model,'username');
		echo $form->textField($model,'username',array('size'=>25,'maxlength'=>25));
		echo $form->error($model,'username');
	echo("</div>");
	}
	?>
	
	<?php
	if(!$model->isNewRecord) {
	?>
	<div class="row">
		<label for="passwordActual" class="required">
			Contraseña actual
			<span class="required">*</span>
		</label>
		<?php echo(Chtml::passwordField('passwordActual', '', array('size'=>45,'maxlength'=>45))); ?>
	</div>
	<?php
	}
	?>
	
	<div class="row">
		<label for="passwordActual" class="required">
			Contraseña nueva
			<span class="required">*</span>
		</label>
		<?php /*echo $form->labelEx($model,'password');*/ ?>
		<?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->