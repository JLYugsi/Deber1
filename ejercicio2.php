<?php
abstract class Estadistica {
    abstract public function calcularMedia(array $datos): float;
    abstract public function calcularMediana(array $datos): float;
    abstract public function calcularModa(array $datos): float;
}

class EstadisticaBasica extends Estadistica {
    public function calcularMedia(array $datos): float {
        $this->validarDatos($datos);
        return array_sum($datos) / count($datos);
    }

    public function calcularMediana(array $datos): float {
        $this->validarDatos($datos);
        sort($datos);
        $mid = (int)(count($datos) / 2);
        return (count($datos) % 2 === 0) 
            ? ($datos[$mid - 1] + $datos[$mid]) / 2 
            : $datos[$mid];
    }

    public function calcularModa(array $datos): float {
        $this->validarDatos($datos);
        $frecuencias = array_count_values(array_map('strval', $datos));
        arsort($frecuencias);
        return (float)key($frecuencias);
    }

    public function generalInforme(array $conjuntos): array {
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

    private function validarDatos(array $datos): void {
        if (count($datos) === 0) {
            throw new InvalidArgumentException("Conjunto de datos vacío");
        }
        foreach ($datos as $valor) {
            if (!is_numeric($valor)) {
                throw new InvalidArgumentException("Valor no numérico encontrado");
            }
        }
    }
}

// Interacción
$conjuntos = [];
$num = (int)readline("Número de conjuntos: ");

for ($i = 1; $i <= $num; $i++) {
    $nombre = readline("\nNombre conjunto $i: ");
    $valores = explode(',', readline("Valores (separados por coma): "));
    $conjuntos[$nombre] = array_map('floatval', $valores);
}

try {
    $estadistica = new EstadisticaBasica();
    $informe = $estadistica->generalInforme($conjuntos);
    
    foreach ($informe as $nombre => $metricas) {
        echo "\n$nombre:\n";
        echo "Media: " . round($metricas['media'], 2) . "\n";
        echo "Mediana: " . round($metricas['mediana'], 2) . "\n";
        echo "Moda: " . round($metricas['moda'], 2) . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}