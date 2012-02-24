<?php
$this->breadcrumbs=array(
	'Empleados'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'List Empleado', 'url'=>array('index')),
	array('label'=>'Manage Empleado', 'url'=>array('admin')),
);
?>

<h1>Crear Empleado</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm'); ?>
 
    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php echo $form->label($model,'nomina'); ?>
        <?php echo $form->textField($model,'nomina') ?>
    </div>
 
    <div class="row">
        <?php echo $form->label($model,'nombre'); ?>
        <?php echo $form->textField($model,'nombre') ?>
    </div>
    <div class="row">
        <?php echo $form->label($model,'apellido_paterno'); ?>
        <?php echo $form->textField($model,'apellido_paterno') ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'apellido_materno'); ?>
        <?php echo $form->textField($model,'apellido_materno') ?>
    </div>
 
    <div class="row">
        <?php echo $form->label($model,'password'); ?>
        <?php echo $form->passwordField($model,'password') ?>
    </div>
 
    <div class="row">
        <?php echo $form->label($model,'puesto'); ?>
        <?php echo $form->textField($model,'puesto') ?>
    </div>

    <div class="row">
        <?php echo $form->label($model_carrera,'carrera'); ?>
        <?php echo $form->dropDownList($model_carrera,'id', $carreras); ?>
    </div>
    
    
 
    <div class="row submit">
        <?php echo CHtml::submitButton('Crear'); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div><!-- form -->
