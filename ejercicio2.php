<?php
abstract class Estadistica {
    abstract public function calcularMedia($datos);
    abstract public function calcularMediana($datos);
    abstract public function calcularModa($datos);
}

class EstadisticaBasica extends Estadistica {
    public function calcularMedia($datos) {
        return array_sum($datos) / count($datos);
    }

    public function calcularMediana($datos) {
        sort($datos);
        $mid = floor((count($datos) - 1) / 2);
        return (count($datos) % 2) ? $datos[$mid] : ($datos[$mid] + $datos[$mid + 1]) / 2;
    }

    public function calcularModa($datos) {
        $frecuencias = array_count_values($datos);
        arsort($frecuencias);
        return key($frecuencias);
    }

    public function generalInforme($conjuntos) {
        $resultado = [];
        foreach ($conjuntos as $nombre => $datos) {
            $resultado[$nombre] = [
                'media' => $this->calcularMedia($datos),
                'mediana' => $this->calcularMediana($datos),
                'moda' => $this->calcularModa($datos)
            ];
        }
        return $resultado;
    }
}

// Interacción por consola
$conjuntos = [];
$numConjuntos = (int)readline("Número de conjuntos: ");

for ($i = 1; $i <= $numConjuntos; $i++) {
    $nombre = readline("\nNombre conjunto $i: ");
    $valores = explode(',', readline("Valores (separados por coma): "));
    $conjuntos[$nombre] = array_map('floatval', $valores);
}

$estadistica = new EstadisticaBasica();
print_r($estadistica->generalInforme($conjuntos));