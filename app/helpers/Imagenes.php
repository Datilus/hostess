<?php

class Imagenes{

    // Guarda imagen
    public function guardaImagen($carpeta_subir, $nombre_archivo, $archivo)
    {
        $imageUploadPath = $carpeta_subir . $nombre_archivo;
        if (!file_exists($carpeta_subir)){
            mkdir($carpeta_subir, 0777, true);
        }

        //Comprimimos el fichero
        $compressedImage = $this->compressImage($archivo, $imageUploadPath, 95);

        if($compressedImage){ 
            $statusArchivo = true;
        }else{ 
            //$this->outputJSON('La compresion de la imagen ha fallado.','warning');
            $statusArchivo = false;
        }
        return $statusArchivo;
    }


    public function compressImage($source, $destination, $quality)
    { 
        // Obtenemos la información de la imagen
        $imgInfo = getimagesize($source); 
        $mime = $imgInfo['mime']; 
		
        // Creamos una imagen
        // A veces nos puede marcar error imagecreatefromjpeg ya que en php.ini no esta habilitada la extencion gd
        switch($mime){ 
            case 'image/jpeg': 
                $image = imagecreatefromjpeg($source); 
                break; 
            case 'image/png': 
                $image = imagecreatefrompng($source); 
                break; 
            case 'image/gif': 
                $image = imagecreatefromgif($source); 
                break; 
            default: 
                $image = imagecreatefromjpeg($source); 
        } 

        // Guardamos la imagen
        imagejpeg($image, $destination, $quality); 

        // Devolvemos la imagen comprimida
        return $destination; 
    }

}