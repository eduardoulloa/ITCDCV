<?php
$menu = array(
        array("url" => array( "route" => "site/index"), "label" => "Inicio"),
    );

if(!isset(Yii::app()->user->rol)){
    array_push($menu,
        array("url"=> array( "route" => "site/page?view=about"), "label"=>"Acerca de DCV"),
        array("url"=>array( "route" => "site/crearexalumno"), "label"=>"Registar exalumno")
    );
}
else if(Yii::app()->user->rol == 'Director') {

    array_push($menu,
        array("url"=> "", "label"=>"General",
            array("url" => array( "route" => "boletinInformativo/create"), "label" => "Crear boletín informativo"),
            array("url" => array( "route" => "boletinInformativo/index"), "label" => "Ver boletines informativos"),
            array("url" => array( "route" => "solicitudProblemasInscripcion/index"), "label" => "Ver problemas de inscripción"),
            array("url"=> array( "route" => "empleado/update/".Yii::app()->user->name), "label"=>"Configurar cuenta")
        ),
        array("url"=> array( "route" => "sugerencia/index"), "label"=>"Sugerencias"),
        array("url"=> "", "label"=>"Escolar",
            array("url" => array( "route" => "solicitud/index"), "label" => "Ver solicitudes"),
            array("url" => array( "route" => "solicitudBajaMateria/index"), "label" => "Ver solicitudes de baja de materia"),
            array("url" => array( "route" => "solicitudBajaSemestre/index"), "label" => "Ver solicitudes de baja de semestre"),
            array("url" => array( "route" => "solicitudCartaRecomendacion/index"), "label" => "Ver solicitudes de cartas de recomendación"),
            array("url" => array( "route" => "solicitudRevalidacion/index"), "label" => "Ver solicitudes de revalidación de materia"),
        ),
        array("url"=> array( "route" => "site/page?view=about"), "label"=>"Usuarios",
            array("url" => array( "route" => "alumno/create"), "label" => "Registrar alumno"),
            array("url" => array( "route" => "empleado/create"), "label" => "Registrar empleado"),
			array("url" => array( "route" => "../../../../../altas/registro.php"), "label" => "Registro de alumnos desde Internet"),
            array("url" => array( "route" => "alumno/index"), "label" => "Ver alumnos registrados"),
            array("url" => array( "route" => "empleado/index"), "label" => "Ver empleados registrados"),
        )
    );
}

else if(Yii::app()->user->rol == 'Admin') {

    array_push($menu,
        array("url"=> "", "label"=>"General",
            
            array("url" => array( "route" => "boletinInformativo/index"), "label" => "Ver boletines informativos"),
            array("url" => array( "route" => "solicitudProblemasInscripcion/index"), "label" => "Ver problemas de inscripción"),
            array("url"=> array( "route" => "admin/update/".Yii::app()->user->name), "label"=>"Configurar cuenta")
        ),
        array("url"=> array( "route" => "sugerencia/index"), "label"=>"Sugerencias"),
        array("url"=> "", "label"=>"Escolar",
            array("url" => array( "route" => "solicitud/index"), "label" => "Ver todas las solicitudes"),
            array("url" => array( "route" => "solicitudBajaMateria/index"), "label" => "Ver solicitudes de baja de materia"),
            array("url" => array( "route" => "solicitudBajaSemestre/index"), "label" => "Ver solicitudes de baja de semestre"),
            array("url" => array( "route" => "solicitudCartaRecomendacion/index"), "label" => "Ver solicitudes de cartas de recomendación"),
            array("url" => array( "route" => "solicitudRevalidacion/index"), "label" => "Ver solicitudes de revalidación de materia"),
        ),
        array("url"=> array( "route" => "site/page?view=about"), "label"=>"Usuarios",
            array("url" => array( "route" => "alumno/create"), "label" => "Registrar alumno"),
            array("url" => array( "route" => "empleado/create"), "label" => "Registrar empleado"),
			array("url" => array( "route" => "../../../../../altas/registro.php"), "label" => "Registro de alumnos desde Internet"),
            array("url" => array( "route" => "alumno/index"), "label" => "Ver alumnos registrados"),
            array("url" => array( "route" => "empleado/index"), "label" => "Ver empleados registrados"),
        )
    );
}

else if(Yii::app()->user->rol == 'Asistente'){
    array_push($menu,
        array("url"=> "", "label"=>"General",
            array("url" => array( "route" => "solicitudProblemasInscripcion/index"), "label" => "Ver problemas de inscripción"),
        ),
        array("url"=> array( "route" => "sugerencia/index"), "label"=>"Sugerencias"),
        array("url"=> "", "label"=>"Escolar",
            array("url" => array( "route" => "solicitudRevalidacion/index"), "label" => "Ver solicitudes de revalidación de materia"),
        ),
        array("url"=> array( "route" => "site/page?view=about"), "label"=>"Usuarios",
            array("url" => array( "route" => "empleado/update/".Yii::app()->user->name), "label" => "Configurar cuenta"),
			array("url" => array( "route" => "../../../../../altas/registro.php"), "label" => "Registro de alumnos desde Internet"),
        )
    );
}

else if(Yii::app()->user->rol == 'Alumno'){
    array_push($menu,
        array("url"=> "", "label"=>"General",
            array("url" => array( "route" => "solicitudProblemasInscripcion/create"), "label" => "Reportar problemas de inscripción"),
            array("url" => array( "route" => "solicitudProblemasInscripcion/index"), "label" => "Ver problemas de inscripción"),
        ),
        array("url"=> "", "label"=>"Sugerencias",
            array("url"=> array( "route" => "sugerencia/index"), "label"=>"Ver sugerencias"),
            array("url"=> array( "route" => "sugerencia/create"), "label"=>"Crear sugerencias"),
        ),
        array("url"=> "", "label"=>"Escolar",
            array("url" => "", "label" => "Crear",
                array("url" => array( "route" => "solicitudBajaMateria/create"), "label" => "Solicitud de baja de materia"),
                array("url" => array( "route" => "solicitudBajaSemestre/create"), "label" => "Solicitud de baja de semestre "),
                array("url" => array( "route" => "solicitudRevalidacion/create"), "label" => "Solicitud de revalidación de materia"),
                array("url" => array( "route" => "solicitudCartaRecomendacion/create"), "label" => "Solicitud de carta de recomendación"),
            ),
            array("url" => "", "label" => "Ver",
                array("url" => array( "route" => "solicitud/index"), "label" => "Todas las solicitudes"),
                array("url" => array( "route" => "solicitudBajaMateria/index"), "label" => "Solicitudes de baja de materia"),
                array("url" => array( "route" => "solicitudBajaSemestre/index"), "label" => "Solicitudes de baja de semestre"),
                array("url" => array( "route" => "solicitudRevalidacion/index"), "label" => "Solicitudes de revalidación de materia"),
                array("url" => array( "route" => "solicitudCartaRecomendacion/index"), "label" => "Solicitudes de cartas de recomendación"),
            )
        ),
        array("url" => array( "route" => "alumno/update/".Yii::app()->user->name), "label" => "Configurar cuenta")
    );
}
    
if(isset(Yii::app()->user->rol) && Yii::app()->user->rol == 'Admin') {

    // Es 3 porque esa es la posición de la categoría escolar
    array_push($menu[3],
        array("url" => array( "route" => "carrera/index"), "label" => "Ver carreras registradas"),
        array("url" => array( "route" => "carrera/create"), "label" => "Registar carrera")
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
