<?php
$this->breadcrumbs=array(
	'Boletin Informativos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List BoletinInformativo', 'url'=>array('index')),
	array('label'=>'Create BoletinInformativo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('boletin-informativo-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar boletines informativos</h1>

<p>
Opcionalmente puede ingresar un operador de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al principio de cada uno de sus valores de búsqueda para especificar cómo se debería realizar la comparación.
</p>

<?php echo CHtml::link('Búsqueda avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'boletin-informativo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'mensaje',
		'fechahora',
		'semestre1',
		'semestre2',
		'semestre3',
		/*
		'semestre4',
		'semestre5',
		'semestre6',
		'semestre7',
		'semestre8',
		'semestre9',
		'exatec',
		'idcarrera',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
