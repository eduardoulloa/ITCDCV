<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('matricula')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->matricula), array('view', 'id'=>$data->matricula)); ?>
	<?php
		
		/*
		$uname = '';
		$serv = '';
		
		$arreglo = explode('@', $data->matricula);
		if(count($arreglo)>1){
			$uname = $arreglo[0];
			$arreglo2 = explode('.', $arreglo[1]);
			if(!empty($arreglo2)){
				$serv = $arreglo2[0];
			}
		}
		
		if((!empty($uname)) && (!empty($serv))){
			echo($uname." ".$serv);
		}*/
		
	?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apellido_paterno')); ?>:</b>
	<?php echo CHtml::encode($data->apellido_paterno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apellido_materno')); ?>:</b>
	<?php echo CHtml::encode($data->apellido_materno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('plan')); ?>:</b>
	<?php echo CHtml::encode($data->plan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre')); ?>:</b>
	<?php echo CHtml::encode($data->semestre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />
	
	<?php
		if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){
			echo CHtml::link('Editar', array('update', 'id'=>$data->matricula));
		}
	?>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('anio_graduado')); ?>:</b>
	<?php echo CHtml::encode($data->anio_graduado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idcarrera')); ?>:</b>
	<?php echo CHtml::encode($data->idcarrera); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	*/ ?>

</div>