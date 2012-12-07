<div class="view <?php echo CHtml::encode($data->status); ?>" >

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('/'.get_class($data)
				.'/view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fechahora); ?>
	<br />

	<?php
	
	if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){ //si el usuario es director de carrera debe ver tambien la matricula del alumno
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
	<?php /*echo CHtml::encode(get_class($data));*/
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
	
	<!-- fue modificada la condicion para que los alumnos no puedan hacer updates de sus solicitudes.
	a continuacion se muestra como originalmente estaba la solicitud-->
	<?php /*if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Alumno'){
		echo CHtml::link(CHtml::encode('Editar'), array('/'.get_class($data)
				.'/update', 'id'=>$data->id));
	}*/
	?>
	
	<?php if(Yii::app()->user->rol == 'Director' || Yii::app()->user->rol == 'Admin'){
		echo CHtml::link(CHtml::encode('Editar'), array('/'.get_class($data)
				.'/update', 'id'=>$data->id));
	}
	?>
	
	<?php
	
	/*if (Yii::app()->user->rol == 'Alumno'){
		echo(" ");
		echo CHtml::link(CHtml::encode('Eliminar'), array('/'.get_class($data)
				.'/delete', 'id'=>$data->id));
		
		} */
		
		?>

</div>
