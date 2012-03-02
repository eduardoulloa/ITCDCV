<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'solicitud-baja-semestre-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

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
		<?php echo $form->labelEx($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'extranjero'); ?>
		<?php echo $form->dropDownList($model,'extranjero',array('No'=>'No', 'Si'=>'Si')); ?>
		
		<?php echo $form->error($model,'extranjero'); ?>
	</div>
	<?php 
	
	}else{
	
		if (Yii::app()->user->rol == 'Director'){
		
		//Se trata de un director respondiendo a la solicitud.
		echo $form->labelEx($model,'status');
		echo $form->dropDownList($model,'status',array('recibida'=>'Recibida', 'pendiente'=>'Pendiente'
														, 'terminada'=>'Terminada'));
		echo $form->error($model,'status');
		
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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->