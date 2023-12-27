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

        $items_permitidos  = $this->modelLogin->crear_menu_2(['ban' => 1, 'search' => 1]);

        // print_r($items_permitidos);

        /* function buildMenu($menuItems, $itemsPermitidos, $parentId = null)
        {
            $menu = [];

            foreach ($itemsPermitidos as $itemId) {
                $item = $menuItems[$itemId];

                if ($item['menu_padre_id'] == $parentId) {
                    $submenu = buildMenu($menuItems, $itemsPermitidos, $item['id']);

                    if (!empty($submenu)) {
                        $item['submenu'] = $submenu;
                    }

                    $menu[] = $item;
                }
            }

            return $menu;
        }

        $menuPermitido = buildMenu($menu_items, $items_permitidos); */


        /* function buildMenu($item_hijo, $id_padre, $modelLogin)
        {
            $item_padre  = $modelLogin->crear_menu_2(['ban' => 2, 'search' => $id_padre['menu_padre_id']]);

            if ( !empty($item_padre['menu_padre_id']) ){

                $item_padre['child'] = $item_hijo;
                // buildMenu($item_padre, $item_padre['menu_padre_id']);
            }else{

            }

            return $item_padre;
        } */

        function reestructurarArray($array, $parentId = null) {
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
        }

        //$menu = [];
        $merged = [];
        foreach ($items_permitidos as $item) 
        {

            // $items_padre = $this->modelLogin->crear_menu_2(['ban' => 2, 'search' => $item['menu_padre_id']]);

            // print_r($items_padre);

            // $menu[] = buildMenu($item, $item['menu_padre_id'], $this->modelLogin);
            // echo $item['ruta_nivel'];
            $ruta_nivel = json_decode($item['ruta_nivel'], true);
            $items_tree = [];
            // $indice = 0;
            foreach($ruta_nivel as $id_padre)
            {

                $items_tree[] = $this->modelLogin->crear_menu_2(['ban' => 2, 'search' => $id_padre, "opciones" => ["tipo" => "U"] ]);

                // $items_padre['child'] = $item;

                //$items_padre[0]['child'] = $items_padre;

                // print_r($items_padre);
                // $indice++;
            }

            // print_r($items_tree);

            
            $reestructuradoArray = reestructurarArray($items_tree);
            
            print_r($reestructuradoArray);

            // $merged = array_merge_recursive($merged, $reestructuradoArray);

            
        }

        // print_r($merged);


        // $mergedArray = array_merge_recursive($mergedArray, $array);


	}


	

}

?>