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
			Nómina o nombre de usuario
			<span class="required">*</span>
		</label>
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
		</label>
		<?php

		// Valida si el usuario actual es un director de carrera. En este caso,
		// se enlistan únicamente las carreras en las que él labora.
		if (Yii::app()->user->rol == 'Director'){
			
			// Criterios para obtener las carreras en las que labora el
			// director
			$criteria = new CDbCriteria(array(
			'join'=>'JOIN carrera_tiene_empleado as c on t.id = c.idcarrera AND c.nomina =\''.Yii::app()->user->id.'\'',
			));
			
			// Obtiene los modelos de las carreras en las que
			// labora el director de carrera.
			$carreras = Carrera::model()->findAll($criteria);
					
			// Enlista las siglas de las carreras en las que labora el
			// director, con los respectivos IDs de las carreras.
			$opciones = CHtml::listData($carreras, 'id', 'siglas');
			
			// Despliega un menú tipo 'drop-down', con las siglas de las
			// carreras en las que labora el director.
			echo $form->dropDownList($model_carrera,'id', $opciones);
			
		// Valida si el usuario actual es un administrador general. En este
		// caso se despliegan todas las carreras registradas en la base de datos.
		}else if (Yii::app()->user->rol == 'Admin'){
			
			// Criterios para obtener las siglas de
			// todas las carreras registradas en la
			// base de datos.
			$criteria_carreras= new CDbCriteria(array(
            'select'=>'id, siglas'));
			
			// Obtiene los modelos de todas las carreras registradas en la
			// base de datos.
			$consulta_carreras = Carrera::model()->findAll($criteria_carreras);
			
			// Arreglo para almacenar las siglas de todas las carreras registradas en la
			// base de datos.
			$carreras = array();
			
			// Almacena en el arreglo $carreras las siglas de todas las
			// carreras registradas en la base de datos.
			foreach($consulta_carreras as &$valor){
				$carreras[$valor->id] = $valor->siglas;
			}
			
			// Despliega un menú tipo 'drop-down', con las siglas de
			// todas las carreras registradas en la base de datos.
			echo $form->dropDownList($model_carrera,'id', $carreras); 
		}
		?>
    </div>
    
    <div class="row submit">
        <?php echo CHtml::submitButton('Registrar'); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div><!-- form -->
