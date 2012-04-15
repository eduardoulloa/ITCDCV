<?php
$menu = array(
        array("url" => array( "route" => "site/index"), "label" => "Inicio"),
    );

if(!isset(Yii::app()->user->rol)){
    array_push($menu,
        array("url"=> array( "route" => "site/page?view=about"), "label"=>"Acerca de DCV"),
        array("url"=>array( "route" => "site/contact"), "label"=>"Contacto"),
        array("url"=>array( "route" => "alumno/crearexalumno"), "label"=>"Registar Exalumno")
    );
}
else if(Yii::app()->user->rol == 'Admin' || Yii::app()->user->rol == 'Director') {

    array_push($menu,
        array("url"=> "", "label"=>"General",
            array("url" => array( "route" => "boletinInformativo/create"), "label" => "Crear Boletin Informativo"),
            array("url" => array( "route" => "boletinInformativo/index"), "label" => "Ver Boletines Informativos"),
            array("url" => array( "route" => "solicitudProblemasInscripcion/index"), "label" => "Problemas Inscripcion"),
        ),
        array("url"=> array( "route" => "sugerencia/index"), "label"=>"Sugerencias"),
        array("url"=> "", "label"=>"Escolar",
            array("url" => array( "route" => "solicitud/index"), "label" => "Ver Solicitudes"),
            array("url" => array( "route" => "solicitudBajaMateria/index"), "label" => "Solicitudes Baja Materias"),
            array("url" => array( "route" => "solicitudBajaSemestre/index"), "label" => "Solicitudes Baja Semestre"),
            array("url" => array( "route" => "solicitudCartaRecomendacion/index"), "label" => "Solicitudes Cartas Recomendacion"),
            array("url" => array( "route" => "solicitudRevalidacion/index"), "label" => "Solicitudes Revalidacion Materias"),
        ),
        array("url"=> array( "route" => "site/page?view=about"), "label"=>"Usuarios",
            array("url" => array( "route" => "alumno/create"), "label" => "Registrar Alumno"),
            array("url" => array( "route" => "empleado/create"), "label" => "Registrar Empleado"),
            array("url" => array( "route" => "carrera/create"), "label" => "Registrar Carrera"),
            array("url" => array( "route" => "alumno/index"), "label" => "Ver Alumnos"),
            array("url" => array( "route" => "empleado/index"), "label" => "Ver Empleados"),
            array("url" => array( "route" => "carrera/index"), "label" => "Ver Carreras")
        )
    );

}
else if(Yii::app()->user->rol == 'Asistente'){
    array_push($menu,
        array("url"=> "", "label"=>"General",
            array("url" => array( "route" => "solicitudProblemasInscripcion/index"), "label" => "Problemas Inscripcion"),
        ),
        array("url"=> array( "route" => "sugerencia/index"), "label"=>"Sugerencias"),
        array("url"=> "", "label"=>"Escolar",
            array("url" => array( "route" => "solicitudRevalidacion/index"), "label" => "Solicitudes Revalidacion Materias"),
        ),
        array("url"=> array( "route" => "site/page?view=about"), "label"=>"Usuarios",
            array("url" => array( "route" => "empleado/update/".Yii::app()->user->name), "label" => "Configurar Cuenta")
        )
    );
}

else if(Yii::app()->user->rol == 'Alumno'){
    array_push($menu,
        array("url"=> "", "label"=>"General",
            array("url" => array( "route" => "solicitudProblemasInscripcion/create"), "label" => "Reportar problemas de inscripcion"),
            array("url" => array( "route" => "solicitudProblemasInscripcion/index"), "label" => "Ver Problemas de Inscripcion"),
        ),
        array("url"=> "", "label"=>"Sugerencias",
            array("url"=> array( "route" => "sugerencia/index"), "label"=>"Ver sugerencias"),
            array("url"=> array( "route" => "sugerencia/index"), "label"=>"Crear sugerencias"),
        ),
        array("url"=> "", "label"=>"Escolar",
            array("url" => "", "label" => "Crear",
                array("url" => array( "route" => "solicitudBajaMateria/create"), "label" => "Solicitud Baja Materia"),
                array("url" => array( "route" => "solicitudBajaSemestre/create"), "label" => "Solicitud Baja de Semestre "),
                array("url" => array( "route" => "solicitudRevalidacion/create"), "label" => "Solicitud Revalidación Materias"),
                array("url" => array( "route" => "solicitudCartaRecomendacion/create"), "label" => "Solicitud de Carta Recomendación"),
            ),
            array("url" => "", "label" => "Ver",
                array("url" => array( "route" => "solicitud/index"), "label" => "Todas las solicitudes"),
                array("url" => array( "route" => "solicitudBajaMateria/index"), "label" => "Solicitudes de Baja Materias"),
                array("url" => array( "route" => "solicitudBajaSemestre/index"), "label" => "Solicitudes de Baja de Semestre"),
                array("url" => array( "route" => "solicitudRevalidacion/index"), "label" => "Solicitudes de Revalidación de Materias"),
                array("url" => array( "route" => "solicitudCartaRecomendacion/index"), "label" => "Solicitudes de Cartas de Recomendacion"),
            )
        ),
        array("url" => array( "route" => "alumno/update/".Yii::app()->user->name), "label" => "Configurar Cuenta")
    );
}
    
array_push($menu,
    array('label'=>'Entrar', 'url'=>array("route" => '/site/login'), 'visible'=>Yii::app()->user->isGuest),
    array('label'=>'Salir ('.Yii::app()->user->name.')', 'url'=>array( "route" => '/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
);

$this->widget('application.extensions.menu.SMenu',
    array(
        "menu"=> $menu,
        "stylesheet"=>"menu_custom.css",
        "menuID"=>"menuBar",
        "delay"=>3
    )
);
?>
