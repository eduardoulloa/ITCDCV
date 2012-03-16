<div class="form">

<SCRIPT LANGUAGE="JavaScript" type="text/javascript">

function checkAll()
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
	
}

</SCRIPT>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'alumno-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php
		
		if(Yii::app()->user->rol != 'Alumno'){
		
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'matricula'); ?>
		<?php echo $form->textField($model,'matricula',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'matricula'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellido_paterno'); ?>
		<?php echo $form->textField($model,'apellido_paterno',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'apellido_paterno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellido_materno'); ?>
		<?php echo $form->textField($model,'apellido_materno',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'apellido_materno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'plan'); ?>
		<?php echo $form->textField($model,'plan',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'plan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'semestre'); ?>
		<?php echo $form->textField($model,'semestre'); ?>
		<?php echo $form->error($model,'semestre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'anio_graduado'); ?>
		<?php echo $form->textField($model,'anio_graduado',array('size'=>4,'maxlength'=>4)); ?>
		<?php /*echo $form->dropDownList($model,'anio_graduado',array('2005'=>'2005', '2006'=>'2006'
														, '2007'=>'2009'));*/ ?>
		<?php echo $form->error($model,'anio_graduado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'idcarrera'); ?>
		<?php echo $form->textField($model,'idcarrera'); ?>
		<?php echo $form->error($model,'idcarrera'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Save'); ?>
	</div>
	
	<?php
		//Si es un alumno, solo debe poder modificar su password e e-mail.
		}else if (Yii::app()->user->rol == 'Alumno'){
	?>
	
	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45)); ?>
	<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Save'); ?>
	</div>
	
	<?php
		
		
		
		}
		
		
	?>

<?php $this->endWidget(); ?>

</div><!-- form -->

