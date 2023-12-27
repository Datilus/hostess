<?php
//session_start();

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Test extends Controller {

	private $controlador = "Test";

	private $modelLogin;

	public function __construct() 
    {
		$this->modelLogin = $this->model('LoginModel');
	}


	//Todo controlador debe tener un metodo index
	public function index() 
	{

        $items_level_up  = $this->modelLogin->crear_menu_2(['ban' => 4, 'search' => 1]);

        // print_r($items_level_up);

        $menu = [];
        foreach ($items_level_up as $item) 
        {
            // echo $item['id'];
            // echo $item['menu_padre_id'];
            $items_childs  = $this->modelLogin->crear_menu_2(['ban' => 5, 'search' => $item['id']]);

            echo $items_childs[0]['menu_padre_id'];
            // $padre = $items_childs[0]['menu_padre_id'];
            
            $res = $this->reestructura_parents($items_childs[0]['menu_padre_id'], $items_childs[0]['nivel']);
            
            // print_r($res);

        }

        

	}


    public function reestructura_parents($id_parent, $nivel, $parentId = null)
    {
        $item_parent = [];
        for ($i = 1; $i <= $nivel; $i++) {
            
            $item_parent = $this->modelLogin->crear_menu_2(['ban' => 2, 'search' => $id_parent, 'opciones' => ['tipo'=> "U"]]);
            print_r($item_parent);

            if ( $item_parent['menu_padre_id'] == $parentId ) {
                // echo "termina";
                return $item_parent;
            }else{
                $resultado = $this->reestructura_parents($item_parent['menu_padre_id'], $item_parent['nivel']);
                // $item_parent['child'] = $resultado;
            }
        }


    }


    /* public function reestructurarArray($array, $parentId = null) 
    {
        $result = array();
    
        foreach ($array as $item) {
            if ($item['menu_padre_id'] == $parentId) {

                $child = reestructurarArray($array, $item['id']);
        
                if (!empty($child)) {
                    $item['child'] = $child;
                }
                
                $result[] = $item;
            }
        }
    
        return $result;
    } */


	

}

?>