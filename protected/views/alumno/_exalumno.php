<div class="row">
	<?php
	
		// Valida si el modelo es nuevo. En caso de ser así, se
		// despliega un campo de texto para ingresar la matrícula.
		if ($model->isNewRecord){
			echo "<label for=\"passwordActual\" class=\"required\">Matrícula<span class=\"required\">*</span></label>";
			echo $form->textField($model,'matricula',array('size'=>9,'maxlength'=>9));
			echo $form->error($model,'matricula');
		}
	?>
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
	<label for="email" class="required">
		E-mail
		<span class="required">*</span>
	</label>
	<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45)); ?>
	<?php echo $form->error($model,'email'); ?>
</div>

<div class="row">
	<label for="idcarrera" class="required">
			Carrera
			<span class="required">*</span>
	</label>
	
	<?php
		
		// Valida si el usuario actual es un director de carrera.
		if(Yii::app()->user->rol == 'Director'){
			
			// Criterios para obtener todas las carreras en las que labora el
			// director de carrera.
			$criteria = new CDbCriteria(array(
				'join'=>'JOIN carrera_tiene_empleado as c on t.id = c.idcarrera AND c.nomina =\''.Yii::app()->user->id.'\'',
				));
			
			// Obtiene los modelos de las carreras en las que
			// labora el director de carrera.
			$carreras = Carrera::model()->findAll($criteria);
			
			// Enlista a las carreras, de acuerdo con su ID.
			$opciones = CHtml::listData($carreras, 'id', 'siglas');
			
			// Despliega un menú tipo "drop-down" con las carreras en las
			// que labora el director de carrera.
			echo $form->dropDownList($model,'idcarrera', $opciones);
		
		// El resto de los casos, que corresponde a usuarios no autenticados.
		}else{
			
			// Despliega un menú tipo "drop-down" con todas las carreras
			// registradas en la base de datos.
			echo $form->dropDownList($model,'idcarrera', getCarreras());
		}
	?>
	
	<?php echo $form->error($model,'idcarrera'); ?>
</div>

<div class="row">
	<label for="anio_graduado">
		Año de graduado
	</label>
	<?php echo $form->textField($model,'anio_graduado',array('size'=>4,'maxlength'=>4)); ?>
	<?php echo $form->error($model,'anio_graduado'); ?>
</div>

<?php
	
	// Solamente alumnos, administradores generales, directores de carrera y usuarios no autenticados pueden
	// ingresar datos en el campo de la contraseña. Se permite ingresar datos en este campo a usuarios no autenticados,
	// asumiendo que se trata de exalumnos que desean llenar la forma para crear su cuenta en la base de datos.
	if(Yii::app()->user->rol == 'Alumno' || Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Director' || !userTieneRolAsignado()){
		echo "<div class=\"row\">";
		echo "<label for=\"password\" class=\"required\">";
		echo "Contraseña";
		echo "<span class=\"required\">*</span>";
		echo "</label>";
		echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45));
		echo $form->error($model,'password');
		echo "</div>";
	}
?>
