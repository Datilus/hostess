<?php

class _Congregacion extends Controller {

    private $utilerias, 
            $dataValidate;

    private $modelCongregacion;

    /**
     * Publicador data.
     *
     * @var array
     */
    protected $data = array(
        'id_congregacion' => 0,
        'nombre' => '',
        'calle_salon' => '',
        'numero_salon' => '',
        'codigo_colonia' => '',
        'telefono_salon' => ''
    );

    public function __construct()
    {
        $this->utilerias = Utilerias::obtenerInstanciaUtilerias();
        $this->dataValidate = new DataValidate();

        $this->modelCongregacion = $this->model('CongregacionModel');
	}

    /**
     *
     * @param number  $id_congregacion  Número ID de la Congregación
     */
    public function set_id_congregacion( $id_congregacion ) 
    {
        $params_value = [
            'value' => $id_congregacion,
            'name' => 'id de congregación'
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['id_congregacion'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $nombre  Nombre de la congregación.
     */
    public function set_nombre( $nombre ) 
    {
        $params_value = [
            'value' => $nombre,
            'name' => 'nombre del salón',
            'is_required' => true,
            'is_uppercase' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['nombre'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $calle  Nombre de la calle del salón del Reino.
     */
    public function set_calle_salon( $calle_salon ) 
    {
        $params_value = [
            'value' => $calle_salon,
            'name' => 'calle del salón',
            'is_required' => true,
            'is_uppercase' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['calle_salon'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $numero_salon  Número de interior o exterior del salón del Reino.
     */
    public function set_numero_salon( $numero_salon ) 
    {
        $params_value = [
            'value' => $numero_salon,
            'name' => 'número de ext-int del salón',
            'is_uppercase' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['numero_salon'] = $this->dataValidate->rules_value($options_rules);

        $this->data['numero_salon'] = ( empty($this->data['numero_salon']) ) ? "S.N": $this->data['numero_salon'] ;

        return $this;
    }

    /**
     *
     * @param string $codigo_colonia  Código de catálogo de la colonia del salón del Reino.
     */
    public function set_codigo_colonia( $codigo_colonia ) 
    {

        $params_value = [
            'value' => $codigo_colonia,
            'name' => 'colonia del salón',
            'is_required' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['codigo_colonia'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $telefono  Número de teléfono del salón del Reino.
     */
    public function set_telefono_salon( $telefono_salon ) 
    {
        $params_value = [
            'value' => $telefono_salon,
            'name' => 'teléfono del salón',
            'is_required' => true
        ];

        // Formateamos número
        $params_value['value'] = $this->utilerias->formatNumberMobile($params_value['value']);

        // Verificar longitud menor
        if ( strlen($params_value['value']) < 10 && !empty($params_value['value']) )
            throw new DataStatusResponse( true, 0, 'El número de teléfono no debe contener menos de 10 dígitos.', 203, ['status_msg' => 'warning'] );

        // Verificar longitud mayor
        if ( strlen($params_value['value']) > 10 && !empty($params_value['value']) )
            throw new DataStatusResponse( true, 0, 'El número de teléfono no debe contener más de 10 dígitos.', 203, ['status_msg' => 'warning'] );

        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['telefono_salon'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    
    public function guardar( $data_array ) 
    {
        $this->data['ban'] = 'CRECON';

        $data_array['id_congregacion'] = ( !empty($data_array['id_congregacion']) ) ? $data_array['id_congregacion'] : 0 ;
        $this->set_id_congregacion($data_array['id_congregacion']);

        $data_array['nombre'] = ( !empty($data_array['nombre']) ) ? $data_array['nombre'] : '' ;
        $this->set_nombre($data_array['nombre']);

        $data_array['calle_salon'] = ( !empty($data_array['calle_salon']) ) ? $data_array['calle_salon'] : '' ;
        $this->set_calle_salon($data_array['calle_salon']);

        $data_array['numero_salon'] = ( !empty($data_array['numero_salon']) ) ? $data_array['numero_salon'] : '' ;
        $this->set_numero_salon($data_array['numero_salon']);

        $data_array['codigo_colonia'] = ( !empty($data_array['codigo_colonia']) ) ? $data_array['codigo_colonia'] : '' ;
        $this->set_codigo_colonia($data_array['codigo_colonia']);

        $data_array['telefono_salon'] = ( !empty($data_array['telefono_salon']) ) ? $data_array['telefono_salon'] : '' ;
        $this->set_telefono_salon($data_array['telefono_salon']);

        $response = $this->modelCongregacion->guardar( $this->data );

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        // new ViewDataTest( $this->data );
        throw new DataStatusResponse( $response['ERROR'], 0, 'Congregación guardada.', 201, ['status_msg' => $status_msg] );

    }

    // public function generar_json()
    // {
    //     return json_encode( $this->data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT );
    // }

    public function borrar( $data_array ) 
    {
        $this->data['ban'] = 'DELCON';

        $data_array['id_congregacion'] = ( !empty($data_array['id_congregacion']) ) ? $data_array['id_congregacion'] : 0 ;
        $this->set_id_congregacion($data_array['id_congregacion']);

        $response = $this->modelCongregacion->guardar( $this->data );

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        // new ViewDataTest( $this->data );
        throw new DataStatusResponse( $response['ERROR'], 0, 'Congregación borrada.', 201, ['status_msg' => $status_msg] );

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

		$data = $this->modelCongregacion->data_list($data);
        return $data['JSON_DATA_LIST'];

    }


    public function obtener_congregacion_por_id( $id ) 
    {
        $data =  array (
			"ban"=> 1,
            "search" => $id,
            "opciones" => ["tipo" => "U"] 
		);

		$data = $this->modelCongregacion->consultar( $data );

        return $data;
    }

}