<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'solicitud-baja-semestre-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php 

	// Valida si el modelo es nuevo. Es decir, si se trata de un
	// alumno creando una nueva solicitud. En este caso se
	// despliega una forma con los elementos necesarios para
	// crear una nueva solicitud.
	if($model->isNewRecord) {
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'periodo'); ?>
		<?php echo $form->dropDownList($model,'periodo',array('Enero-Mayo'=>'Enero-Mayo', 'Verano'=>'Verano', 'Agosto-Diciembre'=>'Agosto-Diciembre')); ?>
		
		<?php echo $form->error($model,'periodo'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'domicilio'); ?>
		<?php echo $form->textField($model,'domicilio',array('size'=>65,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'domicilio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'motivo'); ?>
		<?php echo $form->textArea($model,'motivo',array('rows'=>8,'cols'=>50)); ?>
		<?php echo $form->error($model,'motivo'); ?>
	</div>

	<div class="row">
		<label for="password" class="required">
				Teléfono
				<span class="required">*</span>
		</label>
		<?php echo $form->textField($model,'telefono',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'extranjero'); ?>
		<?php echo $form->dropDownList($model,'extranjero',array('No'=>'No', 'Si'=>'Si')); ?>
		
		<?php echo $form->error($model,'extranjero'); ?>
	</div>
	<?php 
	
	// El modelo no es nuevo. En este caso, el usuario está editando un
	// modelo existente.
	}else{
		
		// Valida si el usuario actual es un director de carrera o un administrador general.
		if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){
		
		// Despliega un menú tipo drop-down con opciones para cambiar el estatus de la
		// solicitud.
		echo "<label for=\"status\" class=\"required\"> Estatus <span class=\"required\">*</span></label>";
		echo $form->dropDownList($model,'status',array('recibida'=>'Recibida', 'pendiente'=>'Pendiente'
														, 'terminada'=>'Terminada'));
		echo $form->error($model,'status');
		
		// Valida si el usuario actual es un alumno (o exalumno). En este caso se despliega una forma
		// para que el usuario pueda editar la solicitud.
		}else if (Yii::app()->user->rol == 'Alumno'){
			
			
			echo("<div class=\"row\">");
			echo $form->labelEx($model,'domicilio');
			echo $form->textField($model,'domicilio',array('size'=>65,'maxlength'=>100));
			echo $form->error($model,'domicilio');
			echo("</div>");

			echo("<div class=\"row\">");
			echo $form->labelEx($model,'motivo');
			echo $form->textArea($model,'motivo',array('rows'=>8,'cols'=>50));
			echo $form->error($model,'motivo');
			echo("</div>");

			echo("<div class=\"row\">");
			echo $form->labelEx($model,'telefono');
			echo $form->textField($model,'telefono',array('size'=>12,'maxlength'=>12));
			echo $form->error($model,'telefono');
			echo("</div>");
			
		}
	}
	?>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->