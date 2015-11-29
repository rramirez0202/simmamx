<?php
$config["helpItems"] = array(
	"config" => array(),
	"generalidades"	=> array(
	    "config" => array(
	    	"breadcumbs"		=> array(
										array("label" => "SIMA - Control de Manifiestos"			, "href" => "ayuda"													),
									),
			"title"				=> "Generalidades",
			"prev"				=> null,
			"next"	 			=> array("label" => "Acceso"										, "href" => "ayuda/acceso"											),
			"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
			"imagen"			=> "project_files/img/ayuda/generalidades.jpg"
	    	)
		),
	"acceso"		=> array(
	    "config" => array(
	    	"breadcumbs"		=> array(
										array("label" => "SIMA - Control de Manifiestos"			, "href" => "ayuda"													),
									),
			"title"				=> "Acceso",
			"prev"				=> array("label" => "Generalidades"									, "href" => "ayuda/generalidades"									),
			"next"	 			=> array("label" => "Operación"										, "href" => "ayuda/operacion"										),
			"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
			"imagen"			=> "project_files/img/ayuda/acceso.jpg"
	    	)
		),
	"operacion"		=> array(
	    "config" => array(
	    	"breadcumbs"		=> array(
										array("label" => "SIMA - Control de Manifiestos"			, "href" => "ayuda"													),
									),
			"title"				=> "Operación",
			"prev"				=> array("label" => "Acceso"										, "href" => "ayuda/acceso"											),
			"next"	 			=> array("label" => "Administración"								, "href" => "ayuda/administracion"									),
			"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
			"imagen"			=> "project_files/img/ayuda/operacion.jpg"
	    	)
		),
	"administracion"	=> array(
	    "config" => array(
	    	"breadcumbs"		=> array(
										array("label" => "SIMA - Control de Manifiestos"			, "href" => "ayuda"													),
									),
			"title"				=> "Administración",
			"prev"				=> array("label" => "Operación"										, "href" => "ayuda/operacion"										),
			"next"	 			=> array("label" => "Configuración"									, "href" => "ayuda/configuracion"									),
			"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
			"imagen"			=> "project_files/img/ayuda/administracion.jpg"
	    	)
		),
	"configuracion"		=> array(
	    "config" => array(
	    	"breadcumbs"		=> array(
										array("label" => "SIMA - Control de Manifiestos"			, "href" => "ayuda"													),
									),
			"title"				=> "Configuración",
			"prev"				=> array("label" => "Administración"								, "href" => "ayuda/administracion"									),
			"next"	 			=> null,
			"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
			"imagen"			=> "project_files/img/ayuda/configuracion.jpg"
	    	),
		"usuarios"	=> array(
		    "config" => array(
	    		"breadcumbs"		=> array(
											array("label" => "SIMA - Control de Manifiestos"		, "href" => "ayuda"													),
											array("label" => "Configuración"						, "href" => "ayuda/configuracion"									),
										),
				"title"				=> "Usuarios",
				"prev"				=> null,
				"next"	 			=> array("label" => "Permisos"									, "href" => "ayuda/configuracion/permisos"							),
				"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
				"imagen"			=> ""
	    		)
			),
		"permisos"	=> array(
		    "config" => array(
	    		"breadcumbs"		=> array(
											array("label" => "SIMA - Control de Manifiestos"		, "href" => "ayuda"													),
											array("label" => "Configuración"						, "href" => "ayuda/configuracion"									),
										),
				"title"				=> "Permisos",
				"prev"				=> array("label" => "Usuarios"									, "href" => "ayuda/configuracion/usuarios"							),
				"next"	 			=> array("label" => "Perfiles"									, "href" => "ayuda/configuracion/perfiles"							),
				"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
				"imagen"			=> ""
	    		)
			),
		"perfiles"	=> array(
		    "config" => array(
	    		"breadcumbs"		=> array(
											array("label" => "SIMA - Control de Manifiestos"		, "href" => "ayuda"													),
											array("label" => "Configuración"						, "href" => "ayuda/configuracion"									),
										),
				"title"				=> "Perfiles",
				"prev"				=> array("label" => "Permisos"									, "href" => "ayuda/configuracion/permisos"							),
				"next"	 			=> array("label" => "Catálogos"									, "href" => "ayuda/configuracion/catalogos"							),
				"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
				"imagen"			=> ""
	    		)
			),
		"catalogos"	=> array(
			"config" => array(
				"breadcumbs"		=> array(
											array("label" => "SIMA - Control de Manifiestos"		, "href" => "ayuda"													),
											array("label" => "Configuración"						, "href" => "ayuda/configuracion"									),
										),
				"title"				=> "Catálogos",
				"prev"				=> array("label" => "Perfiles"									, "href" => "ayuda/configuracion/perfiles"							),
				"next"	 			=> null,
				"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
				"imagen"			=> "project_files/img/ayuda/catalogos.jpg"
				),
			"nuevo"	=> array(
				"config" => array(
					"breadcumbs"		=> array(
												array("label" => "SIMA - Control de Manifiestos"	, "href" => "ayuda"													),
												array("label" => "Configuración"					, "href" => "ayuda/configuracion"									),
												array("label" => "Catálogos"						, "href" => "ayuda/configuracion/catalogos"							),
											),
					"title"				=> "Crear un Nuevo Catálogo",
					"prev"				=> null,
					"next"	 			=> array("label" => "Ver un Catálogo"						, "href" => "ayuda/configuracion/catalogos/ver"	),
					"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
					"imagen"			=> ""
					)
				),
			"ver"	=> array(
				"config" 			=> array(
					"breadcumbs"		=> array(
											array("label"=> "SIMA - Control de Manifiestos"			,"href"=> "ayuda"													),
											array("label"=> "Configuración"							,"href"=> "ayuda/configuracion"										),
											array("label"=> "Catálogos"								,"href"=> "ayuda/configuracion/catalogos"							),
										),
					"title"				=> "Ver un Catálogo",
					"prev"				=> array("label"=> "Crear un Nuevo Catálogo"				,"href"=> "ayuda/configuracion/catalogos/nuevo"						),
					"next"				=> null,
					"video_url"			=> "https://www.youtube.com/embed/75FFRL-3N4Q",
					"imagen"			=> "project_files/img/ayuda/ver_catalogo.jpg"
					),
				"actualizar"		=> array(
					"config" => array(
						"breadcumbs"		=> array(
												array("label" => "SIMA - Control de Manifiestos"	, "href" => "ayuda"													),
												array("label" => "Configuración"					, "href" => "ayuda/configuracion"									),
												array("label" => "Catálogos"						, "href" => "ayuda/configuracion/catalogos"							),
												array("label" => "Ver un Catálogo"					, "href" => "ayuda/configuracion/catalogos/ver"						)
												),
						"title"				=> "Actualizar un Catálogo",
						"prev"				=> null,
						"next"	 			=> array("label" => "Agregar Opciones a un Catálogo"	, "href" => "ayuda/configuracion/catalogos/ver/agregaropciones"		),
						"video_url"			=> "https://www.youtube.com/embed/GtklOKkEH1M",
						"imagen"			=> ""
						)
					),
				"agregaropciones"	=> array(
					"config" => array(
					    "breadcumbs"		=> array(
												array("label" => "SIMA - Control de Manifiestos"	, "href" => "ayuda"													),
												array("label" => "Configuración"					, "href" => "ayuda/configuracion"									),
												array("label" => "Catálogos"						, "href" => "ayuda/configuracion/catalogos"							),
												array("label" => "Ver un Catálogo"					, "href" => "ayuda/configuracion/catalogos/ver"						)
												),
						"title"				=> "Agregar Opciones a un Catálogo",
						"prev"				=> array("label" => "Actualizar un Catálogo"			, "href" => "ayuda/configuracion/catalogos/ver/actualizar"			),
						"next"	 			=> array("label" => "Eliminar Opciones de un Catálogo"	, "href" => "ayuda/configuracion/catalogos/ver/eliminaropciones"	),
						"video_url"			=> "https://www.youtube.com/embed/5xhz-rrIKhw",
						"imagen"			=> ""
						)
					),
				"eliminaropciones"	=> array(
					"config" => array(
						"breadcumbs"		=> array(
												array("label" => "SIMA - Control de Manifiestos"	, "href" => "ayuda"													),
												array("label" => "Configuración"					, "href" => "ayuda/configuracion"									),
												array("label" => "Catálogos"						, "href" => "ayuda/configuracion/catalogos"							),
												array("label" => "Ver un Catálogo"					, "href" => "ayuda/configuracion/catalogos/ver"						)
												),
						"title"				=> "Eliminar Opciones de un Catálogo",
						"prev"				=> array("label"=> "Agregar Opciones a un Catálogo"		, "href"=> "ayuda/configuracion/catalogos/ver/agregaropciones"		),
						"next"				=>null,
						"video_url"			=> "https://www.youtube.com/embed/GtklOKkEH1M",
						"imagen"			=> ""
						)
					),
				)
			)
		)
);
?>