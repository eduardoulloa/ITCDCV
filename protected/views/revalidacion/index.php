<?php
$this->breadcrumbs=array(
	'Revalidacions',
);

$this->menu=array(
	array('label'=>'Create Revalidacion', 'url'=>array('create')),
	array('label'=>'Manage Revalidacion', 'url'=>array('admin')),
);
?>

<h1>Historial de revalidaciones</h1>

<?php
// Valida si el usuario no es un alumno. En este caso, se despliega una
// liga para administrar las revalidaciones.
if(Yii::app()->user->rol != 'Alumno'){
	echo CHtml::link("Administrar revalidaciones", array('revalidacion/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
?>
