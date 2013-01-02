<div class="row">
	<label for="passwordActual" class="required">
			Matrícula
			<span class="required">*</span>
	</label>
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
	<?php echo $form->dropDownList($model,'idcarrera', getCarreras()); ?>
	<?php echo $form->error($model,'idcarrera'); ?>
</div>

<div class="row">
	<label for="anio_graduado">
		Año de graduado
	</label>
	<?php echo $form->textField($model,'anio_graduado',array('size'=>4,'maxlength'=>4)); ?>
	<?php echo $form->error($model,'anio_graduado'); ?>
</div>

<div class="row">
	<label for="password" class="required">
		Contraseña
		<span class="required">*</span>
	</label>
	<?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45)); ?>
	<?php echo $form->error($model,'password'); ?>
</div>
