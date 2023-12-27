<?php
// session_start();

class _Usuario extends Controller {

    private $dataValidate;

    private $modelUsuario;

    /**
     * Usuario data.
     *
     * @var array
     */
    protected $data = array(
        'id_usuario' => 0,
        'id_perfil' => 0,
        'id_publicador' => 0,
        'usuario' => null,
        'password' => null
    );

    public function __construct()
    {
        $this->dataValidate = new DataValidate();
        $this->modelUsuario = $this->model('UsuarioModel');
	}

    /**
     *
     * @param number  $id_usuario  Número ID de Usuario
     */
    public function set_id_usuario( $id_usuario ) 
    {
        $params_value = [
            'value' => $id_usuario,
            'name' => 'id de usuario'
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['id_usuario'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param number  $id_perfil  Perfil de Usuario
     */
    public function set_id_perfil( $id_perfil ) 
    {
        $params_value = [
            'value' => $id_perfil,
            'name' => 'perfil',
            'is_required' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['id_perfil'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param number  $id_publicador  Número ID del publicador
     */
    public function set_id_publicador( $id_publicador ) 
    {
        $params_value = [
            'value' => $id_publicador,
            'name' => 'publicador',
            'is_required' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['id_publicador'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $usuario  Nombre de usuario del publicador.
     */
    public function set_usuario( $usuario ) 
    {
        $params_value = [
            "value"        => $usuario,
            "name"         => "usuario",
            "is_required"  => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['usuario'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string  $password  Password de acceso
     */
    public function set_password( $password, $required ) 
    {
        $params_value = [
            'value' => $password,
            'name' => 'password',
            'is_required' => $required
        ];

        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['password'] = $this->dataValidate->rules_value($options_rules);

        $this->data['password'] = ( $required ) ? password_hash($this->data['password'], PASSWORD_DEFAULT, ['cost' => 12]) : $this->data['password'] ;

        return $this;
    }


    public function guardar( $data_array )
    {
        $this->data['ban'] = 'CREUSR';

        $data_array['id_usuario'] = ( isset($data_array['id_usuario']) ) ? $data_array['id_usuario'] : '' ;
        $this->set_id_usuario($data_array['id_usuario']);

        $data_array['id_perfil'] = ( isset($data_array['id_perfil']) ) ? $data_array['id_perfil'] : '' ;
        $this->set_id_perfil($data_array['id_perfil']);

        $data_array['id_publicador'] = ( isset($data_array['id_publicador']) ) ? $data_array['id_publicador'] : '' ;
        $this->set_id_publicador($data_array['id_publicador']);

        $data_array['usuario'] = ( isset($data_array['usuario']) ) ? $data_array['usuario'] : '' ;
        $this->set_usuario($data_array['usuario']);

        $data_array['password'] = ( isset($data_array['password'][0]) ) ? $data_array['password'][0] : '' ;
        $this->set_password( $data_array['password'], $data_array['password'][1] );

        // new ViewDataTest( $this->data );

        $response = $this->modelUsuario->guardar( $this->data );

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        throw new DataStatusResponse( $response['ERROR'], 0, 'Usuario guardado.', 201, ['status_msg' => $status_msg] );
    }

    public function obtener_usuario( $ban, $usuario )
    {
        return $this->modelUsuario->consultar(['ban'=> $ban, 'search' => $usuario, 'opciones' => ['tipo'=> "U"]]);
    }


    public function existe_usuario( $usuario )
    {
        if ( $this->modelUsuario->existeUsuarioPorUsuario( $usuario ) == "false" )
            throw new DataStatusResponse( true, 0, 'Este usuario no existe.', 203 );
    }

    public function usuario_acceso( $usuario )
    {
        if ( $this->modelUsuario->verificarAccesoUsuarioPorUsuario( $usuario ) == "false" )
            throw new DataStatusResponse( true, 0, 'No cuentas con acceso al sistema.', 203 );
    }

    public function obtener_usuario_por_id( $id ) 
    {
        $data =  array (
			"ban"=> 3,
            "search" => $id,
            "opciones" => ["tipo" => "U"] 
		);

		$data = $this->modelUsuario->consultar( $data );

        return $data;
    }


    public function borrar( $data_array ) 
    {
        $this->data['ban'] = 'DELUSR';

        $data_array['id_usuario'] = ( !empty($data_array['id_usuario']) ) ? $data_array['id_usuario'] : 0 ;
        $this->set_id_usuario($data_array['id_usuario']);

        $response = $this->modelUsuario->guardar( $this->data );

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        // new ViewDataTest( $this->data );
        throw new DataStatusResponse( $response['ERROR'], 0, 'Usuario borrado.', 201, ['status_msg' => $status_msg] );

    }


    public function data_table_list( $data_array = [] ) 
    {
		$params_value =  array (
			"ban"    => 0,
			"row"    => 0,
			"rows"   => 0,
			"search" => ''
		);
        $data = array_merge($params_value, $data_array);

		$data = $this->modelUsuario->data_list($data);
        return $data['JSON_DATA_LIST'];

    }

}