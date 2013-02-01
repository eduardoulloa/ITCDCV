<?php
$this->breadcrumbs=array(
	'Revalidacions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Revalidacion', 'url'=>array('index')),
	array('label'=>'Create Revalidacion', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('revalidacion-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Revalidacions</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'revalidacion-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'fechahora',
		'universidad',
		'clave_materia_local',
		'nombre_materia_local',
		'clave_materia_cursada',
		/*
		'nombre_materia_cursada',
		'periodo_de_revalidacion',
		'anio_de_revalidacion',
		'idcarrera',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
