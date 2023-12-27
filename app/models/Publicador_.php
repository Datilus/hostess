<?php
// declare(strict_types=1);

class Publicador_
{
    private $ban;

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

    public function get_ban() 
    {
        return $this->ban;
    }

    /**
     *
     * @param int  $id_congregacion  Número ID de la Congregación a la que pertenece el publicador
     */
    public function set_id_congregacion( int $id_congregacion )
    {
        $this->id_congregacion = $id_congregacion;
        return $this;
    }

    public function get_id_congregacion() 
    {
        return $this->id_congregacion;
    }
    
    /**
     *
     * @param string $ban  
     */
    public function DataToGetPublicadorById() 
    {
        $this->dataReadParams = [
            "ban"      => 1,
            "search"   => $this->id_usuario
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
            "ban"             => $this->get_ban(),
            "id_congregacion" => $this->get_id_congregacion(),
            "row"             => $data_config_table['row'],
            "rows"            => $data_config_table['rows'],
            "search"          => $data_config_table['search'],
        ];

        return $this;
    }

}

?>