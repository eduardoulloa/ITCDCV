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

<h1>Registrar empleado</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm'); ?>
 
    <?php echo $form->errorSummary($model); ?>
    <div class="row">
		<label for="nomina" class="required">
			Nómina o matrícula
			<span class="required">*</span>
		</label>
        <?php /*echo $form->label($model,'nomina'); */?>
        <?php echo $form->textField($model,'nomina') ?>
    </div>
 
    <div class="row">
		
		<label for="nombre" class="required">
			Nombre
			<span class="required">*</span>
		</label>
	
        
        <?php echo $form->textField($model,'nombre') ?>
    </div>
    <div class="row">
	
		<label for="apellido_paterno" class="required">
			Apellido paterno
			<span class="required">*</span>
		</label>
        
        <?php echo $form->textField($model,'apellido_paterno') ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'apellido_materno'); ?>
        <?php echo $form->textField($model,'apellido_materno') ?>
    </div>
 
    <div class="row">
        <label for="password" class="required">
			Contraseña
			<span class="required">*</span>
		</label>
        <?php echo $form->passwordField($model,'password') ?>
    </div>
 
    <div class="row">
        
		<label for="puesto" class="required">
			Puesto
			<span class="required">*</span>
		</label>
		
        <?php echo $form->textField($model,'puesto') ?>
    </div>

    <div class="row">
		<label for="id" class="required">
			Carrera
			<span class="required">*</span>
        <?php /*echo $form->label($model_carrera,'carrera');*/ ?>
		</label>
		<?php
		//Si es un director, se enlistan unicamente las carreras en las que él labora.
		if (Yii::app()->user->rol == 'Director'){
			$criteria = new CDbCriteria(array(
			'join'=>'JOIN carrera_tiene_empleado as c on t.id = c.idcarrera AND c.nomina =\''.Yii::app()->user->id.'\'',
			));
		
			$carreras = Carrera::model()->findAll($criteria);
					
			$opciones = CHtml::listData($carreras, 'id', 'siglas');
			
			echo $form->dropDownList($model_carrera,'id', $opciones);
			
		//Si es un admin, se enlistan todas las carreras registradas en el DCV.
		}else if (Yii::app()->user->rol == 'Admin'){
		
			$criteria_carreras= new CDbCriteria(array(
            'select'=>'id, siglas'));

			$consulta_carreras = Carrera::model()->findAll($criteria_carreras);

			$carreras = array();

			foreach($consulta_carreras as &$valor){
				$carreras[$valor->id] = $valor->siglas;
			}
			
			echo $form->dropDownList($model_carrera,'id', $carreras); 
		}
		?>
    </div>
    
    <div class="row submit">
        <?php echo CHtml::submitButton('Registrar'); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div><!-- form -->
