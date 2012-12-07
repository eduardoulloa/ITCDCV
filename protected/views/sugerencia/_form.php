<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sugerencia-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php
		//Se trata de un alumno colocando una nueva sugerencia.
		if($model->isNewRecord){
			echo $form->labelEx($model,'sugerencia');
			echo $form->textArea($model,'sugerencia',array('rows'=>8,'cols'=>50));
			echo $form->error($model,'sugerencia');
		}else if (!$model->isNewRecord && (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Admin')){
			//Se trata de un director respondiendo a la sugerencia.
			echo $form->labelEx($model,'respuesta');
			echo $form->textArea($model,'respuesta',array('rows'=>8,'cols'=>50));
			echo $form->error($model,'respuesta');
			
			echo "<label for=\"status\" class=\"required\"> Estatus <span class=\"required\">*</span></label>";
			echo $form->dropDownList($model,'status',array('recibida'=>'Recibida', 'pendiente'=>'Pendiente', 'terminada'=>'Terminada'));
			echo $form->error($model,'status');
			
		}
	?>
	</div>
	
	<!--
	<div class="row">
		<?php /*echo $form->labelEx($model,'sugerencia'); ?>
		<?php echo $form->textArea($model,'sugerencia',array('rows'=>8,'cols'=>50)); ?>
		<?php echo $form->error($model,'sugerencia'); */?>
	</div>
	-->
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->