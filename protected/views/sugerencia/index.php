<?php
$this->breadcrumbs=array(
	'Sugerencias',
);

$this->menu=array(
	array('label'=>'Create Sugerencia', 'url'=>array('create')),
	array('label'=>'Manage Sugerencia', 'url'=>array('admin')),
);
?>

<h1>Sugerencias</h1>

<?php
// Valida si el usuario actual no es un alumno. En este caso se despliega una
// liga para administrar las sugerencias.
if(Yii::app()->user->rol != 'Alumno'){
	echo CHtml::link("Administrar sugerencias", array('sugerencia/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 

?>
