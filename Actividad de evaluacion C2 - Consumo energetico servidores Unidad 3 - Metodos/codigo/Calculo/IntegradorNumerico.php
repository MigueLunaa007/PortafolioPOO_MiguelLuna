<?php
namespace App\Calculo;

use Exception;

class IntegradorNumerico {
    private float $inicio;
    private float $fin;
    private int $pasos;
    private string $perfil; // Desafío 1: Propiedad para el perfil

    public function __construct(float $a, float $b, int $n = 1000, string $perfil = 'STRESS') {
        if ($a >= $b) {
            throw new Exception("El tiempo inicial debe ser menor al final.");
        }
        if ($n <= 0) {
            throw new Exception("La precisión (n) debe ser un número positivo.");
        }
        
        $this->inicio = $a;
        $this->fin = $b;
        $this->pasos = $n;
        $this->perfil = $perfil;
    }

    /**
     * Evalúa la función de potencia P(t) según el perfil seleccionado.
     */
    private function funcionPotencia(float $t): float {
        // Desafío 1: Estructura de control (switch) para elegir el perfil
        switch ($this->perfil) {
            case 'IDLE':
                return 5.0; // P(t) = 5
            case 'AVERAGE':
                return (2 * $t) + 5.0; // P(t) = 2t + 5
            case 'STRESS':
                return pow($t, 2); // P(t) = t^2
            default:
                throw new Exception("Perfil de consumo no válido.");
        }
    }

    public function calcularEnergiaTotal(): float {
        $h = ($this->fin - $this->inicio) / $this->pasos;
        
        $suma = ($this->funcionPotencia($this->inicio) + $this->funcionPotencia($this->fin)) / 2;
        
        for ($i = 1; $i < $this->pasos; $i++) {
            $t_i = $this->inicio + ($i * $h);
            $suma += $this->funcionPotencia($t_i);
        }
        
        return $suma * $h;
    }

    /**
     * Desafío 3: Método para devolver el resultado en kWh
     */
    public function calcularEnergiaKWh(): float {
        $joules = $this->calcularEnergiaTotal();
        // 1 Joule = 2.7778 * 10^-7 kWh
        return $joules * 2.7778e-7; 
    }
}