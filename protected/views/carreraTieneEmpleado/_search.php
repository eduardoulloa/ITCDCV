<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idcarrera'); ?>
		<?php echo $form->textField($model,'idcarrera'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nomina'); ?>
		<?php echo $form->textField($model,'nomina',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->