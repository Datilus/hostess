<?php
// declare(strict_types=1);

class Usuario_
{
    private $ban;

    private $id_usuario = 0;
    private $id_perfil = 0;
    private $id_publicador = 0;
    private $usuario = "";
    private $password = "";

    public $dataReadParams;

    public function __construct()
    {
    }

    /**
     *
     * @param string  $ban
     */
    public function set_ban( string $ban ) 
    {
        $this->ban = $ban;
        return $this;
    }

    /**
     *
     * @param int  $id_usuario
     */
    public function set_id_usuario( int $id_usuario ) 
    {
        /* $data['id_usuario'] = $id_usuario;
        $format = new Format($data);
		$data = $format->transmute(['id_usuario'=>'numeric|trim']);
        $data = $format->get_data_response();

        $this->id_usuario = $data['id_usuario']; */

        $this->id_usuario = $id_usuario;
        return $this;
    }

    /**
     *
     * @param int  $id_perfil
     */
    public function set_id_perfil( int $id_perfil ) 
    {
        /* $data['id_perfil'] = $id_perfil;
        $format = new Format($data);
		$data = $format->transmute(['id_perfil'=>'numeric|trim']);
        $data = $format->get_data_response();

        $this->id_perfil = $data['id_perfil']; */

        $this->id_perfil = $id_perfil;
        return $this;
    }

    /**
     *
     * @param int  $id_publicador
     */
    public function set_id_publicador( int $id_publicador ) 
    {
        /* $data['id_publicador'] = $id_publicador;
        $format = new Format($data);
		$data = $format->transmute(['id_publicador'=>'numeric|trim']);
        $data = $format->get_data_response();

        $this->id_publicador = $data['id_publicador']; */

        $this->id_publicador = $id_publicador;
        return $this;
    }

    /**
     *
     * @param string $usuario
     */
    public function set_usuario( string $usuario ) 
    {
        /* $data['usuario'] = $usuario;
        $format = new Format($data);
		$data = $format->transmute(['usuario'=>'trim']);
        $data = $format->get_data_response();

        $this->usuario = $data['usuario']; */

        $this->usuario = $usuario;
        return $this;
    }

    /**
     *
     * @param string  $password
     */
    public function set_password( string $password ) 
    {
        /* $data['password'] = $password;
        $format = new Format($data);
		$data = $format->transmute(['password'=>'trim']);
        $data = $format->get_data_response();

        $this->password = ( !empty($data['password']) ) ? password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => 12]) : $data['password'] ; */

        $this->password = ( !empty($password) ) ? password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]) : $password ;
        return $this;
    }


    public function get_ban() 
    {
        return $this->ban;
    }

    public function get_id_usuario() 
    {
        return $this->id_usuario;
    }

    public function get_id_perfil() 
    {
        return $this->id_perfil;
    }

    public function get_id_publicador() 
    {
        return $this->id_publicador;
    }

    public function get_usuario() 
    {
        return $this->usuario;
    }

    public function get_password() 
    {
        return $this->password;
    }
    

    public function DataToCreate() 
    {
        $this->dataReadParams = [
            "ban"               => $this->get_ban(),
            "id_usuario"        => $this->get_id_usuario(),
            "id_perfil"         => $this->get_id_perfil(),
            "id_publicador"     => $this->get_id_publicador(),
            "usuario"           => $this->get_usuario(),
            "password"          => $this->get_password(),
            "id_usuario_accion" => ( empty($_SESSION["datos_usuario"]["ID_USUARIO"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_USUARIO"],
            "search"            => "",
            "values"            => ""
        ];

        return $this;
    }

    public function DataToGetUsuarioById() 
    {
        $this->dataReadParams = [
            "ban"      => 3,
            "search"   => $this->get_id_usuario()
        ];

        return $this;
    }

    /**
     *
     * @param string $ban  
     */
    public function DataToGetByConcatString(string $string) 
    {
        $this->dataReadParams = [
            "ban"      => $this->get_ban(),
            "search"   => $string
        ];

        return $this;
    }

    /**
     *
     * @param array $data_config_table  
     */
    public function DataToGetDataList(array $data_config_table) 
    {
        $this->dataReadParams = [
            "ban"    => $this->get_ban(),
            "row"    => $data_config_table['row'],
            "rows"   => $data_config_table['rows'],
            "search" => $data_config_table['search'],
        ];

        return $this;
    }

}

?>