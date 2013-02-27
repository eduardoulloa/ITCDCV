<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'revalidacion-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'universidad'); ?>
		<?php echo $form->textField($model,'universidad',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'universidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clave_materia_local'); ?>
		<?php echo $form->textField($model,'clave_materia_local',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'clave_materia_local'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre_materia_local'); ?>
		<?php echo $form->textField($model,'nombre_materia_local',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombre_materia_local'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clave_materia_cursada'); ?>
		<?php echo $form->textField($model,'clave_materia_cursada',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'clave_materia_cursada'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre_materia_cursada'); ?>
		<?php echo $form->textField($model,'nombre_materia_cursada',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombre_materia_cursada'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'periodo_de_revalidacion'); ?>
		<?php echo $form->textField($model,'periodo_de_revalidacion',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'periodo_de_revalidacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'anio_de_revalidacion'); ?>
		<?php echo $form->textField($model,'anio_de_revalidacion',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'anio_de_revalidacion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->