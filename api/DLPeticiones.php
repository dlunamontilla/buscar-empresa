<?php

/**
 * 
 * @see Creado el 24 de junio de 2019
 * @package DLPetitions
 * @author David E Luna M <davidlunamontilla@gmail.com>
 * @copyright (c) 2019 - David E Luna M
 * @version v0.0.1
 * 
 */

define("endl", "\n");

// CINCO CONSTANTE FUNDAMENTALES:
// Método de envío:
define("DL_GET", "get");
define("DL_POST", "post");

// Forma de tratar los campos recibidos:
define("DL_VOID", "vacio");
define("DL_FULL", "lleno");
define("DL_MIXED", "mezclado");

class DLPeticiones {
	// Propiedades (atributos) protegidas:
	protected $method = "";
	protected $empty = "";
	protected $list = [];

	/**
	 * __construct
	 *
	 * @param  String $method
	 * @param  String $empty
	 *
	 * @return void
	 */
	public function __construct(String $method, String $empty = DL_VOID) {
		if (empty(trim($method)))
			return false;

		// Se establece el método de envío y si está o no vacío.
		$this->method = $method;
		$this->empty = $empty;
	}

	// Se necesita conocer el método de envío del usuario 
	// y devolver un valor en su defecto si la petición es válida:
	private function metodo($modulo) {
		$metodos = [
			"get" => $_GET,
			"post" => $_POST
		];

		$metodo = strtolower($this->method);

		if (!array_key_exists($metodo, $metodos))
			return [];

		return $metodos[$metodo][$modulo];
	}

	// Comparar dos array
	protected function compare(array $arrayA, array $arrayB) {
		if (!is_array($arrayA) && (int) count($arrayA) <= 0)
			return false;

		if (!is_array($arrayB) && (int) count($arrayB) <= 0)
			return false;

		if ((int) count($arrayA) !== (int) count($arrayB))
			return false;

		$num = 0;
		foreach ($arrayA as $keyA => $valueA) {
			foreach ($arrayB as $keyB => $valueB) {
				if ($keyA == $keyB)
					$num++;
			}
		}

		if ($num !== count($arrayA) || $num !== count($arrayB))
			return false;

		return true;
	}

	public function validar($lists = []): bool {

		if (!is_array($lists))
			return false;

		// Devuelve false si no se detecta el método de envío:
		if (empty(trim($this->method)))
			return false;

		// Se determina el método de envío de la petición del 
		// usuario:
		switch (strtolower($this->method)) {
			case "get": // Si la instancia de clase es un get
				$this->list = $_GET;
				break;

			case "post": // Si la instancia de clase es un post
				$this->list = $_POST;
				break;
		}

		// Devuelve false si las peticiones están vacías, 
		// independientemente del método de envío:
		if (count($this->list) <= 0 || count($lists) <= 0)
			return false;

		if ($this->compare($this->list, $lists)) {
			foreach ($lists as $key => $empty) {
				if (!$empty)
					if (empty(trim($this->list[$key])))
						return false;
			}

			return true;
		}

		return false;
	}

	// PROCESAR TÍTULOS
	public function titulo(array $datos, $titulos = []) {
		if (!is_array($datos))
			return;

		if (count($datos) < 1)
			return "INICIO";

		if (!is_array($titulos))
			return;

		if (count($titulos) < 1)
			return;

		if ($this->validar($datos)) {
			foreach ($datos as $key => $value) {
				if (key_exists($key, $titulos))
					return $titulos[$key];
			}
		}
	}

	// Módulos
	public function modulo($string): bool {
		$peticion = [
			"$string" => true
		];

		return $this->validar($peticion);
	}

	// Devolver una cadena elegida en función del parámetro:
	public function cadena($modulos, string $string = ""): string {
		if ( is_array($modulos) && count($modulos) > 0 ) {
			if ( $this->validar( $modulos ) ) {
				return (string) $string;
			}
		}

		// Asegurarse que sea una cadena de caracteres:
		$modulos = (string) $modulos;

		// Devolver el valor por defecto:
		return (string) $this->modulo($modulos) ? $string : "";
	}

	// Una función para visualizar en los módulos señalados a través de un array:
	public function distribuirEnModulos( Array $modulos = [] ) : bool {
		if ( !is_array($modulos))
			return false;

		// Validar que los parámetros sean válidos:
		foreach( $modulos as $value ) {
			if ( is_array( $value ) && $this->validar($value)) {
				return true;
			}else {
				if ( $this->modulo( (string) $value ) ) {
					return true;
				}
			}
		}

		// Valor por defecto:
		return false;
	}

	// Obtener datos de las consultas, bien
	// sea get o post:
	public function obtenerDatos($modulo) {
		$peticion = [
			"$modulo" => false
		];

		return $this->validar($peticion) ? (string) $this->metodo($modulo) : (string) "";
	}
}