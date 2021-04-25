<?php

$include = __DIR__ . "/config.php";

if ( !file_exists($include)) {
    echo "Copie el archivo <strong>config.php.sample</strong> a <strong>config.php</strong> y le colocas la ruta de la API y la API";
    exit;
}

include $include;
include __DIR__ . "/DLPeticiones.php";

class Buscar {
    private $apiPath = API_PATH;
    private $apiKey = API_KEY;
    private $headers = "";
    private $contexto = "";
    private $param = "";
    private $peticiones = "";

    public  function __construct($method = "get", $modulo = "empresa") {
        
        $this->peticiones = new DLPeticiones(strtolower((string) $method));
        $this->param = $modulo;

        $this->headers = [
            "http" => [
                'method' => "GET",
                'header' => "Authorization: Basic " . base64_encode("$this->apiKey") . "\r\n"
            ]
        ];

        $this->contexto = stream_context_create($this->headers);
    }

    private function obtenerDatos(string $empresa) : string {
        if ( !isset($empresa) || empty($empresa))
            return "{}";

        $datos = (string) file_get_contents($this->apiPath . "$empresa", false, $this->contexto);
        return (string) $datos;
    }

    // Devolver datos en formato JSON en la pantalla:
    public function ponerDatos() {
        $empresa = $this->peticiones->obtenerDatos($this->param);
        $datos = empty($empresa) ? "{}" : $this->obtenerDatos($empresa);
        header("Content-Type: application/json; charset=utf-8");
        echo (string) $datos;
    }
}
// Probar la clase
$buscarEmpresa = new Buscar("post");
$buscarEmpresa->ponerDatos();