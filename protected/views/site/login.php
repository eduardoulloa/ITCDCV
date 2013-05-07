<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);

?>

<h1>Inicio de sesión</h1>

<p>Por favor proporciona tus credenciales para iniciar tu sesión:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Los campos con<span class="required">*</span> son requeridos.</p>

	<div class="row">
		<label for="username" class="required">
				Nombre de usuario
				<span class="required">*</span>
		</label>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
	
	
	<div class="row">
		<label for="password" class="required">
				Contraseña
				<span class="required">*</span>
		</label>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		
		<!--
		<p class="hint">
			Hint: You may login with <tt>demo/demo</tt> or <tt>admin/admin</tt>.
		</p>
		-->
		
	</div>
	

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		
		<label for="rememberMe">
				Recordarme la próxima vez que inicie mi sesión		
		</label>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Iniciar sesión'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
