<?php
$this->breadcrumbs=array(
	'Alumnos',
);

$this->menu=array(
	array('label'=>'Create Alumno', 'url'=>array('create')),
	array('label'=>'Manage Alumno', 'url'=>array('admin')),
);
?>

<h1>Alumnos</h1>

<?php

// Valida si el usuario actual es un administrador general o un director de
// carrera. En este caso se despliega en la parte superior de la página una liga para
// administrar a los alumnos y exalumnos.
if(Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Director'){
	echo CHtml::link("Administrar alumnos", array('alumno/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
