<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mensaje'); ?>
		<?php echo $form->textField($model,'mensaje',array('size'=>60,'maxlength'=>10000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechahora'); ?>
		<?php echo $form->textField($model,'fechahora'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'semestre1'); ?>
		<?php echo $form->textField($model,'semestre1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'semestre2'); ?>
		<?php echo $form->textField($model,'semestre2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'semestre3'); ?>
		<?php echo $form->textField($model,'semestre3'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'semestre4'); ?>
		<?php echo $form->textField($model,'semestre4'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'semestre5'); ?>
		<?php echo $form->textField($model,'semestre5'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'semestre6'); ?>
		<?php echo $form->textField($model,'semestre6'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'semestre7'); ?>
		<?php echo $form->textField($model,'semestre7'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'semestre8'); ?>
		<?php echo $form->textField($model,'semestre8'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'semestre9'); ?>
		<?php echo $form->textField($model,'semestre9'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exatec'); ?>
		<?php echo $form->textField($model,'exatec'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idcarrera'); ?>
		<?php echo $form->textField($model,'idcarrera'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->