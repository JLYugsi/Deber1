<?php
abstract class MatrizAbstracta {
    abstract public function multiplicar($matriz);
    abstract public function inversa();
}

class Matriz extends MatrizAbstracta {
    private $elementos;

    public function __construct($elementos) {
        $this->elementos = $elementos;
    }

    public function multiplicar($matrizB) {
        $a = $this->elementos;
        $b = $matrizB;
        $resultado = [];
        
        $filasA = count($a);
        $columnasB = count($b[0]);
        
        for ($i = 0; $i < $filasA; $i++) {
            for ($j = 0; $j < $columnasB; $j++) {
                $resultado[$i][$j] = 0;
                for ($k = 0; $k < count($b); $k++) {
                    $resultado[$i][$j] += $a[$i][$k] * $b[$k][$j];
                }
            }
        }
        return $resultado;
    }

    public function inversa() {
        $det = self::determinante($this->elementos);
        if ($det == 0) throw new Exception("Matriz no invertible");
        
        // Solo para matrices 2x2 (ejemplo simplificado)
        if (count($this->elementos) == 2) {
            $a = $this->elementos;
            $invDet = 1 / $det;
            return [
                [$invDet * $a[1][1], $invDet * -$a[0][1]],
                [$invDet * -$a[1][0], $invDet * $a[0][0]]
            ];
        }
        throw new Exception("Solo implementado para 2x2");
    }

    public static function determinante($matriz) {
        $n = count($matriz);
        if ($n == 2) {
            return $matriz[0][0] * $matriz[1][1] - $matriz[0][1] * $matriz[1][0];
        }
        throw new Exception("Solo implementado para 2x2");
    }
}

// Interacción por consola
function leerMatriz($nombre) {
    $filas = (int)readline("Filas para $nombre: ");
    $matriz = [];
    
    for ($i = 0; $i < $filas; $i++) {
        $valores = explode(',', readline("Fila " . ($i+1) . " (separados por coma): "));
        $matriz[] = array_map('floatval', $valores);
    }
    return $matriz;
}

$matrizA = leerMatriz("Matriz A");
$matrizB = leerMatriz("Matriz B");

$matriz = new Matriz($matrizA);

echo "\nMultiplicación AxB:\n";
print_r($matriz->multiplicar($matrizB));

echo "\nDeterminante de A: " . Matriz::determinante($matrizA) . "\n";

echo "Inversa de A:\n";
print_r($matriz->inversa());