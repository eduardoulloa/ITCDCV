<div class="form">



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'boletin-informativo-form',
	'enableAjaxValidation'=>false,
)); ?>


	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>
	
	<div class="row">	
	<label for="idcarrera" class="required">
		Seleccionar carrera:
		<span class="required">*</span>
	</label>
	
	<?php		
		// Criterios para obtener las carreras en las que labora el
		// director de carrera.
		$criteria = new CDbCriteria(array(
			'join'=>'JOIN carrera_tiene_empleado as c on t.id = c.idcarrera AND c.nomina =\''.Yii::app()->user->id.'\'',
			));
					
		// Obtiene los modelos de las carreras en las que
		// labora el director de carrera.
		$carreras = Carrera::model()->findAll($criteria);
				
		// Enlista las carreras en las que labora el director de
		// carrera.
		$opciones = CHtml::listData($carreras, 'id', 'siglas');
		
		// Despliega un menú de tipo "drop-down", con las siglas de las
		// carreras en las que labora el director de carrera.
		echo $form->dropDownList($model,'idcarrera', $opciones); 
	?>
	<?php echo $form->error($model,'idcarrera'); ?>
	</div>
	
	<p><strong>Seleccionar alumnos por semestre:</strong> </p>
	
	<?php echo $form->errorSummary($model); ?>
	
	<div class="column">
		<?php echo $form->labelEx($model,'1'); ?>
		<?php echo $form->checkBox($model,'semestre1'); ?>
		<?php echo $form->error($model,'semestre1'); ?>
	</div>

	<div class="column">
		<?php echo $form->labelEx($model,'2'); ?>
		<?php echo $form->checkBox($model,'semestre2'); ?>
		<?php echo $form->error($model,'semestre2'); ?>
	</div>

	<div class="column">
		<?php echo $form->labelEx($model,'3'); ?>
		<?php echo $form->checkBox($model,'semestre3'); ?>
		<?php echo $form->error($model,'semestre3'); ?>
	</div>

	<div class="column">
		<?php echo $form->labelEx($model,'4'); ?>
		<?php echo $form->checkBox($model,'semestre4'); ?>
		<?php echo $form->error($model,'semestre4'); ?>
	</div>

	<div class="column">
		<?php echo $form->labelEx($model,'5'); ?>
		<?php echo $form->checkBox($model,'semestre5'); ?>
		<?php echo $form->error($model,'semestre5'); ?>
	</div>

	<div class="column">
		<?php echo $form->labelEx($model,'6'); ?>
		<?php echo $form->checkBox($model,'semestre6'); ?>
		<?php echo $form->error($model,'semestre6'); ?>
	</div>

	<div class="column">
		<?php echo $form->labelEx($model,'7'); ?>
		<?php echo $form->checkBox($model,'semestre7'); ?>
		<?php echo $form->error($model,'semestre7'); ?>
	</div>

	<div class="column">
		<?php echo $form->labelEx($model,'8'); ?>
		<?php echo $form->checkBox($model,'semestre8'); ?>
		<?php echo $form->error($model,'semestre8'); ?>
	</div>

	<div class="column">
		<?php echo $form->labelEx($model,'9'); ?>
		<?php echo $form->checkBox($model,'semestre9'); ?>
		<?php echo $form->error($model,'semestre9'); ?>
	</div>

	<div class="column">
		<?php echo $form->labelEx($model,'Exatec'); ?>
		<?php echo $form->checkBox($model,'exatec'); ?>
		<?php echo $form->error($model,'exatec'); ?>
	</div>
	
	<br />
	
	<!-- Despliega un botón para seleccionar todas las casillas de
	verificación de los destinatarios del boletín -->
	<input type="button" name="CheckAll" value="Seleccionar todos"
	onClick="checkAll()">
	
	<!-- Despliega un botón para deseleccionar todas las casillas de
	verificación de los destinatarios del boletín -->
	<input type="button" name="UnCheckAll" value="Borrar selecci&oacute;n"
	onClick="uncheckAll()">
	<br />
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Enviar e-mail' : 'Save'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'mensaje'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'mensaje'); ?>
		<?php echo $form->textArea($model,'mensaje',array('rows'=>15, 'cols'=>80)); ?>
		<?php echo $form->error($model,'mensaje'); ?>
	</div>
	
<?php $this->endWidget(); ?>


<SCRIPT LANGUAGE="JavaScript">
<!-- 	
// by Nannette Thacker
// http://www.shiningstar.net
// This script checks and unchecks boxes on a form
// Checks and unchecks unlimited number in the group...
// Pass the Checkbox group name...
// call buttons as so:
// <input type=button name="CheckAll"   value="Check All"
	//onClick="checkAll(document.myform.list)">
// <input type=button name="UnCheckAll" value="Uncheck All"
	//onClick="uncheckAll(document.myform.list)">
// -->

<!-- Begin
function checkAll()
{

	for (var i = 0; i<document.forms[0].elements.length; i++){
	var e=document.forms[0].elements[i];
		if (e.type=='checkbox')
		{
			e.checked=true;
		}

}
	
}

function uncheckAll(field)
{
	for (var i = 0; i<document.forms[0].elements.length; i++){
	var e=document.forms[0].elements[i];
		if (e.type=='checkbox')
		{
			e.checked=false;
		}

}

}

</script>

</div><!-- form -->