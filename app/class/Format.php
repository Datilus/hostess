<?php

/*
Reglas de formato

uppercase:      Convierte el string a mayusculas
trim:           Quita espacios en blanco del string tanto del lado izquierdo como del derecho
removeAccent:   Remplaza los caracteres que tienen acentos (incluye la ñ)
*/
class Format
{
    protected $data;
    protected array $errors = [];

    private array $data_response = array();

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function get_data_response()
    {
        return $this->data_response;
    }

    public function transmute(array $rules)
    {
        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);
            foreach ($rulesArray as $singleRule) {
                $this->applyRule($field, $singleRule);
            }
        }

        return $this->errors;
    }

    /**
     * @throws DataStatusResponse
     */
    protected function applyRule($field, $rule)
    {
        $params = explode(':', $rule);
        $methodName = 'transmute' . ucfirst($params[0]);

        if (method_exists($this, $methodName)) {
            $this->$methodName($field, $params);
        } else {
            throw new DataStatusResponse( true, 0, [], 400, "Validation rule {$params[0]} does not exist.", ['status_msg' => 'warning'] );
        }
    }


    /**
     * @throws DataStatusResponse
     */
    protected function transmuteUppercase($field, $params)
    {
        if (!is_string($this->data[$field])) 
            throw new DataStatusResponse( true, 0, [], 400, "The {$field} must be a string.", ['status_msg' => 'warning'] );
        
        $this->data_response[$field] = mb_strtoupper($this->data[$field], 'UTF-8');
    }

    /**
     * @throws DataStatusResponse
     */
    protected function transmuteLowercase($field, $params)
    {
        if (!is_string($this->data[$field]))
            throw new DataStatusResponse( true, 0, [], 400, "The {$field} must be a string.",['status_msg' => 'warning'] );

        $this->data_response[$field] = mb_strtolower($this->data[$field], 'UTF-8');
    }

    protected function transmuteTrim($field, $params)
    {
        $result = rtrim($this->data[$field]);
		$result = ltrim($result);

        $this->data_response[$field] = $result;
    }

    protected function transmuteRemoveAccent($field, $params)
    {
        $caracteres = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'Á' => 'A',
            'É' => 'E',
            'Í' => 'I',
            'Ó' => 'O',
            'Ú' => 'U',
            'ñ' => 'n',
            'Ñ' => 'N'
            // Agrega más caracteres
        );

        $this->data_response[$field] = strtr($this->data[$field], $caracteres);
    }

    /**
     * @throws DataStatusResponse
     */
    protected function transmuteNumeric($field, $params)
    {
        if (!is_numeric($this->data[$field])) 
            throw new DataStatusResponse( true, 0, [], 400, "The {$field} must be a int.", ['status_msg' => 'warning'] );
        
        $this->data_response[$field] = (int) ( empty($this->data[$field]) ) ? 0 : $this->data[$field] ;
    }

}