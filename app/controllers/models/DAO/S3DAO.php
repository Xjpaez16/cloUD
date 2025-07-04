<?php
require_once(__DIR__ . '/../DTO/S3DTO.php');
require_once(__DIR__ . '/../../../../vendor/autoload.php');

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class S3DAO {
    private $bucket;
    private $s3;

    public function __construct() {
        // Cargar configuración desde config.php
        
        $config = require __DIR__ . '/../../../../config.php';
     


        // Asignar bucket
        $this->bucket = $config['aws']['bucket'];

        // Instanciar cliente S3
        $this->s3 = new S3Client([
            'version'     => 'latest',
            'region'      => $config['aws']['region'],
            'credentials' => [
                'key'    => $config['aws']['key'],
                'secret' => $config['aws']['secret'],
            ]
        ]);
    }

    public function uploadFile($archivo) {
        try {
            $nombre = basename($archivo['name']);
            $archivoTmp = $archivo['tmp_name'];
            $tipo = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

            $resultado = $this->s3->putObject([
                'Bucket'      => $this->bucket,
                'Key'         => 'uploads/' . $nombre,
                'SourceFile'  => $archivoTmp,
                'ContentType' => mime_content_type($archivoTmp),
                'ACL'         => 'public-read',
            ]);

            $s3dto = new S3DTO();
            $s3dto->setNombre($nombre);
            $s3dto->setTipo($tipo);
            $s3dto->setTamaño($archivo['size']);
            $s3dto->setUrl($resultado['ObjectURL']);

            return $s3dto;

        } catch (AwsException $e) {
            echo "❌ Error al subir el archivo: " . $e->getMessage();
            return null;
        }
    }

    public function viewfiles() {
        $archivos = [];

        try {
            $resultado = $this->s3->listObjectsV2([
                'Bucket' => $this->bucket,
                'Prefix' => 'uploads/',
            ]);

            if (isset($resultado['Contents'])) {
                foreach ($resultado['Contents'] as $objeto) {
                    $key = $objeto['Key'];
                    if ($key === 'uploads/') continue;

                    $info = $this->s3->headObject([
                        'Bucket' => $this->bucket,
                        'Key'    => $key
                    ]);

                    $url = $this->s3->getObjectUrl($this->bucket, $key);
                    $dto = new S3DTO(
                        basename($key),
                        pathinfo($key, PATHINFO_EXTENSION),
                        $info['ContentLength'],
                        $url
                    );

                    $archivos[] = $dto;
                }
            }
        } catch (AwsException $e) {
            throw new Exception('❌ Error al traer los archivos: ' . $e->getMessage());
        }

        return $archivos;
    }
    public function getfile($filename){
        error_log('nombre : ' . $filename .'');
        try{
            return $this->s3->getObject([
                'Bucket' => $this->bucket,
                'Key'    => $filename
            ]);
        }catch (AwsException $e) {
            throw new Exception('❌ Error al traer el archivo: ' . $e->getMessage());
        }
        
    }

}
?>
