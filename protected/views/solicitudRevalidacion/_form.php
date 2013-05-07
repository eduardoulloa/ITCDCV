<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'solicitud-revalidacion-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
	// Valida si el modelo es nuevo. En este caso se trata de
	// un alumno creando una nueva solicitud. Se despliega la forma
	// para crear la solicitud.
	if($model->isNewRecord) {
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'periodo'); ?>
		<?php echo $form->dropDownList($model,'periodo',array('Enero-Mayo'=>'Enero-Mayo', 'Verano'=>'Verano', 'Agosto-Diciembre'=>'Agosto-Diciembre')); ?>
		
		<?php echo $form->error($model,'periodo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clave_revalidar'); ?>
		<?php echo $form->textField($model,'clave_revalidar',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'clave_revalidar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre_revalidar'); ?>
		<?php echo $form->textField($model,'nombre_revalidar',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombre_revalidar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clave_cursada'); ?>
		<?php echo $form->textField($model,'clave_cursada',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'clave_cursada'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre_cursada'); ?>
		<?php echo $form->textField($model,'nombre_cursada',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombre_cursada'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'universidad'); ?>
		<?php echo $form->textField($model,'universidad',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'universidad'); ?>
	</div>

	<?php
	// Valida si el modelo no es nuevo y además si el usuario actual es un director de carrera, un asistente, una secretaria o un administrador general. En este caso
	// el usuario actual está editando la solicitud. Se despliega la forma apropiada.
	}else if (!$model->isNewRecord && (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria' || Yii::app()->user->rol =='Admin')){
		echo "<label for=\"status\" class=\"required\"> Estatus <span class=\"required\">*</span></label>";
		echo $form->dropDownList($model,'status',array('recibida'=>'Recibida', 'pendiente'=>'Pendiente'
														, 'terminada'=>'Terminada'));
		echo $form->error($model,'status');
		
	// Valida si el modelo no es nuevo y además si el usuario actual es un alumno. En este caso el
	// alumno está editando la solicitud. Se despliega la forma apropiada.
	}else if (!$model->isNewRecord && Yii::app()->user->rol == 'Alumno'){
		echo $form->labelEx($model,'clave_cursada');
		echo $form->textField($model,'clave_cursada',array('size'=>10,'maxlength'=>10));
		echo $form->error($model,'clave_cursada');

		echo $form->labelEx($model,'nombre_cursada');
		echo $form->textField($model,'nombre_cursada',array('size'=>60,'maxlength'=>100));
		echo $form->error($model,'nombre_cursada');
	
	}
	?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->