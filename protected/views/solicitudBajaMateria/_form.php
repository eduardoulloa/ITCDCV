<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'solicitud-baja-materia-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
		// Valida si el modelo es nuevo. En este caso, se trata de
		// un alumno creando una nueva solicitud. Se despliegan los
		// campos necesarios para crear la solicitud.
		if($model->isNewRecord) {
		?>

	<div class="row">
		<?php echo $form->labelEx($model,'motivo'); ?>
		<?php echo $form->textArea($model,'motivo',array('rows'=>8,'cols'=>50)); ?>
		<?php echo $form->error($model,'motivo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clave_materia'); ?>
		<?php echo $form->textField($model,'clave_materia',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'clave_materia'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre_materia'); ?>
		<?php echo $form->textField($model,'nombre_materia',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombre_materia'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'grupo'); ?>
		<?php echo $form->textField($model,'grupo', array('size'=>3)); ?>
		<?php echo $form->error($model,'grupo'); ?>
	</div>

	<div class="row">
		
		<?php echo $form->labelEx($model,'atributo'); ?> 
		<?php echo $form->dropDownList($model,'atributo',array('presencial'=>'Presencial', 'en linea'=>'En Linea', 'U.V.'=>'U.V.')); ?>
		
		<?php echo $form->error($model,'atributo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unidades'); ?>
		<?php echo $form->textField($model,'unidades', array('size'=>3)); ?>
		<?php echo $form->error($model,'unidades'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'periodo'); ?>
		<?php echo $form->dropDownList($model,'periodo',array('Enero-Mayo'=>'Enero-Mayo', 'Verano'=>'Verano', 'Agosto-Diciembre'=>'Agosto-Diciembre')); ?>
		
		<?php echo $form->error($model,'periodo'); ?>
	</div>

	<?php
	// El modelo no es nuevo.
	}else{
		
		// Valida si el usuario actual es un director de carrera o un administrador general. En este caso,
		// se trata de algún usuario editando la solicitud.
		if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){
			
			// Despliega un menú tipo drop-down con opciones para modificar el
			// estatus de la solicitud.
			echo "<label for=\"status\" class=\"required\"> Estatus <span class=\"required\">*</span></label>";
			echo $form->dropDownList($model,'status',array('recibida'=>'Recibida', 'pendiente'=>'Pendiente'
															, 'terminada'=>'Terminada'));
			echo $form->error($model,'status');
		
		// Valida si el usuario actual es un alumno. En este caso se despliega un
		// área de texto para editar el motivo de la solicitud.
		}else if (Yii::app()->user->rol == 'Alumno'){
			
			echo("<div class=\"row\">");
			echo $form->labelEx($model,'motivo');
			echo $form->textArea($model,'motivo',array('rows'=>8,'cols'=>50));
			echo $form->error($model,'motivo');
			echo("</div>");
			
		}
	}
	?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->