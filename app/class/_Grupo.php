<?php

class _Grupo extends Controller {

    private $utilerias, 
            $dataValidate;

    private $modelGrupo;

    /**
     * Publicador data.
     *
     * @var array
     */
    protected $data = array(
        'id_grupo'        => 0,
        'id_congregacion' => 0,
        'grupo'           => '',
        'id_responsable'  => 0,
        'id_auxiliar'     => 0
    );

    public function __construct()
    {
        $this->utilerias = Utilerias::obtenerInstanciaUtilerias();
        $this->dataValidate = new DataValidate();

        $this->modelGrupo = $this->model('GrupoModel');
	}

    /**
     *
     * @param number  $id_grupo  Número ID del grupo
     */
    public function set_id_grupo( $id_grupo ) 
    {
        $params_value = [
            'value' => $id_grupo,
            'name' => 'id de grupo'
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['id_grupo'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param number  $id_congregacion  Número ID de la Congregación a la que pertenece el grupo
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
     * @param string $grupo  Nombre del grupo.
     */
    public function set_grupo( $grupo ) 
    {
        $params_value = [
            'value' => $grupo,
            'name' => 'nombre del grupo',
            'is_required' => true,
            'is_uppercase' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['grupo'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $id_responsable  Id del hno reponsable.
     */
    public function set_id_reponsable( $id_responsable ) 
    {
        $params_value = [
            'value' => $id_responsable,
            'name' => 'responsable',
            'is_required' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['id_responsable'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $id_auxiliar  Id del hno auxiliar.
     */
    public function set_id_auxiliar( $id_auxiliar ) 
    {
        $params_value = [
            'value' => $id_auxiliar,
            'name' => 'auxiliar',
            'is_required' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['id_auxiliar'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    
    public function guardar( $data_array ) 
    {
        $this->data['ban'] = 'CREGRU';

        $data_array['id_grupo'] = ( !empty($data_array['id_grupo']) ) ? $data_array['id_grupo'] : 0 ;
        $this->set_id_grupo($data_array['id_grupo']);

        $data_array['id_congregacion'] = ( !empty($data_array['id_congregacion']) ) ? $data_array['id_congregacion'] : 0 ;
        $this->set_id_congregacion($data_array['id_congregacion']);

        $data_array['grupo'] = ( !empty($data_array['grupo']) ) ? $data_array['grupo'] : '' ;
        $this->set_grupo($data_array['grupo']);

        $data_array['id_responsable'] = ( !empty($data_array['id_responsable']) ) ? $data_array['id_responsable'] : '' ;
        $this->set_id_reponsable($data_array['id_responsable']);

        $data_array['id_auxiliar'] = ( !empty($data_array['id_auxiliar']) ) ? $data_array['id_auxiliar'] : '' ;
        $this->set_id_auxiliar($data_array['id_auxiliar']);

        $response = $this->modelGrupo->guardar( $this->data );

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        // new ViewDataTest( $this->data );
        throw new DataStatusResponse( $response['ERROR'], 0, 'Grupo guardado.', 201, ['status_msg' => $status_msg] );

    }

    // public function generar_json()
    // {
    //     return json_encode( $this->data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT );
    // }

    public function borrar( $data_array ) 
    {
        $this->data['ban'] = 'DELGRU';

        $data_array['id_grupo'] = ( !empty($data_array['id_grupo']) ) ? $data_array['id_grupo'] : 0 ;
        $this->set_id_grupo($data_array['id_grupo']);

        $response = $this->modelGrupo->guardar( $this->data );

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        // new ViewDataTest( $this->data );
        throw new DataStatusResponse( $response['ERROR'], 0, 'Grupo borrado.', 201, ['status_msg' => $status_msg] );

    }

    public function data_table_list( $data_array = [] ) 
    {
		$params_value =  array (
			"ban"             => 0,
			"row"             => 0,
			"rows"            => 0,
			"id_congregacion" => 0,
			"search"          => ''
		);
        $data = array_merge($params_value, $data_array);

		$data = $this->modelGrupo->data_list($data);
        return $data['JSON_DATA_LIST'];

    }


    public function obtener_grupo_por_id( $id ) 
    {
        $data =  array (
			"ban"=> 1,
            "search" => $id,
            "opciones" => ["tipo" => "U"] 
		);

		$data = $this->modelGrupo->consultar( $data );

        return $data;
    }

}