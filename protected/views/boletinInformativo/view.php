<?php
$this->breadcrumbs=array(
	'Boletin Informativos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BoletinInformativo', 'url'=>array('index')),
	array('label'=>'Create BoletinInformativo', 'url'=>array('create')),
	array('label'=>'Update BoletinInformativo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BoletinInformativo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BoletinInformativo', 'url'=>array('admin')),
);
?>

<h1>Ver boletín informativo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'subject',
		'mensaje',
		'fechahora',
		'semestre1',
		'semestre2',
		'semestre3',
		'semestre4',
		'semestre5',
		'semestre6',
		'semestre7',
		'semestre8',
		'semestre9',
		'exatec',
		'idcarrera',
	),
)); ?>
