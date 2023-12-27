<?php
declare(strict_types=1);

class _Publicador {

    private $utilerias, 
            $dataValidate;

    private $id_publicador,
            $id_congregacion,
            $codigo_tipo,
            $fecha_bautismo,
            $nombre,
            $apellido_paterno,
            $apellido_materno,
            $genero,
            $fecha_nacimiento,
            $calle,
            $numero_casa,
            $codigo_colonia,
            $telefono,
            $movil,
            $id_grupo,
            $json_contactos,
            $estatus
    ;

    public function __construct() {
        $this->utilerias = Utilerias::obtenerInstanciaUtilerias();
        $this->dataValidate = new DataValidate();
	}


    /**
     *
     * @param int  $id_publicador  Número ID del publicador
     */
    public function set_id_publicador( int $id_publicador ){

        $params_value = [
            "value" => $id_publicador,
            "name"  => "publicador"
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->id_publicador = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param int  $id_congregacion  Número ID de la Congregación a la que pertenece el publicador
     */
    public function set_id_congregacion( int $id_congregacion ) {

        $params_value = [
            "value"       => $id_congregacion,
            "name"        => "congregación",
            "is_required" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->id_congregacion = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $codigo_tipo  Tipo de publicador
     */
    public function set_codigo_tipo( string $codigo_tipo ) {

        $params_value = [
            "value"        => $codigo_tipo,
            "name"         => "tipo publicador",
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->codigo_tipo = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $fecha_bautismo  Fecha en que se bautizo el publicador.
     */
    public function set_fecha_bautismo( string $fecha_bautismo ) {

        $params_value = [
            "value"        => $fecha_bautismo,
            "name"         => "fecha de bautismo"
        ];

        // Formateamos número
        $params_value['value'] = $this->utilerias->fecha_yyyymmdd( $params_value['value'] ,"-", "-");

        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->fecha_bautismo = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $nombre  Nombre del publicador.
     */
    public function set_nombre( string $nombre ) {

        $params_value = [
            "value"        => $nombre,
            "name"         => "nombre",
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->nombre = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $apellido_paterno  Apellido paterno del publicador.
     */
    public function set_apellido_paterno( string $apellido_paterno ) {

        $params_value = [
            "value"        => $apellido_paterno,
            "name"         => "apellido paterno",
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->apellido_paterno = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $apellido_materno  Apellido materno del publicador.
     */
    public function set_apellido_materno( string $apellido_materno ) {

        $params_value = [
            "value"        => $apellido_materno,
            "name"         => "apellido materno",
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->apellido_materno = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $genero  Tipo de genero del publicador
     */
    public function set_genero( string $genero ) {

        $params_value = [
            "value"        => $genero,
            "name"         => "género", 
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->genero = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $fecha_nacimiento  Fecha en que nacio el publicador.
     */
    public function set_fecha_nacimiento( string $fecha_nacimiento ) {

        $params_value = [
            "value"        => $fecha_nacimiento,
            "name"         => "fecha de nacimiento"
        ];

        // Formateamos número
        $params_value['value'] = $this->utilerias->fecha_yyyymmdd( $params_value['value'] ,"-", "-");

        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->fecha_nacimiento = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $calle  Nombre de la calle donde vive el publicador.
     */
    public function set_calle( string $calle ) {

        $params_value = [
            "value"        => $calle,
            "name"         => "calle",
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->calle = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $numero_casa  Número de interior o exterior de la vivienda del publicador.
     */
    public function set_numero_casa( string $numero_casa ) {

        $params_value = [
            "value"        => $numero_casa,
            "name"         => "número de casa",
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->numero_casa = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $codigo_colonia  Código de catálogo de la colonia del publicador.
     */
    public function set_codigo_colonia( string $codigo_colonia ) {

        $params_value = [
            "value"       => $codigo_colonia,
            "name"        => "colonia",
            "is_required" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->codigo_colonia = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $telefono  Número de teléfono de casa de la vivienda el publicador.
     */
    public function set_telefono( string $telefono ) {

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

        $this->telefono = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $movil  Número de celular del publicador.
     */
    public function set_movil( string $movil ) {

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

        $this->movil = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param int  $id_grupo  Número ID del grupo al que pertemece el publicador
     */
    public function set_id_grupo( int $id_grupo ) {

        $params_value = [
            "value"       => $id_grupo,
            "name"        => "grupo",
            "is_required" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->id_grupo = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $json_contacto  Son los contactos en caso de emergencia del publicador
     */
    public function set_json_contacto( string $json_contacto ) {

        $json_contacto = ( empty($json_contacto) ) ? [] : $json_contacto ;

        $params_value = [
            "value" => $json_contacto,
            "name"  => "contactos de emergencia",
            "allow_special_characters" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->json_contactos = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string $estatus  Estatus en que se encuentra el publicador
     */
    public function set_estatus( string $estatus ) {

        $params_value = [
            "value"        => $estatus,
            "name"         => "estatus", 
            "is_required"  => true,
            "is_uppercase" => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->estatus = $this->dataValidate->rules_value($options_rules);

        return $this;
    }



    public function get_id_publicador() {
        return $this->id_publicador;
    }

    public function get_id_congregacion() {
        return $this->id_congregacion;
    }

    public function get_codigo_tipo() {
        return $this->codigo_tipo;
    }

    public function get_fecha_bautismo() {
        return $this->fecha_bautismo;
    }

    public function get_nombre() {
        return $this->nombre;
    }

    public function get_apellido_paterno() {
        return $this->apellido_paterno;
    }

    public function get_apellido_materno() {
        return $this->apellido_materno;
    }

    public function get_genero() {
        return $this->genero;
    }

    public function get_fecha_nacimiento() {
        return $this->fecha_nacimiento;
    }

    public function get_calle() {
        return $this->calle;
    }

    public function get_numero_casa() {
        return $this->numero_casa;
    }

    public function get_codigo_colonia() {
        return $this->codigo_colonia;
    }

    public function get_telefono() {
        return $this->telefono;
    }

    public function get_movil() {
        return $this->movil;
    }

    public function get_id_grupo() {
        return $this->id_grupo;
    }

    public function get_json_contactos() {
        return $this->json_contactos;
    }

    public function get_estatus() {
        return $this->estatus;
    }



    public function DataSavePublicador() {

        return [
            "id_publicador"    => $this->id_publicador,
            "id_congregacion"  => $this->id_congregacion,
            "codigo_tipo"      => $this->codigo_tipo,
            "fecha_bautismo"   => $this->fecha_bautismo,
            "nombre"           => $this->nombre,
            "apellido_paterno" => $this->apellido_paterno,
            "apellido_materno" => $this->apellido_materno,
            "genero"           => $this->genero,
            "fecha_nacimiento" => $this->fecha_nacimiento,
            "calle"            => $this->calle,
            "numero_casa"      => $this->numero_casa,
            "codigo_colonia"   => $this->codigo_colonia,
            "telefono"         => $this->telefono,
            "movil"            => $this->movil,
            "id_grupo"         => $this->id_grupo,
            "json_contactos"   => $this->json_contactos,
            "estatus"          => $this->estatus,
        ];

    }

}