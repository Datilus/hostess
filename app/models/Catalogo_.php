<?php
// declare(strict_types=1);

class Catalogo_
{
    private $ban;

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
     * @param string $ban  
     */
    public function DataToGetByConcatString(string $concatString = '') 
    {
        $this->dataReadParams = [
            "ban"      => $this->get_ban(),
            "search"   => $concatString
        ];

        return $this;
    }

}

?>