<div class="form">

<SCRIPT LANGUAGE="JavaScript" type="text/javascript">

/*function checkAll()
{
//for (i = 0; i < field.length; i++){
	//field[i].checked = true ;
	for (var i = 0; i<document.forms[0].elements.length; i++){
	var e=document.forms[0].elements[i];
		if (e.type=='textbox')
		{
			e.value = "";
		}
}
	
}*/

</SCRIPT>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'alumno-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php
		//va a hacer un update y es director o admin
		// o va a registrar un nuevo exalumno
		if(!esAlumno() || !userTieneRolAsignado()) {
			
		
	?>
	
	<?php echo $this->renderPartial('_alumno_actual', array('model'=>$model, 'form'=>$form)); ?>
	<?php echo $this->renderPartial('_exalumno', array('model'=>$model, 'form'=>$form)); ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>
	
	<?php
		//Si es un alumno, solo debe poder modificar su password e e-mail.
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
	<?php /*echo $form->labelEx($model,'password');*/ ?>
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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>
	
	<?php
		}

	?>

<?php $this->endWidget(); ?>

</div><!-- form -->

