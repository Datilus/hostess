<?php

class UsuarioService
{
    private $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function getAllUsers()
    {
        // return $this->userRepository->all();
    }


    public function getUserById($data)
    {
        $format = new Format($data);
		$data = $format->transmute([
            'id_usuario'    => 'numeric|trim'
		]);
        $data = $format->get_data_response();


        $validator = new Validator($data);
		$validator->validate([
			'id_usuario'    => 'noSpecialCharacters'
		]);

        return $this->usuarioRepository->find( $data['id_usuario'] );
    }


    public function userDataModel()
    {
        return [
			'id_perfil'     => 0,
			'id_publicador' => 0,
			'usuario'       => '',
			'password'      => '',
            'id_usuario'    => 0,
        ];
    }


    public function createUser(array $data)
    {
        $format = new Format($data);
		$data = $format->transmute([
            'id_usuario'    => 'numeric|trim',
            'id_perfil'     => 'numeric|trim',
            'id_publicador' => 'numeric|trim',
            'usuario'       => 'trim',
            'password'      => 'trim'
		]);
        $data = $format->get_data_response();

        
        $validator = new Validator($data);
		$validator->validate([
			'id_usuario'    => 'noSpecialCharacters',
			'id_perfil'     => 'required|noSpecialCharacters',
			'id_publicador' => 'required|noSpecialCharacters',
			'usuario'       => 'required|string|noSpecialCharacters',
			'password'      => 'required|string|noSpecialCharacters'
		],
        [
			'id_perfil'     => 'perfil',
			'id_publicador' => 'publicador',
			'usuario'       => 'usuario',
			'password'      => 'password'
        ]);

        if ( $this->usuarioRepository->findUserExist($data['usuario']) == true )
            throw new DataStatusResponse( true, 0, "El usuario ya existe, elegir otro.", 203, ['status_msg' => 'warning'] );

        $response = $this->usuarioRepository->create($data);

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        throw new DataStatusResponse( $response['ERROR'], 0, 'Usuario guardado.', 201, ['status_msg' => $status_msg] );
    }


    public function updateUser(array $data)
    {
        $format = new Format($data);
		$data = $format->transmute([
            'id_usuario'    => 'numeric|trim',
            'id_perfil'     => 'numeric|trim',
            'id_publicador' => 'numeric|trim',
            'usuario'       => 'trim',
            'password'      => 'trim'
		]);
        $data = $format->get_data_response();


        $validator = new Validator($data);
		$validator->validate([
			'id_usuario'    => 'noSpecialCharacters',
			'id_perfil'     => 'required|noSpecialCharacters',
			'id_publicador' => 'required|noSpecialCharacters',
			'usuario'       => 'required|string|noSpecialCharacters',
			'password'      => 'string|noSpecialCharacters'
		],
        [
			'id_perfil'     => 'perfil',
			'id_publicador' => 'publicador',
			'usuario'       => 'usuario',
			'password'      => 'password'
        ]);

        $response = $this->usuarioRepository->create($data);

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        throw new DataStatusResponse( $response['ERROR'], 0, 'Usuario guardado.', 201, ['status_msg' => $status_msg] );
    }


    public function deleteUser($data)
    {
        $format = new Format($data);
		$data = $format->transmute([
            'id_usuario'    => 'numeric|trim'
		]);
        $data = $format->get_data_response();


        $validator = new Validator($data);
		$validator->validate([
			'id_usuario'    => 'noSpecialCharacters'
		]);

        $response = $this->usuarioRepository->delete($data['id_usuario']);

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;

        // new ViewDataTest( $this->data );
        throw new DataStatusResponse( $response['ERROR'], 0, 'Usuario borrado.', 201, ['status_msg' => $status_msg] );
    }


    // public function authenticateUser($username, $password)
    public function authenticateUser($data)
    {
        $format = new Format($data);
		$data = $format->transmute([
			'username' => 'trim|uppercase',
			'password' => 'trim'
		]);
        $data = $format->get_data_response();

        $validator = new Validator($data);
		$validator->validate([
			'username' => 'required|string|noSpecialCharacters',
			'password' => 'required|string|noSpecialCharacters'
		],
        [
            'username' => 'usuario',
			'password' => 'contraseña'
        ]);


        $data_user_access = $this->usuarioRepository->findByConcatString(1, $data['username']);

        if ( empty($data_user_access) )
            throw new DataStatusResponse( true, 0, 'Este usuario no existe.', 203 );

        if ( $data_user_access['ESTATUS_USUARIO'] != "USRACT" || $data_user_access['ESTATUS_PUBLICADOR'] != "PUBACT" )
            throw new DataStatusResponse( true, 0, 'No cuentas con acceso al sistema.', 203 );

        if ( password_verify($data['password'], $data_user_access["PASS"]) === false ) {
            session_unset();
			session_destroy();
            throw new DataStatusResponse( true, 0, 'Contraseña incorrecta.', 203 );
        }

        $data_user = $this->usuarioRepository->findByConcatString(2, $data_user_access['ID_USUARIO']);

        $_SESSION["token"] = md5(uniqid(mt_rand(), true));
        $_SESSION["datos_usuario"] = $data_user;

        $_SESSION["menu_perfil"]  = $this->crear_menu( $data_user["ID_PERFIL"] );
        $_SESSION["permisos"] = json_decode( $this->usuarioRepository->findByPermissionsByProfile(1, $data_user["ID_PERFIL"])[0]['json_permisos'], true);

        throw new DataStatusResponse( false, 0, 'Acceso correcto.', 201, ['session_on' => true] );
    }


    # Menu Perfil Usuario
    public function crear_menu( $id_perfil ) 
    {
        $items_childs = $this->usuarioRepository->findItemsMenuByProfile(1, $id_perfil);

        $array = [];
        foreach( $items_childs as $item_child )
        {
            $ruta_nivel = json_decode($item_child['ruta_nivel'], true);
            
            foreach( $ruta_nivel as $id )
            {
                $array[] = $this->usuarioRepository->findItemsMenuByProfile(2, $id)[0];
            }

        }

        $tree = $this->buildTree($array);

        uasort($tree, function ($a, $b) {
            if ($a['orden'] == $b['orden']) {
                return 0;
            }
            return ($a['orden'] < $b['orden']) ? -1 : 1;
        }); 

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


    public function getDataTableList($data)
    {
        $data_list = $this->usuarioRepository->getAllDataTableList(1, $data);

        $data = json_decode($data_list['JSON_DATA_LIST'], true);

		// --- Pintamos los datos en la datatable
		foreach ($data['data_list'] as $value) {

			// Acciones
			$acciones = "
			<div class='margin'>
				<div class='btn-group'>
					<button type='button' class='btn btn-default btn-xs pt-0 pb-0' data-toggle='dropdown' aria-expanded='true' style='font-size: 9px;'>
						<span class='fa fa-ellipsis-h'></span>
					</button>
					<div class='dropdown-menu dropdown-menu-right' role='menu'>";

			// if ( in_array(5, $_SESSION["permisos"]) === true ){
			$acciones .= "
						<small>
							<a class='dropdown-item text-muted nav-link' href='#' name='editar' data-id_usuario='". intval($value['id']) ."'>Editar</a>
						</small>
			";
			// }

			// if ( in_array("DELCON", $_SESSION["permisos"]) === true ){
			$acciones .= "
						<small>
							<a class='dropdown-item text-muted' href='#' name='borrar' data-id_usuario='". intval($value['id']) ."'>Borrar</a>
						</small>
			";
			// }

			$acciones .= "
					</div>
				</div>
			</div>
			";

			$subdatos = array();
			$subdatos[] = $value['id'];
			$subdatos[] = $value['perfil'];
			$subdatos[] = $value['usuario'];
			$subdatos[] = $value['publicador'];
			$subdatos[] = $acciones;
			$datos[] = $subdatos;
		}

		$json_data = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $data['total_data'],
			"recordsFiltered" => $data['total_filter'],
			"data" => $datos
		);
		
		echo json_encode($json_data);
    }
}