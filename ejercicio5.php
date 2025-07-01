<?php
abstract class EcuacionDiferencial {
    abstract public function resolverEuler($f, $condiciones, $params);
}

class EulerNumerico extends EcuacionDiferencial {
    public function resolverEuler($f, $condiciones, $params) {
        $x0 = $condiciones['x0'];
        $y0 = $condiciones['y0'];
        $h = $params['h'];
        $pasos = $params['pasos'];
        
        $resultado = [];
        $x = $x0;
        $y = $y0;
        
        $resultado[] = ['x' => $x, 'y' => $y];
        
        for ($i = 0; $i < $pasos; $i++) {
            $y = $y + $h * $f($x, $y);
            $x = $x + $h;
            $resultado[] = ['x' => $x, 'y' => $y];
        }
        return $resultado;
    }
}

// Interacción por consola
$f = function($x, $y) {
    return $x + $y; // Ejemplo: dy/dx = x + y
};

$condiciones = [
    'x0' => (float)readline("x inicial: "),
    'y0' => (float)readline("y inicial: ")
];

$params = [
    'h' => (float)readline("Paso (h): "),
    'pasos' => (int)readline("Número de pasos: ")
];

$euler = new EulerNumerico();
$solucion = $euler->resolverEuler($f, $condiciones, $params);

echo "\nResultados:\n";
foreach ($solucion as $punto) {
    echo sprintf("x=%.2f, y=%.4f\n", $punto['x'], $punto['y']);
}