<?php


# Setters
# Getters
# Proceso Sesión
# Menu Perfil Usuario


class _Login extends Controller {

    private $dataValidate;

    private $modelLogin;

    private $classUsuario;

    /**
     * Login data.
     *
     * @var array
     */
    protected $data = array(
        'usuario' => '',
        'password' => ''
    );

    public function __construct()
    {
        $this->dataValidate = new DataValidate();
        $this->modelLogin = $this->model('LoginModel');
        $this->classUsuario = new _Usuario();
	}


    # Setters

    /**
     *
     * @param string  $usuario  Nombre de usuario
     */
    public function set_usuario( $usuario ) 
    {
        $params_value = [
            'value' => $usuario,
            'name' => 'usuario',
            'is_required' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['usuario'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }

    /**
     *
     * @param string  $password  Password de acceso del usuario
     */
    public function set_password( $password ) 
    {
        $params_value = [
            'value' => $password,
            'name' => 'password',
            'is_required' => true
        ];
        $options_rules = array_merge($this->dataValidate->params_value, $params_value);

        $this->data['password'] = $this->dataValidate->rules_value($options_rules);

        return $this;
    }


    # Getters

    public function get_usuario() 
    {
        return $this->data['usuario'];
    }

    public function get_password() 
    {
        return $this->data['password'];
    }


    # Proceso Sesión

    public function inicio_sesion( $data_array ) 
    {
        $data_array['usuario'] = ( isset($data_array['usuario']) ) ? $data_array['usuario'] : '' ;
        $this->set_usuario($data_array['usuario']);

        $data_array['password'] = ( isset($data_array['password']) ) ? $data_array['password'] : '' ;
        $this->set_password($data_array['password']);

        $this->classUsuario->existe_usuario( $data_array['usuario'] );

        $this->classUsuario->usuario_acceso( $data_array['usuario'] );

        $datos_usuario_acceso = $this->classUsuario->obtener_usuario( 1, $data_array['usuario'] );

		if ( password_verify($this->get_password(), $datos_usuario_acceso["PASS"]) ) {

            session_unset();
			// session_destroy();

            $datos_usuario = $this->classUsuario->obtener_usuario( 2, $datos_usuario_acceso["ID_USUARIO"] );

            $_SESSION["token"] = md5(uniqid(mt_rand(), true));
            $_SESSION["datos_usuario"] = $datos_usuario;
            // $_SESSION["menu_perfil"]  = $this->modelLogin->crear_menu(['ban' => 1, 'id_perfil' => $datos_usuario_acceso["ID_PERFIL"]]);
            $_SESSION["menu_perfil"]  = $this->crear_menu( $datos_usuario_acceso["ID_PERFIL"] );

            $permisos = $this->modelLogin->obtener_permisos(['ban'=> 1, 'search' => $datos_usuario_acceso["ID_PERFIL"], "opciones" => ["tipo" => "U"] ]);
            $_SESSION["permisos"] = json_decode($permisos['json_permisos'], true);

            // print_r($_SESSION["menu_perfil"]);

            throw new DataStatusResponse( false, 0, 'Acceso correcto.', 201, ['session_on' => true] );

		}else {

			session_unset();
			session_destroy();

            throw new DataStatusResponse( true, 0, 'Contraseña incorrecta.', 203 );
		}
    }

    /* public function cerrar_sesion()
	{
		session_unset();
		session_destroy(); 

		throw new DataStatusResponse( false, 0, 'Sesión cerrada.', 201, ['session_on' => false] );
	} */



    # Menu Perfil Usuario
    public function crear_menu( $id_perfil ) 
    {
        $items_childs = $this->modelLogin->obtener_items_menu(['ban' => 1, 'search' => $id_perfil]);

        $array = [];
        foreach( $items_childs as $item_child )
        {
            $ruta_nivel = json_decode($item_child['ruta_nivel'], true);

            // $base_ruta = "";
            
            foreach( $ruta_nivel as $id )
            {
                // $base_ruta .= "[".$id."]['child']";
                $array[] = $this->modelLogin->obtener_items_menu(['ban' => 2, 'search' => $id, "opciones" => ["tipo" => "U"]]);
            }

        }

        $tree = $this->buildTree($array);

        uasort($tree, function ($a, $b) {
            if ($a['orden'] == $b['orden']) {
                return 0;
            }
            return ($a['orden'] < $b['orden']) ? -1 : 1;
        }); 

        // print_r($tree);
        return $tree;

    }

    // Crea una función recursiva para construir el árbol
    public function buildTree($items, $parentId = NULL) 
    {
        $tree = array();
        foreach ($items as $item) {
            if ($item['menu_padre_id'] == $parentId) {
                $children = $this->buildTree($items, $item['id']);
                if ($children) {
                    $item['child'] = $children;
                }
                $tree[$item['id']] = $item;
                // $tree[] = $item;
            }
        }
        return $tree;
    }

}