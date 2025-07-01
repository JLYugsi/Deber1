<?php
abstract class PolinomioAbstracto {
    abstract public function evaluar($x);
    abstract public function derivada();
}

class Polinomio extends PolinomioAbstracto {
    protected $terminos;

    public function __construct($terminos) {
        $this->terminos = $terminos;
        krsort($this->terminos); // Ordenar por grado descendente
    }

    public function evaluar($x) {
        $resultado = 0;
        foreach ($this->terminos as $grado => $coef) {
            $resultado += $coef * pow($x, $grado);
        }
        return $resultado;
    }

    public function derivada() {
        $derivada = [];
        foreach ($this->terminos as $grado => $coef) {
            if ($grado > 0) {
                $derivada[$grado - 1] = $coef * $grado;
            }
        }
        return new Polinomio($derivada);
    }

    public function sumarPolinomios($p1, $p2) {
        $suma = [];
        foreach ([$p1, $p2] as $polinomio) {
            foreach ($polinomio as $grado => $coef) {
                $suma[$grado] = ($suma[$grado] ?? 0) + $coef;
            }
        }
        krsort($suma);
        return $suma;
    }

    public function __toString() {
        $str = "";
        foreach ($this->terminos as $grado => $coef) {
            $str .= ($coef >= 0 ? " +" : " ") . $coef . "x^" . $grado;
        }
        return $str;
    }
}

// Interacción por consola
function leerPolinomio($nombre) {
    $terminos = [];
    $numTerminos = (int)readline("Número de términos para $nombre: ");
    
    for ($i = 0; $i < $numTerminos; $i++) {
        $grado = (int)readline("Grado: ");
        $coef = (float)readline("Coeficiente: ");
        $terminos[$grado] = $coef;
    }
    return $terminos;
}

$p1 = leerPolinomio("Polinomio 1");
$p2 = leerPolinomio("Polinomio 2");

$polinomio = new Polinomio([]);
$suma = $polinomio->sumarPolinomios($p1, $p2);

echo "Suma: " . (new Polinomio($suma)) . "\n";
echo "Evaluar P1 en x=2: " . (new Polinomio($p1))->evaluar(2) . "\n";
echo "Derivada P2: " . (new Polinomio($p2))->derivada();