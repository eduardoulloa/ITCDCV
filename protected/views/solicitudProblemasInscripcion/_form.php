<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'solicitud-problemas-inscripcion-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
	//Se trata de un alumno colocando una nueva solicitud.
	if($model->isNewRecord) { 
	?>

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
	
	<?php 
	}else if(!$model->isNewRecord && (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Admin')){
		//Se trata de un director respondiendo a la solicitud.
		echo "<label for=\"status\" class=\"required\"> Estatus <span class=\"required\">*</span></label>";
		echo $form->dropDownList($model,'status',array('recibida'=>'Recibido', 'pendiente'=>'Pendiente'
														, 'terminada'=>'Terminado'));
		echo $form->error($model,'status');
	}else if(!$model->isNewRecord && Yii::app()->user->rol == 'Alumno'){
	
		echo $form->labelEx($model,'comentarios');
		echo $form->textArea($model,'comentarios',array('rows'=>8, 'cols'=>50));
		echo $form->error($model,'comentarios');
		
	}
	?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->