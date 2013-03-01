<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'solicitud-carta-recomendacion-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
	//Se trata de un alumno colocando una nueva solicitud.
	if($model->isNewRecord) { 
	?>


	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->dropDownList($model,'tipo',array('Carta de recomendación DAE'=>'Carta de recomendación DAE', 
											'Carta de recomendación para PI'=>'Carta de recomendación para PI', 
											'Carta de recomendación para universidad extranjera'=>'Carta de recomendación para universidad extranjera',
											'Carta de recomendación para graduados'=>'Carta de recomendación para graduados',
											'Carta de comprobación de semestre'=>'Carta de comprobación de semestre',
											'Carta de comprobacion de promedio'=>'Carta de comprobación de promedio',
											'Otro tipo de carta'=>'Otro tipo de carta',
											)); ?>
		
		<?php echo $form->error($model,'tipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formato'); ?>
		<?php echo $form->textField($model,'formato',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'formato'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comentarios'); ?>
		<?php echo $form->textArea($model,'comentarios',array('rows'=>8,'cols'=>50)); ?>
		<?php echo $form->error($model,'comentarios'); ?>
	</div>

	<?php 
	}else if(!$model->isNewRecord && (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin')){
		//Se trata de un director respondiendo a la solicitud.
		echo "<label for=\"status\" class=\"required\"> Estatus <span class=\"required\">*</span></label>";
		echo $form->dropDownList($model,'status',array('recibida'=>'Recibida', 'pendiente'=>'Pendiente'
														, 'terminada'=>'Terminada'));
		echo $form->error($model,'status');
	}else if(!$model->isNewRecord && Yii::app()->user->rol == 'Alumno'){
		echo $form->labelEx($model, 'comentarios');
		echo $form->textArea($model,'comentarios',array('rows'=>8,'cols'=>50));
		echo $form->error($model,'comentarios');
	}
	?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->