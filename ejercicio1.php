<?php
abstract class SistemaEcuaciones {
    abstract public function calcularResultado();
    abstract public function validarConsistencia();
}

class SistemaLineal extends SistemaEcuaciones {
    private $ec1;
    private $ec2;

    public function __construct($ec1, $ec2) {
        $this->ec1 = $ec1;
        $this->ec2 = $ec2;
    }

    public function validarConsistencia() {
        $det = $this->ec1['x'] * $this->ec2['y'] - $this->ec1['y'] * $this->ec2['x'];
        return $det != 0;
    }

    public function calcularResultado() {
        if (!$this->validarConsistencia()) {
            throw new Exception("Sistema inconsistente o dependiente");
        }
        
        // Método de sustitución
        $x = ($this->ec1['const'] * $this->ec2['y'] - $this->ec2['const'] * $this->ec1['y']) /
              ($this->ec1['x'] * $this->ec2['y'] - $this->ec1['y'] * $this->ec2['x']);
        
        $y = ($this->ec1['const'] - $this->ec1['x'] * $x) / $this->ec1['y'];
        
        return ['x' => $x, 'y' => $y];
    }

    public function resolverSistema($ec1, $ec2) {
        $this->ec1 = $ec1;
        $this->ec2 = $ec2;
        return $this->calcularResultado();
    }
}

// Interacción por consola
echo "ECUACIÓN 1:\n";
$ec1 = [
    'x' => (float)readline("Coeficiente x: "),
    'y' => (float)readline("Coeficiente y: "),
    'const' => (float)readline("Término independiente: ")
];

echo "\nECUACIÓN 2:\n";
$ec2 = [
    'x' => (float)readline("Coeficiente x: "),
    'y' => (float)readline("Coeficiente y: "),
    'const' => (float)readline("Término independiente: ")
];

$sistema = new SistemaLineal($ec1, $ec2);
try {
    $solucion = $sistema->resolverSistema($ec1, $ec2);
    print_r($solucion);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}