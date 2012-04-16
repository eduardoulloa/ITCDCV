<?php
$this->breadcrumbs=array(
	'Empleados'=>array('index'),
	$model->nomina=>array('view','id'=>$model->nomina),
	'Update',
);

$this->menu=array(
	array('label'=>'List Empleado', 'url'=>array('index')),
	array('label'=>'Create Empleado', 'url'=>array('create')),
	array('label'=>'View Empleado', 'url'=>array('view', 'id'=>$model->nomina)),
	array('label'=>'Manage Empleado', 'url'=>array('admin')),
);
?>

<h1>Actualizar Empleado <?php echo $model->nomina; ?></h1>

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
        <?php echo $form->label($model,'puesto'); ?>
        <?php echo $form->textField($model,'puesto') ?>
    </div>

    <div class="row">
        <?php echo $form->label($model_carrera,'Carreras:'); ?>
        <?php echo $form->dropDownList($model_carrera,'id', $carreras); ?>
    </div>


    <div class="row">
        <?php echo $form->label($model_carrera,'Agregar Carrera'); ?>
        <?php echo $form->dropDownList($model_carrera,'id', $not_carreras); ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton('Actualizar'); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div><!-- form -->
