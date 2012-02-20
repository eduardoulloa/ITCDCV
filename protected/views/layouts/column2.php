<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="span-19">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
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
						array('label'=>'Reportar Problemas de Inscripcion', 'url'=>array('solicitudProblemasInscripcion/create')),
						array('label'=>'Solicitud de Baja de Materias', 'url'=>array('solicitudBajaMateria/create')),
						array('label'=>'Solicitud de Baja de Semestre', 'url'=>array('solicitudBajaSemestre/create')),
						array('label'=>'Solicitud de Revalidacion', 'url'=>array('solicitudRevalidacion/create')),
						array('label'=>'Carta de Recomendacion', 'url'=>array('solicitudCartaRecomendacion/create')),
						array('label'=>'Sugerencias', 'url'=>array('sugerencia/create')),
					);
				
			//Si es empleado
			}else if (Yii::app()->user->rol == 'Admin'){
			
				$menu = array(
					array('label'=>'Crear alumno', 'url'=>array('alumno/create')),
					array('label'=>'Crear empleado', 'url'=>array('empleado/create')),
					array('label'=>'Crear carrera', 'url'=>array('carrera/create')),
					);
			}else if (Yii::app()->user->rol == 'Director' || Yii::app()->user->rol){
				$menu = array(
					array('label'=>'General'),
					array('label'=>'Boletin informativo', 'url'=>array('boletinInformativo/create')),
					array('label'=>'Problemas de Inscripcion', 'url'=>array('solicitudProblemasInscripcion/index')),
					array('label'=>'Registrar alumno'),
					array('label'=>'Registrar asistente', 'url'=>array('empleado/create')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Sugerencias', 'url'=>array('sugerencia/index')),
					array('label'=>''),
					array('label'=>''),
					array('label'=>'Escolar'),
					array('label'=>'Bajas de materias', 'url'=>array('solicitudBajaMateria/index')),
					array('label'=>'Bajas de semestre', 'url'=>array('solicitudBajaSemestre/index')),
					array('label'=>'Solicitudes de cartas de recomendacion', 'url'=>array('solicitudCartaRecomendacion/index')),
					array('label'=>'Solicitudes de revalidacion de materias', 'url'=>array('solicitudRevalidacion/index')),
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
<?php $this->endContent(); ?>