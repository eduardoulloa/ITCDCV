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
//Si el usuario es un admin, se le da la opción de administrar los empleados.
if(Yii::app()->user->rol == 'Admin'){
	echo CHtml::link("Administrar empleados", array('empleado/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));?>
