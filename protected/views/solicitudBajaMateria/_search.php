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
		<?php echo $form->label($model,'fechahora'); ?>
		<?php echo $form->textField($model,'fechahora'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'motivo'); ?>
		<?php echo $form->textField($model,'motivo',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clave_materia'); ?>
		<?php echo $form->textField($model,'clave_materia',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre_materia'); ?>
		<?php echo $form->textField($model,'nombre_materia',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unidades_materia'); ?>
		<?php echo $form->textField($model,'unidades_materia'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grupo'); ?>
		<?php echo $form->textField($model,'grupo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'atributo'); ?>
		<?php echo $form->textField($model,'atributo',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unidades'); ?>
		<?php echo $form->textField($model,'unidades'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'periodo'); ?>
		<?php echo $form->textField($model,'periodo',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'anio'); ?>
		<?php echo $form->textField($model,'anio',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'matriculaalumno'); ?>
		<?php echo $form->textField($model,'matriculaalumno',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->