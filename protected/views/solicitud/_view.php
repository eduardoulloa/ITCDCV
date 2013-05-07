<div class="view <?php echo CHtml::encode($data->status); ?>" >

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('/'.get_class($data)
				.'/view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fechahora); ?>
	<br />

	<?php
	
	// Valida si el usuario actual es un director de carrera o un administrador general. En caso de ser así, se
	// despliega la matrícula del alumno que creó la solicitud.
	if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){
		echo "<b>";
		echo "Matrícula";
		echo ": </b>";
		echo CHtml::encode($data->matriculaalumno);
		echo "<br />";
	} 
		
		?>

	<b><?php echo "Estatus"; ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode('Tipo')?>:</b>
	<?php
		$claseDeSolicitud = get_class($data);
		$label = "";
		switch($claseDeSolicitud){
			case "SolicitudBajaMateria": $label = "Baja de materia"; break;
			case "SolicitudBajaSemestre": $label = "Baja de semestre"; break;
			case "SolicitudCartaRecomendacion": $label = "Carta de recomendación"; break;
			case "SolicitudProblemasInscripcion": $label = "Problemas de inscripción"; break;
			case "SolicitudRevalidacion": $label = "Revalidación de materia"; break;
		}
		echo $label;
	?>
	
	<br />
	
	<?php 
	// Valida si el usuario actual es un director de carrera o un administrador general. En caso de
	// ser así se despliega una liga para editar la solicitud.
	if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){
		echo CHtml::link(CHtml::encode('Editar'), array('/'.get_class($data)
				.'/update', 'id'=>$data->id));
	}
	?>
	
</div>
