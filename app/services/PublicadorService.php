<?php

class PublicadorService
{
    private $publicadorRepository;

    public function __construct()
    {
        $this->publicadorRepository = new PublicadorRepository();
    }

    public function getAllPublicadores()
    {
    }

    public function getPublicadorById($id)
    {
    }

    public function createPublicador(array $data)
    {
    }

    public function updatePublicador($id, array $data)
    {
    }

    public function deletePublicador($id)
    {
    }


    public function getDataTableListCatalogo(array $data)
    {
        $id_congregacion = ( empty($_SESSION["datos_usuario"]["ID_CONGREGACION"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_CONGREGACION"];
        $data_list = $this->publicadorRepository->findAllDataTableListCatalogo(2, $id_congregacion, $data);

        $data = json_decode($data_list['JSON_DATA_LIST'], true);
		
		foreach ($data['data_list'] as $value) {
			$subdatos = array();
			$subdatos[] = $value['id'];
			$subdatos[] = $value['publicador'];
			$subdatos[] = "<i class='fas fa-plus-circle add' style='font-size:12px; cursor: pointer;' ></i>";
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