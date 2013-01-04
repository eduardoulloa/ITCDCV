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
//Si el usuario es un admin, se le da la opción de administrar las sugerencias.
if(Yii::app()->user->rol == 'Admin'){
	echo CHtml::link("Administrar sugerencias", array('sugerencia/admin'));
}
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 

?>
