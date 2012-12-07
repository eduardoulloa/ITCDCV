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

			<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

			<?php echo $form->errorSummary($model); ?>

			<?php echo $this->renderPartial('_exalumno', array('model'=>$model, 'form'=>$form)); ?>
			<?php /*echo $this->renderPartial('_form', array('model'=>$model, 'form'=>$form));*/ ?>
			

			<div class="row buttons">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
			</div>

		<?php $this->endWidget(); ?>

</div><!-- form -->
