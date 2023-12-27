<?php

class _Publicador extends Controller {

    private $utilerias, 
            $dataValidate;

    private $modelPublicador;

    /**
     * Publicador data.
     *
     * @var array
     */
    protected $data = array(
        "id_publicador"    => 0,
        "id_congregacion"  => 0,
        "codigo_tipo"      => "",
        "fecha_bautismo"   => "",
        "nombre"           => "",
        "apellido_paterno" => "",
        "apellido_materno" => "",
        "genero"           => "",
        "fecha_nacimiento" => "",
        "calle"            => "",
        "numero_casa"      => "",
        "codigo_colonia"   => "",
        "telefono"         => "",
        "movil"            => "",
        "id_grupo"         => 0,
        "json_contactos"   => [],
        "estatus"          => ""
    );


    public function __construct() 
    {
        $this->utilerias = Utilerias::obtenerInstanciaUtilerias();
        $this->dataValidate = new DataValidate();

        $this->modelPublicador = $this->model('PublicadorModel');
	}


    /**
     *
     * @param number  $id_publicador  Número ID del publicador
     */
    public function set_id_publicador( $id_publicador )
    {
        $params_value = [
            "value" => $id_publicador,
            "name"  => "publicador"
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['id_publicador'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param number  $id_congregacion  Número ID de la Congregación a la que pertenece el publicador
     */
    public function set_id_congregacion( $id_congregacion ) 
    {
        $params_value = [
            "value"       => $id_congregacion,
            "name"        => "congregación",
            "is_required" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['id_congregacion'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $codigo_tipo  Tipo de publicador
     */
    public function set_codigo_tipo( $codigo_tipo ) 
    {
        $params_value = [
            "value"        => $codigo_tipo,
            "name"         => "tipo publicador",
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['codigo_tipo'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $fecha_bautismo  Fecha en que se bautizo el publicador.
     */
    public function set_fecha_bautismo( $fecha_bautismo ) 
    {
        $params_value = [
            "value"        => $fecha_bautismo,
            "name"         => "fecha de bautismo"
        ];

        // Formateamos número
        $params_value['value'] = $this->utilerias->fecha_yyyymmdd( $params_value['value'] ,"-", "-");

        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['fecha_bautismo'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $nombre  Nombre del publicador.
     */
    public function set_nombre( $nombre ) 
    {
        $params_value = [
            "value"        => $nombre,
            "name"         => "nombre",
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['nombre'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $apellido_paterno  Apellido paterno del publicador.
     */
    public function set_apellido_paterno( $apellido_paterno ) 
    {
        $params_value = [
            "value"        => $apellido_paterno,
            "name"         => "apellido paterno",
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['apellido_paterno'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $apellido_materno  Apellido materno del publicador.
     */
    public function set_apellido_materno( $apellido_materno ) 
    {
        $params_value = [
            "value"        => $apellido_materno,
            "name"         => "apellido materno",
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['apellido_materno'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $genero  Tipo de genero del publicador
     */
    public function set_genero( $genero ) 
    {
        $params_value = [
            "value"        => $genero,
            "name"         => "género", 
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['genero'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $fecha_nacimiento  Fecha en que nacio el publicador.
     */
    public function set_fecha_nacimiento( $fecha_nacimiento ) 
    {
        $params_value = [
            "value"        => $fecha_nacimiento,
            "name"         => "fecha de nacimiento"
        ];

        // Formateamos número
        $params_value['value'] = $this->utilerias->fecha_yyyymmdd( $params_value['value'] ,"-", "-");

        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['fecha_nacimiento'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $calle  Nombre de la calle donde vive el publicador.
     */
    public function set_calle( $calle ) 
    {
        $params_value = [
            "value"        => $calle,
            "name"         => "calle",
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['calle'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $numero_casa  Número de interior o exterior de la vivienda del publicador.
     */
    public function set_numero_casa( $numero_casa ) 
    {
        $params_value = [
            "value"        => $numero_casa,
            "name"         => "número de casa",
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['numero_casa'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $codigo_colonia  Código de catálogo de la colonia del publicador.
     */
    public function set_codigo_colonia( $codigo_colonia ) 
    {
        $params_value = [
            "value"       => $codigo_colonia,
            "name"        => "colonia",
            "is_required" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['codigo_colonia'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $telefono  Número de teléfono de casa de la vivienda el publicador.
     */
    public function set_telefono( $telefono ) 
    {
        $params_value = [
            "value" => $telefono,
            "name"  => "teléfono"
        ];

        // Formateamos número
        $params_value['value'] = $this->utilerias->formatNumberMobile($params_value['value']);

        // Verificar longitud
        if ( strlen($params_value['value']) < 10 && !empty($params_value['value']) )
            throw new DataStatusResponse( true, 0, 'El número de teléfono no debe contener menos de 10 dígitos.', 203 );

        // Verificar longitud mayor
        if ( strlen($params_value['value']) > 10 && !empty($params_value['value']) )
            throw new DataStatusResponse( true, 0, 'El número de teléfono no debe contener más de 10 dígitos.', 203 );

        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['telefono'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $movil  Número de celular del publicador.
     */
    public function set_movil( $movil ) 
    {
        $params_value = [
            "value" => $movil,
            "name"  => "móvil"
        ];

        // Formateamos número
        $params_value['value'] = $this->utilerias->formatNumberMobile($params_value['value']);

        // Verificar longitud
        if ( strlen($params_value['value']) < 10 && !empty($params_value['value']) )
            throw new DataStatusResponse( true, 0, 'El número de móvil no debe contener menos de 10 dígitos.', 203 );

        // Verificar longitud mayor
        if ( strlen($params_value['value']) > 10 && !empty($params_value['value']) )
            throw new DataStatusResponse( true, 0, 'El número de movil no debe contener más de 10 dígitos.', 203 );

        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['movil'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param number  $id_grupo  Número ID del grupo al que pertemece el publicador
     */
    public function set_id_grupo( $id_grupo ) 
    {
        $params_value = [
            "value"       => $id_grupo,
            "name"        => "grupo",
            "is_required" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['id_grupo'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $json_contacto  Son los contactos en caso de emergencia del publicador
     */
    public function set_json_contacto( $json_contacto ) 
    {
        $params_value = [
            "value" => $json_contacto,
            "name"  => "contactos de emergencia",
            "allow_special_characters" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['json_contactos'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $estatus  Estatus en que se encuentra el publicador
     */
    public function set_estatus( $estatus ) 
    {
        $params_value = [
            "value"        => $estatus,
            "name"         => "estatus", 
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['estatus'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }


    public function guardar( $data_array ) 
    {
        $this->data['ban'] = 'CREPUB';

        $data_array['id_publicador'] = ( !empty($data_array['id_publicador']) ) ? $data_array['id_publicador'] : 0 ;
        $this->set_id_publicador($data_array['id_publicador']);

        $data_array['id_congregacion'] = ( !empty($data_array['id_congregacion']) ) ? $data_array['id_congregacion'] : 0 ;
        // $data_array['id_congregacion'] = ( empty($_SESSION["datos_usuario"]["ID_CONGREGACION"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_CONGREGACION"] ;
        $this->set_id_congregacion($data_array['id_congregacion']);

        $data_array['codigo_tipo'] = ( isset($data_array['codigo_tipo']) ) ? $data_array['codigo_tipo'] : '' ;
        $this->set_codigo_tipo($data_array['codigo_tipo']);

        $data_array['fecha_bautismo'] = ( isset($data_array['fecha_bautismo']) ) ? $data_array['fecha_bautismo'] : '' ;
        $this->set_fecha_bautismo($data_array['fecha_bautismo']);

        $data_array['nombre'] = ( isset($data_array['nombre']) ) ? $data_array['nombre'] : '' ;
        $this->set_nombre($data_array['nombre']);

        $data_array['apellido_paterno'] = ( isset($data_array['apellido_paterno']) ) ? $data_array['apellido_paterno'] : '' ;
        $this->set_apellido_paterno($data_array['apellido_paterno']);

        $data_array['apellido_materno'] = ( isset($data_array['apellido_materno']) ) ? $data_array['apellido_materno'] : '' ;
        $this->set_apellido_materno($data_array['apellido_materno']);

        $data_array['genero'] = ( isset($data_array['genero']) ) ? $data_array['genero'] : '' ;
        $this->set_genero($data_array['genero']);

        $data_array['fecha_nacimiento'] = ( isset($data_array['fecha_nacimiento']) ) ? $data_array['fecha_nacimiento'] : '' ;
        $this->set_fecha_nacimiento($data_array['fecha_nacimiento']);

        $data_array['calle'] = ( isset($data_array['calle']) ) ? $data_array['calle'] : '' ;
        $this->set_calle($data_array['calle']);

        $data_array['numero_casa'] = ( isset($data_array['numero_casa']) ) ? $data_array['numero_casa'] : '' ;
        $this->set_numero_casa($data_array['numero_casa']);

        $data_array['codigo_colonia'] = ( isset($data_array['codigo_colonia']) ) ? $data_array['codigo_colonia'] : '' ;
        $this->set_codigo_colonia($data_array['codigo_colonia']);

        $data_array['telefono'] = ( isset($data_array['telefono']) ) ? $data_array['telefono'] : '' ;
        $this->set_telefono($data_array['telefono']);

        $data_array['movil'] = ( isset($data_array['movil']) ) ? $data_array['movil'] : '' ;
        $this->set_movil($data_array['movil']);

        $data_array['id_grupo'] = ( isset($data_array['id_grupo']) ) ? $data_array['id_grupo'] : '' ;
        $this->set_id_grupo($data_array['id_grupo']);

        $data_array['json_contactos'] = ( isset($data_array['json_contactos']) ) ? $data_array['json_contactos'] : '' ;
        $this->set_json_contacto($data_array['json_contactos']);

        $data_array['estatus'] = ( isset($data_array['estatus']) ) ? $data_array['estatus'] : '' ;
        $this->set_estatus($data_array['estatus']);

        $response = $this->modelPublicador->guardar( $this->data );

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        // new ViewDataTest( $this->data );
        throw new DataStatusResponse( $response['ERROR'], 0, 'Publicador guardado.', 201, ['status_msg' => $status_msg] );
    }


    public function borrar( $data_array ) 
    {
        $this->data['ban'] = 'DELPUB';

        $data_array['id_publicador'] = ( !empty($data_array['id_publicador']) ) ? $data_array['id_publicador'] : 0 ;
        $this->set_id_publicador($data_array['id_publicador']);

        $response = $this->modelPublicador->guardar( $this->data );

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        // new ViewDataTest( $this->data );
        throw new DataStatusResponse( $response['ERROR'], 0, 'Publicador borrado.', 201, ['status_msg' => $status_msg] );

    }


    public function data_table_list( $data_array = [] ) 
    {
		$params_value =  array (
			"ban"    => 0,
			"row"    => 0,
			"rows"   => 0,
            "id_congregacion"   => 0,
			"search" => ''
		);
        $data = array_merge($params_value, $data_array);

		$data = $this->modelPublicador->data_list($data);
        return $data['JSON_DATA_LIST'];
    }


    public function obtener_publicador_por_id( $id ) 
    {
        $data =  array (
			"ban"=> 1,
            "search" => $id,
            "opciones" => ["tipo" => "U"] 
		);

		$data = $this->modelPublicador->consultar( $data );

        return $data;
    }

    public function obtener_info_publicador_por_id( $id ) 
    {
        $data =  array (
			"ban"=> 2,
            "search" => $id,
            "opciones" => ["tipo" => "U"] 
		);

		$data = $this->modelPublicador->consultar( $data );

        return $data;
    }

}