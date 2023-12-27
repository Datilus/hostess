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
        $items_childs = $this->modelLogin->crear_menu_2(['ban' => 1, 'search' => 1]);

        $array = [];
        foreach( $items_childs as $item_child )
        {
            $ruta_nivel = json_decode($item_child['ruta_nivel'], true);

            $base_ruta = "";
            
            foreach( $ruta_nivel as $id )
            {
                $base_ruta .= "[".$id."]['child']";
                $array[] = $this->modelLogin->crear_menu_2(['ban' => 2, 'search' => $id, "opciones" => ["tipo" => "U"]]);
            }

        }

        $tree = $this->buildTree($array);

        uasort($tree, function ($a, $b) {
            if ($a['orden'] == $b['orden']) {
                return 0;
            }
            return ($a['orden'] < $b['orden']) ? -1 : 1;
        }); 

        print_r($tree);

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

?>