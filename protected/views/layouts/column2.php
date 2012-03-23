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
						array('label'=>'Reportar Problemas de Inscripcion', 'url'=>array('solicitudProblemasInscripcion/create')),
						array('label'=>'Ver Reportes de Problemas de Inscripcion', 'url'=>array('solicitudProblemasInscripcion/index')),
						array('label'=>''),
						array('label'=>''),
						array('label'=>'Escolar'),
						array('label'=>'Crear Solicitud de Baja de Materias', 'url'=>array('solicitudBajaMateria/create')),
						array('label'=>'Crear Solicitud de Baja de Semestre', 'url'=>array('solicitudBajaSemestre/create')),
						array('label'=>'Crear Solicitud de Revalidacion de Materias', 'url'=>array('solicitudRevalidacion/create')),
						array('label'=>'Crear Solicitud de Carta de Recomendacion', 'url'=>array('solicitudCartaRecomendacion/create')),
						array('label'=>'Crear Sugerencia', 'url'=>array('sugerencia/create')),
						array('label'=>''),
						array('label'=>''),
						array('label'=>'Ver Todas las Solicitudes', 'url'=>array('solicitud/index')),
						array('label'=>'Ver Solicitudes de Bajas de Materias', 'url'=>array('solicitudBajaMateria/index')),
						array('label'=>'Ver Solicitudes de Bajas de Semestre', 'url'=>array('solicitudBajaSemestre/index')),
						array('label'=>'Ver Solicitudes de Revalidacion de Materias', 'url'=>array('solicitudRevalidacion/index')),
						array('label'=>'Ver Solicitudes de Cartas de Recomendacion', 'url'=>array('solicitudCartaRecomendacion/index')),
						array('label'=>'Ver Sugerencias', 'url'=>array('sugerencia/index')),
					);
				
			//Si es empleado
			}else if (Yii::app()->user->rol == 'Admin'){
			
				$menu = array(

					array('label'=>'General'),
					array('label'=>'Ver Boletines Informativos', 'url'=>array('boletinInformativo/index')),
					array('label'=>'Ver Reportes de Problemas de Inscripcion', 'url'=>array('solicitudProblemasInscripcion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Sugerencias'),
					array('label'=>'Ver Sugerencias', 'url'=>array('sugerencia/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Escolar'),
					array('label'=>'Ver Todas las Solicitudes', 'url'=>array('solicitud/index')),
					array('label'=>'Ver Solicitudes de Bajas de Materias', 'url'=>array('solicitudBajaMateria/index')),
					array('label'=>'Ver Solicitudes de Bajas de Semestre', 'url'=>array('solicitudBajaSemestre/index')),
					array('label'=>'Ver Solicitudes de Cartas de Recomendacion', 'url'=>array('solicitudCartaRecomendacion/index')),
					array('label'=>'Ver Solicitudes de Revalidacion de Materias', 'url'=>array('solicitudRevalidacion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Usuarios'),
					array('label'=>'Registrar Alumno', 'url'=>array('alumno/create')),
					array('label'=>'Registrar Empleado', 'url'=>array('empleado/create')),
					array('label'=>'Registrar Carrera', 'url'=>array('carrera/create')),
					array('label'=>'Ver Alumnos', 'url'=>array('alumno/index')),
					array('label'=>'Ver Empleados', 'url'=>array('empleado/index')),
					array('label'=>'Ver Carreras', 'url'=>array('carrera/index')),
					);
			}else if (Yii::app()->user->rol == 'Director'){
				$menu = array(
					
					array('label'=>'General'),
					array('label'=>'Crear Boletin informativo', 'url'=>array('boletinInformativo/create')),
					array('label'=>'Ver Boletines Informativos', 'url'=>array('boletinInformativo/index')),
					array('label'=>'Ver Reportes de Problemas de Inscripcion', 'url'=>array('solicitudProblemasInscripcion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Sugerencias'),
					array('label'=>'Ver Sugerencias', 'url'=>array('sugerencia/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Escolar'),
					array('label'=>'Ver Todas las Solicitudes', 'url'=>array('solicitud/index')),
					array('label'=>'Ver Solicitudes de Bajas de Materias', 'url'=>array('solicitudBajaMateria/index')),
					array('label'=>'Ver Solicitudes de Bajas de Semestre', 'url'=>array('solicitudBajaSemestre/index')),
					array('label'=>'Ver Solicitudes de Cartas de Recomendacion', 'url'=>array('solicitudCartaRecomendacion/index')),
					array('label'=>'Ver Solicitudes de Revalidacion de Materias', 'url'=>array('solicitudRevalidacion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Usuarios'),
					array('label'=>'Registrar Alumno', 'url'=>array('alumno/create')),
					array('label'=>'Registrar Empleado', 'url'=>array('empleado/create')),
					array('label'=>'Ver Alumnos', 'url'=>array('alumno/index')),
					array('label'=>'Ver Empleados', 'url'=>array('empleado/index')),
					);
			}else if(Yii::app()->user->rol == 'Asistente' || Yii::app()->user->rol == 'Secretaria'){
				$menu = array(
					
					array('label'=>'General'),
					array('label'=>'Ver Reportes de Problemas de Inscripcion', 'url'=>array('solicitudProblemasInscripcion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Sugerencias'),
					array('label'=>'Ver Sugerencias', 'url'=>array('sugerencia/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Escolar'),
					array('label'=>'Ver Solicitudes de Revalidacion de Materias', 'url'=>array('solicitudRevalidacion/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Configurar cuenta', 'url'=>array('empleado/update/'.Yii::app()->user->id)),
					
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