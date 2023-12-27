<?php

// Ejemplo

/* $datos['estados'] = $this->orm
->setTabla(["tabla" => "ca_estados"])
->setCampo(["campo_bd" => "clave"])
->setCampo(["campo_bd" => "estado"])
->setFiltro(["campo_bd" => "estatus", "comparacion" => "=", "parametro" => "1"])
->consultar(["tipo_consulta" => "L", "order_by" => ["campo_bd" => "clave", "orden" => "ASC"]]); */


class MyORM{

	// --- creamos la variable donde se instanciará la clase "conectar"
    public $conexion;
    private $tabla       = '';
    private $join        = array();
    private $arrayCampo  = array();
    private $arrayFiltro = array();


	public function __construct()
	{
        //$this->conexion = new ConexionBD();
		$this->conexion = ConexionBD::obtenerInstancia();
	}
	
	public function startTransaction()
    {
        $this->conexion->query("START TRANSACTION") or die ($this->conexion->error());
    }

	public function commit()
    {
        $this->conexion->query("COMMIT") or die ($this->conexion->error());
    }

	public function rollback()
    {
        $this->conexion->query("ROLLBACK") or die ($this->conexion->error());
    }

	public function cerrarConexion()
    {
		$this->conexion->close_conexion();
	}

	/**
	* @param $tabla (string) nombre de la tabla en bd
	* @param $prefijo (string) prefijo para identificarlo en bd
	*/
    public function setTabla($opciones = [])
    {
		$default_opc = [
			"tabla" => "",
			"prefijo" => ""
		];

		$opc_data = array_merge($default_opc, $opciones);

        if ( empty($opc_data['prefijo']) ) {

            $this->tabla = $opc_data['tabla'];
        }else {

            $this->tabla = $opc_data['tabla'] . ' AS ' . $opc_data['prefijo'];
        }

        return $this;
    }


	/**
	* @param $campo_bd (string) nombre del campo en bd
	* @param $parametro (string) dato para agregar
	* @param $prefijo (string) aplica para consultas el prefijo que queremos dar al valor del resultado
	*/
	public function setCampo($opciones = [])
    {
		$default_opc = [
			"campo_bd" => "",
			"parametro" => "",
			"prefijo" => ""
		];

		$opc_data = array_merge($default_opc, $opciones);

        $this->arrayCampo[$opc_data['campo_bd']] = [$opc_data['parametro'], $opc_data['prefijo']];
        return $this;
    }


	/**
	* @param $campo_bd (string) nombre del campo en bd
	* @param $comparacion (string) dato para comparación (=, ><, =>, ...)
	* @param $parametro (string) dato para comparar
	*/
    public function setFiltro($opciones = [])
    {
		if ( !empty($opciones) ){

			$default_opc = [
				"campo_bd" => "",
				"comparacion" => "",
				"parametro" => ""
			];
		}else{

			$default_opc = [];
		}

		$opc_data = array_merge($default_opc, $opciones);

        $this->arrayFiltro[] = $opc_data;
        return $this;
    }


    public function insertar()
    {
		$campos_bd = "";
		$datos_in  = "";

		foreach($this->arrayCampo as $key => $valor) 
		{
			$campos_bd .= $key . ', ';
			$datos_in  .= "'" . $valor[1] . "', ";
        }
		
        $campos_bd = substr($campos_bd, 0, -2);
        $datos_in  = substr($datos_in, 0, -2);

        // Reiniciamos el array de campos
        $this->arrayCampo = array();

		$query     = 'INSERT INTO ' . $this->tabla . ' (' . $campos_bd . ') VALUES (' . $datos_in . ');';
		$resultado = $this->conexion->query($query) or die ($this->conexion->error());

		return $resultado;
    }


    public function actualizar()
    {
		$campos_bd = "";
		$filtros   = '';

		foreach($this->arrayCampo as $key => $valor) 
		{
			$campos_bd .= $key . ' = "' . $valor[0] . '", ';
		}
        $campos_bd = substr($campos_bd, 0, -2);

		if ( count($this->arrayFiltro) > 0 ){

            $i = 0;
            foreach($this->arrayFiltro as $valor)
			{
                if ( $i == 0 ) {

                    $filtros .= $valor[0] . $valor[2] . "'" . $valor[1] . "'";
                }else {

                    $filtros .= ' AND ' . $valor[0] . $valor[2] . "'" . $valor[1] . "'";
                }
                $i++;
            }
			// Reseteamos filtro
			$this->arrayFiltro = array();
        }else {

            die('Query actualizar debe contener al menos un filtro.');
        }

        // Reiniciamos el array de campos
        $this->arrayCampo = array();

		$query = 'UPDATE ' . $this->tabla . ' SET ' . $campos_bd . ' WHERE ' . $filtros;
		//echo $query;

		$resultado = $this->conexion->query($query) or $this->conexion->error();

		return $resultado;
    } 


    public function join($tipo_join = "INNER", $tabla = "tabla", $prefijo = "", $filtro = array())
    {
		$filtro_concat   = '';
		$i = 0;
		// Verificamos si hay filtros
		if ( count($filtro) > 0 ) {

			foreach($filtro as $key => $valor) 
			{
				if ( $i == 0 ) {

					$filtro_concat .= ' '.$key.''.$valor[0].''.$valor[1];
				}else {

                    $filtro_concat .= ' AND '.$key.''.$valor[0].''.$valor[1];
                }
                $i++;
			}
		}

        $this->join[] = ' '.$tipo_join . ' JOIN '. $tabla . ' AS ' . $prefijo . ' ON ' . $filtro_concat;
        return $this;
    }


	/**
	* @param $opciones (array) string del input
	* @param $tipo (string) tipo de consulta L=Lista, U=Registro único, C=Conteo de registros
	* @param $order (array) tipo_order = asc, desc  campo por el cual se va a ordenar
	* @param $group (string) campo por el cual se va a agrupar
	* @param $mayusmin (string) strtoupper=Mayúscula, strtolower=Minúscula
	*/
    public function consultar($opciones = [])
    {
		$campos_bd     = "";
		$join          = "";
		$filtros       = "";

		$default_opc = [
			"tipo_consulta" => "",
			"order_by" => ["campo_bd" => "", "orden" => ""]
		];

		$opc_data = array_merge($default_opc, $opciones);


		// Tipo de consulta
		switch( $opc_data['tipo_consulta'] ) { 
			case 'L': 
				$tipo_consulta = 'consulta_array';
				break;
			case 'C': 
				$tipo_consulta = 'numero_registros';
				break;
			default:
				$tipo_consulta = 'consulta_assoc';
				break;
		}

		foreach($this->arrayCampo as $key => $valor)
		{
			if (empty($valor[1])){

				$campos_bd .= $key . ', ';
			}else{

				$campos_bd .= $key . ' AS ' .$valor[1] .', ';
			}
        }
        $campos_bd = substr($campos_bd, 0, -2);

		// Juntar tablas en consulta
        foreach($this->join as $valor){
            $join .= $valor;
        }

		// Filtramos consulta
        if ( !empty($this->arrayFiltro) ){
            $i = 0;
            foreach($this->arrayFiltro as $valor)
			{
                if ( $i == 0 ) {

                    $filtros .= $valor['campo_bd'] . " ". $valor['comparacion'] . " '" . $valor['parametro'] . "'";
                }else {

                    $filtros .= ' AND ' . $valor['campo_bd'] . " ". $valor['comparacion'] . " '" . $valor['parametro'] . "'";
                }

                $i++;
            }
			// Reseteamos filtro
			$this->arrayFiltro = array();
        }else {
            $filtros = 1;
        }

		// Ordenar por
		switch( $opc_data['order_by']['orden'] ) { 
			case 'ASC': 
				$order_by = ' ORDER BY '. $opc_data['order_by']['campo_bd'] .' ASC';
				break;
			case 'DESC': 
				$order_by = ' ORDER BY '. $opc_data['order_by']['campo_bd'] .' DESC';
				break;
			default:
				$order_by = '';
				break;
		}
		
		// Reiniciamos el array de campos
        $this->arrayCampo = array();

        $query = "SELECT " . $campos_bd . " FROM " . $this->tabla . $join. " WHERE " . $filtros . $order_by;
		// echo $query;

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $resultado = $this->conexion->$tipo_consulta($consulta);

		//$this->conexion->next_result();

		return $resultado;
    }

}