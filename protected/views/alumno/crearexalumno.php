<?php

$this->menu=array(
	array('label'=>'List Alumno', 'url'=>array('index')),
	array('label'=>'Manage Alumno', 'url'=>array('admin')),
);
?>

<h1>Crear ExAlumno</h1>

<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'alumno-form',
			'enableAjaxValidation'=>false,
		)); ?>

			<p class="note">Fields with <span class="required">*</span> are required.</p>

			<?php echo $form->errorSummary($model); ?>

			<?php echo $this->renderPartial('_exalumno', array('model'=>$model, 'form'=>$form)); ?>

			<div class="row buttons">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Save'); ?>
			</div>

		<?php $this->endWidget(); ?>

</div><!-- form -->
