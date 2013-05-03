<?php
$this->breadcrumbs=array(
	'Empleados',
);

$this->menu=array(
	array('label'=>'Create Empleado', 'url'=>array('create')),
	array('label'=>'Manage Empleado', 'url'=>array('admin')),
);
?>

<h1>Empleados</h1>

<?php
// Valida si el usuario actual es un administrador general o un director de
// carrera. En este caso se le da la opción de administrar los empleados.
if(Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Director'){
	
	// Se despliega la liga para administrar los empleados.
	echo CHtml::link("Administrar empleados", array('empleado/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));?>
