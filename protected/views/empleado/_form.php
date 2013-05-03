<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'empleado-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php
		// Valida si el usuario actual es un administrador general.
		if(Yii::app()->user->rol == 'Admin'){
			
			// Valida si el modelo no es nuevo. En este caso se
			// despliega la forma apropiada para actualizar los datos del
			// empleado.
			if(!$model->isNewRecord){
	?>
			<div class="row">
		<?php echo $form->labelEx($model,'nomina'); ?>
		<?php echo $form->textField($model,'nomina',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'nomina'); ?>
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
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puesto'); ?>
		<?php echo $form->dropDownList($model,'puesto', getPuestos()); ?>
		<?php echo $form->error($model,'puesto'); ?>
	</div>
	
	<div class="row">
      <?php echo $form->label($model_carrera,'Carreras:'); ?>
      <?php echo $form->dropDownList($model_carrera,'id', $carreras); ?>
  </div>


  <div class="row">
      <?php echo $form->label($model_carrera,'Agregar Carrera'); ?>
      <?php echo $form->dropDownList($model_carrera,'id', $not_carreras); ?>
  </div>

  
  <?php
	}
	}
		// Valida si el usuario actual es un director de carrera, tratando de
		// actualizar los datos de algún otro empleado.
		else if(esDirector() && Yii::app()->user->id != $model->nomina) {
	?>
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
		<?php echo $form->label($model_carrera,'Carreras:'); 
	  
		// Criterios para obtener las carreras en las que labora el
		// director de carrera
		$criteria = new CDbCriteria(array(
				'join'=>'JOIN carrera_tiene_empleado as c on t.id = c.idcarrera AND c.nomina =\''.$model->nomina.'\'',
				));
		
		// Obtiene los modelos de todas las carreras en las que
		// labora el director de carrera.
		$carreras = Carrera::model()->findAll($criteria);
				
		// Enlista las siglas de las carreras en las que labora el
		// director de carrera, con los respectivos IDs de las carreras.
		$opciones = CHtml::listData($carreras, 'id', 'siglas');
		
		// Despliega un menú tipo 'drop-down', con las siglas de las
		// carreras en las que labora el director.
		echo $form->dropDownList($model_carrera,'id', $opciones);
		?>
	  
		</div>

	  <div class="row">
	      <?php echo $form->label($model_carrera,'Agregar Carrera'); ?>
	      <?php echo $form->dropDownList($model_carrera,'id', $not_carreras); ?>
	  </div>
	  
	<?php 
		}
		
		// El resto de los casos, que corresponde a cualquier empleado registrado en la
		// base de datos, tratando de editar sus propios datos.
		else {
	?>
	
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

	<?php
		}
	?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrar' : 'Guardar'); ?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->