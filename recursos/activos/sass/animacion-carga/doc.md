# Animacion Carga

Al siguiente fragmento de código:

```xml
<div class="caja giro-constante" id="animacion-carga">
  <svg viewBox="0 0 140 140" class="lienzo giro-intervalo">
    <circle class="cir cir--fijo" cx="70" cy="70" r="65" />
    <circle class="cir cir--completando giro-trazo" cx="70" cy="70" r="65" />
  </svg>
</div>
```

Se le debe aplicar el siguiente estilo:

- [animacion.css](animacion.css) (versión transpilada).
- [animations.scss](animations.scss) (versión original).

Para instalarlo en tu proyecto utilizando `Git` puede escribir:

```shell
git clone https://github.com/dlunamontilla/fragmentos.git
```

Puede cambiar el tamaño utilizando un estilo personalizado.

Es decir:

```css
.size {
  --diametro: 40px;
  --color: #0080d4;
}
```

Donde `--diametro: 40px` es el tamaño personalizado que le aplicó. 

Puede leer [¿Cómo hacer un cargador similar? HTML y CSS?][explicacion]. Allí se encuentra resdactada toda la explicación de cómo fue creada esta animación.

[explicacion]: https://es.stackoverflow.com/questions/329419/c%c3%b3mo-hacer-un-cargador-similar-html-y-css/331211#331211 "¿Cómo hacer un cargador similar? HTML y CSS"
