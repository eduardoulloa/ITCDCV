<?php
$this->breadcrumbs=array(
	'Solicitudes',
);?>
<h1><?php echo 'Solicitudes'; ?></h1>

<?php 
if ($model != NULL) {
	$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$model,
				'itemView'=>'_view',
				)); 
} else {
	echo 'No tienes solicitudes';
}

?>
