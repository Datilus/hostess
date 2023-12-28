<?php

/*
Reglas de validación

required:             El campo es obligatorio.
string:               El campo debe ser una cadena de texto.
noSpecialCharacters:  No se permiten caracteres especiales en el string
*/
class Validator
{
    protected $data;
    protected $errors = [];
    protected $customFieldNames = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function validate(array $rules, array $customFieldNames = [])
    {
        $this->customFieldNames = $customFieldNames;
        
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
        $methodName = 'validate' . ucfirst($params[0]);

        if (method_exists($this, $methodName)) {
            $this->$methodName($field, $params);
        } else {
            // throw new \Exception("Validation rule {$params[0]} does not exist.");
            throw new DataStatusResponse( true, 0, [],203, "Validation rule {$params[0]} does not exist.", ['status_msg' => 'warning'] );
        }
    }


    /**
     * @throws DataStatusResponse
     */
    protected function validateRequired($field, $params)
    {
        if (!isset($this->data[$field]) || empty($this->data[$field]))
            throw new DataStatusResponse( true, 0, [], 203, "The {$this->getFieldName($field)} field is required.", ['status_msg' => 'warning'] );
    }

    /**
     * @throws DataStatusResponse
     */
    protected function validateString($field, $params)
    {
        if (!is_string($this->data[$field])) 
            throw new DataStatusResponse( true, 0, [], 203, "The {$this->getFieldName($field)} must be a string.", ['status_msg' => 'warning'] );
    }

    /**
     * @throws DataStatusResponse
     */
    protected function validateInt($field, $params)
    {
        if (!is_int($this->data[$field])) 
            throw new DataStatusResponse( true, 0, [], 203, "The {$this->getFieldName($field)} must be a int.", ['status_msg' => 'warning'] );
    }

    /**
     * @throws DataStatusResponse
     */
    protected function validateEmail($field, $params)
    {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL))
            throw new DataStatusResponse( true, 0, [], 203, "The {$this->getFieldName($field)} must be a valid email address.", ['status_msg' => 'warning'] );
    }

    /**
     * @throws DataStatusResponse
     */
    protected function validateMin($field, $params)
    {
        $minLength = (int) $params[1];

        if (strlen($this->data[$field]) < $minLength)
            throw new DataStatusResponse( true, 0, [], 203, "The {$this->getFieldName($field)} must be at least {$minLength} characters.", ['status_msg' => 'warning'] );
    }

    /**
     * @throws DataStatusResponse
     */
    protected function validateMax($field, $params)
    {
        $maxLength = (int) $params[1];

        if (strlen($this->data[$field]) > $maxLength) 
            throw new DataStatusResponse( true, 0, [], 203, "The {$this->getFieldName($field)} must be at least {$maxLength} characters.", ['status_msg' => 'warning'] );
    }

    protected function validateAlpha($field, $params)
    {
        if (!ctype_alpha($this->data[$field])) {
            // $this->addError($field, "The {$field} may only contain letters.");
        }
    }

    protected function validateAlphaDash($field, $params)
    {
        if (!preg_match('/^[\p{L}\p{N}_-]+$/u', $this->data[$field])) {
            // $this->addError($field, "The {$field} may only contain letters, numbers, underscores, and dashes.");
        }
    }

    protected function validateAlphaNum($field, $params)
    {
        if (!ctype_alnum($this->data[$field])) {
            // $this->addError($field, "The {$field} may only contain letters and numbers.");
        }
    }

    /**
     * @throws DataStatusResponse
     */
    protected function validateNoSpecialCharacters($field, $params)
    {
		if (!empty($this->data[$field])) {
			if (is_null(json_decode($this->data[$field]))) { // Por si pasamos un string en formato json nos lo deje pasar
				if (!preg_match('/^[0-9a-zA-Z\-ñÑáéíóúÁÉÍÓÚ@()+.,_ ]+$/', $this->data[$field])){
					throw new DataStatusResponse( true, 0, [], 203, "El campo {$this->getFieldName($field)} tiene caracteres especiales no permitidos.", ['status_msg' => 'warning'] );
				}
			}
		}
    }

    protected function getFieldName($field)
    {
        return $this->customFieldNames[$field] ?? $field;
    }

    // protected function addError($field, $message)
    // {
    //     $this->errors[$field][] = $message;
    // }
}