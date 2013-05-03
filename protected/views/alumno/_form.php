<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'alumno-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php
		
		// Valida si el usuario actual no es un alumno ni un usuario autenticado. En este
		// caso se trata de una actualización. Un administrador general o un director de
		// carrera realizará la actualización de datos de algún alumno actual o bien,
		// registrará a un nuevo exalumno. En este caso se despliega el contenido de los
		// archivos '_alumno_actual.php' y '_exalumno.php'.
		if(!esAlumno() || !userTieneRolAsignado()) {
			
	?>
	
	<?php echo $this->renderPartial('_alumno_actual', array('model'=>$model, 'form'=>$form)); ?>
	<?php echo $this->renderPartial('_exalumno', array('model'=>$model, 'form'=>$form)); ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrar' : 'Guardar'); ?>
	</div>
	
	<?php

		// El resto de los casos, que corresponde a los alumnos. En este caso
		// solo se despliegan campos de texto para ingresar la contraseña y la
		// dirección de correo electrónico.
		} else  {
	?>
	
	<div class="row">
		<label for="passwordActual" class="required">
			Contraseña actual
			<span class="required">*</span>
		</label>
		<?php echo(Chtml::passwordField('passwordActual', '', array('size'=>45,'maxlength'=>45))); ?>
	</div>
	
	<div class="row">
	<label for="password" class="required">
			Contraseña nueva
			<span class="required">*</span>
	</label>
	<?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45)); ?>
	<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row">
		<label for="password" class="required">
				E-mail
				<span class="required">*</span>
		</label>
		<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrar' : 'Guardar'); ?>
	</div>
	
	<?php
		}

	?>

<?php $this->endWidget(); ?>

</div><!-- form -->