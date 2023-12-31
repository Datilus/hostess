<?php

class DataValidate {

    private $utilerias;

    /**
     * Values data.
     *
     * @var array
     */
    public $params_value = array(

        'value' => '',

        'name' => '',

        'is_required' => false,

        'is_uppercase' => false,

        'allow_special_characters' => false  // true = Permitidos, false = No permitidos

    );
    

    public function __construct() 
    {
        $this->utilerias = Utilerias::obtenerInstanciaUtilerias();
    }


    public function rules_value( $options_rules )
    {
        // Remplazamos vocales con acentos y las ñ
        $options_rules["value"] = $this->utilerias->quitarCaracteres($options_rules["value"]);


        // Validar caracteres especiales
        if ( $this->utilerias->caracteres_especiales($options_rules["value"]) == false && $options_rules["allow_special_characters"] == false )
            throw new DataStatusResponse( true, 0, 'El campo '. trim($options_rules['name']) .' tiene caracteres especiales no permitidos.', 203, ['status_msg' => 'warning'] );


        // Quitamos espacios
        $options_rules["value"] = $this->utilerias->quitar_espacios_rl($options_rules["value"]);


        // Requerido
        if ( empty($options_rules['value']) && $options_rules['is_required'] == true)
            throw new DataStatusResponse( true, 0, 'El campo '. trim($options_rules['name']) .' es requerido.', 203, ['status_msg' => 'warning'] );


        // Convertimos a mayúsculas o minúsculas
        switch ( $options_rules["is_uppercase"] ) {
            case true:
                $options_rules["value"] = mb_strtoupper($options_rules["value"], 'UTF-8');
                break;
            case false:
                // $options_rules["value"] = mb_strtolower($options_rules["value"], 'UTF-8');
                // break;
        }

        return $options_rules["value"];
        
    }

}