<?php $this->beginContent('//layouts/main'); ?>

<div class="container">
	<div class="span-19">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<?php
		if(isset(Yii::app()->user->rol)) {
	?>
	<div class="span-5 last">
		<div id="sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Opciones',
			));
			
			//Arreglo vacio, para las opciones del menu
			$menu_alumno = array();
			
			//Dependiendo de su rol, el menu se llena con las opciones del usuario
			
			//Si es alumno
			if (Yii::app()->user->rol == 'Alumno'){
				$menu = array(
						array('label'=>'General'),
						array('label'=>'Reportar problemas de inscripción', 'url'=>array('solicitudProblemasInscripcion/create')),
						array('label'=>'Ver reportes de problemas de inscripción', 'url'=>array('solicitudProblemasInscripcion/index')),
						array('label'=>''),
						array('label'=>''),
						array('label'=>'Escolar'),
						array('label'=>'Crear solicitud de baja de materia', 'url'=>array('solicitudBajaMateria/create')),
						array('label'=>'Crear solicitud de baja de semestre', 'url'=>array('solicitudBajaSemestre/create')),
						array('label'=>'Crear solicitud de revalidación de materia', 'url'=>array('solicitudRevalidacion/create')),
						array('label'=>'Crear solicitud de carta de recomendación', 'url'=>array('solicitudCartaRecomendacion/create')),
						array('label'=>'Crear sugerencia', 'url'=>array('sugerencia/create')),
						array('label'=>''),
						array('label'=>''),
						array('label'=>'Ver todas las solicitudes', 'url'=>array('solicitud/index')),
						array('label'=>'Ver solicitudes de baja de materia', 'url'=>array('solicitudBajaMateria/index')),
						array('label'=>'Ver solicitudes de baja de semestre', 'url'=>array('solicitudBajaSemestre/index')),
						array('label'=>'Ver solicitudes de revalidación de materia', 'url'=>array('solicitudRevalidacion/index')),
						array('label'=>'Ver revalidaciones autorizadas en tu carrera', 'url'=>array('revalidacion/index')),
						array('label'=>'Ver solicitudes de carta de recomendación', 'url'=>array('solicitudCartaRecomendacion/index')),
						array('label'=>'Ver sugerencias', 'url'=>array('sugerencia/index')),
					);
				
			//Si es empleado
			}else if (Yii::app()->user->rol == 'Admin'){
			
				$menu = array(
					array('label'=>'General'),
					array('label'=>'Ver boletines informativos', 'url'=>array('boletinInformativo/index')),
					array('label'=>'Ver reportes de problemas de inscripción', 'url'=>array('solicitudProblemasInscripcion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Sugerencias'),
					array('label'=>'Ver sugerencias', 'url'=>array('sugerencia/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Escolar'),
					array('label'=>'Ver todas las solicitudes', 'url'=>array('solicitud/index')),
					array('label'=>'Ver solicitudes de baja de materia', 'url'=>array('solicitudBajaMateria/index')),
					array('label'=>'Ver solicitudes de baja de semestre', 'url'=>array('solicitudBajaSemestre/index')),
					array('label'=>'Ver solicitudes de carta de recomendación', 'url'=>array('solicitudCartaRecomendacion/index')),
					array('label'=>'Registrar revalidaciones autorizadas', 'url'=>array('../../../../../altas/revalidaciones.php')),
					array('label'=>'Ver revalidaciones autorizadas', 'url'=>array('revalidacion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Usuarios'),
					array('label'=>'Registrar alumno', 'url'=>array('alumno/create')),
					array('label'=>'Registrar alumnos desde Internet', 'url'=>array("../../../../../altas/registro.php")),
					array('label'=>'Registrar empleado', 'url'=>array('empleado/create')),
					array('label'=>'Registrar carrera', 'url'=>array('carrera/create')),
					array('label'=>'Ver alumnos registrados', 'url'=>array('alumno/index')),
					array('label'=>'Ver empleados registrados', 'url'=>array('empleado/index')),
					array('label'=>'Ver carreras registradas', 'url'=>array('carrera/index')),
					);
			}else if (Yii::app()->user->rol == 'Director'){
				$menu = array(
					array('label'=>'General'),
					array('label'=>'Crear boletín informativo', 'url'=>array('boletinInformativo/create')),
					array('label'=>'Ver boletines informativos', 'url'=>array('boletinInformativo/index')),
					array('label'=>'Ver reportes de problemas de inscripción', 'url'=>array('solicitudProblemasInscripcion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>''),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Sugerencias'),
					array('label'=>'Ver sugerencias', 'url'=>array('sugerencia/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>''),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Escolar'),
					array('label'=>'Ver todas las solicitudes', 'url'=>array('solicitud/index')),
					array('label'=>'Ver solicitudes de baja de materia', 'url'=>array('solicitudBajaMateria/index')),
					array('label'=>'Ver solicitudes de baja de semestre', 'url'=>array('solicitudBajaSemestre/index')),
					array('label'=>'Ver solicitudes de carta de recomendación', 'url'=>array('solicitudCartaRecomendacion/index')),
					array('label'=>'Ver solicitudes de revalidación de materia', 'url'=>array('solicitudRevalidacion/index')),
					array('label'=>'Registrar revalidaciones autorizadas', 'url'=>array('../../../../../altas/revalidaciones.php')),
					array('label'=>'Ver revalidaciones autorizadas en sus carreras', 'url'=>array('revalidacion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>''),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Usuarios'),
					array('label'=>'Registrar alumno', 'url'=>array('alumno/create')),
					array('label'=>'Registrar empleado', 'url'=>array('empleado/create')),
					array('label'=>'Registrar alumnos desde Internet', 'url'=>array("../../../../../altas/registro.php")),
					array('label'=>'Ver alumnos', 'url'=>array('alumno/index')),
					array('label'=>'Ver empleados', 'url'=>array('empleado/index')),
					);
			}else if(Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria'){
				$menu = array(
					
					array('label'=>'General'),
					array('label'=>'Ver reportes de problemas de inscripción', 'url'=>array('solicitudProblemasInscripcion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Sugerencias'),
					array('label'=>'Ver sugerencias', 'url'=>array('sugerencia/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Escolar'),
					array('label'=>'Ver solicitudes de revalidación de materia', 'url'=>array('solicitudRevalidacion/index')),
					array('label'=>'Registrar revalidaciones autorizadas', 'url'=>array('../../../../../altas/revalidaciones.php')),
					array('label'=>'Ver revalidaciones autorizadas en sus carreras', 'url'=>array('revalidacion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Usuarios'),
					array('label'=>'Configurar cuenta', 'url'=>array('empleado/update/'.Yii::app()->user->id)),
					array('label'=>'Registrar alumnos desde Internet', 'url'=>array("../../../../../altas/registro.php")),					
					);
			}
			
			$this->widget('zii.widgets.CMenu', array(
				'items'=> $menu
				//'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
		</div><!-- sidebar -->
	</div>
</div>
<?php
	}
?>
<?php $this->endContent(); ?>