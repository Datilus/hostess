<?php

class PublicadorService {

    private $utilerias, 
            $dataValidate;

    private $publicador;

    public function __construct() {

        $this->utilerias = Utilerias::obtenerInstanciaUtilerias();
        $this->dataValidate = new DataValidate();

        $this->publicador = new _Publicador();
    }


    public function DataSavePublicador( $data_array ) 
    {
        // $this->data['ban'] = 'CREPUB';

        $data_publicador = $this->publicador
        ->set_id_publicador($data_array['id_publicador'])
        ->set_id_congregacion($data_array['id_congregacion'])
        ->set_codigo_tipo($data_array['codigo_tipo'])
        ->set_fecha_bautismo($data_array['fecha_bautismo'])
        ->set_nombre($data_array['nombre'])
        ->set_apellido_paterno($data_array['apellido_paterno'])
        ->set_apellido_materno($data_array['apellido_materno'])
        ->set_genero($data_array['genero'])
        ->set_fecha_nacimiento($data_array['fecha_nacimiento'])
        ->set_calle($data_array['calle'])
        ->set_numero_casa($data_array['numero_casa'])
        ->set_codigo_colonia($data_array['codigo_colonia'])
        ->set_telefono($data_array['telefono'])
        ->set_movil($data_array['movil'])
        ->set_id_grupo($data_array['id_grupo'])
        ->set_json_contacto($data_array['json_contactos'])
        ->set_estatus($data_array['estatus'])
        ->DataSavePublicador();
        ;

        $data_publicador['ban'] = 'CREPUB';

        return $data_publicador;

        // print_r($data_publicador);
        // new ViewDataTest( $data_publicador );

        // $response = $this->modelPublicador->guardar( $data_publicador );

        // $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;
        // throw new DataStatusResponse( $response['ERROR'], 0, 'Publicador guardado.', 201, ['status_msg' => $status_msg] );
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