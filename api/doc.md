# Uso de la API

## La clase Buscar

La sintaxis de la clase Buscar es:

``` php
Buscar::__construct($method = "get", $modulo = "empresa");
```

Es decir, que los parámetros del constructor tiene como argumento por defecto lo observado en la sintaxis anterior.

**`$method`:** tiene dos posibles valores:

- El método de envío `GET`. Este método es el que tiene por defecto.
- El método de envío `POST`.

**`$modulo`:** es el nombre del campo del formulario. El nombre por defecto es `empresa`. Sin embargo, puede poner cualquier otro campo. 

Uso de la clase **`Buscar`:**

``` php
$buscarEmpresa = new Buscar;
$buscarEmpresa->ponerDatos();
```

Si en cambio, obtener los datos mediante el método `POST` puede utilizarlo de la siguiente manera:

``` php
// Probar la clase
$buscarEmpresa = new Buscar("post");
$buscarEmpresa->ponerDatos();
```

O de esta otra manera, donde especifique de forma explícita el método de envío del formulario (en este caso `POST`) y el nombre del campo del formulario:

``` php
$buscarEmpresa = new Buscar("post", "name");
```

Donde `"post"` es el método de envío del formulario y `"name"` es el nombre del campo del formulario que hace la consulta.