<?php

function numeroPrimo($numero) {
    if ($numero <= 1) {
        return false;
    }

    if ($numero <= 3) {
        return true;
    }

    if ($numero % 2 == 0 || $numero % 3 == 0) {
        return false;
    }

    $i = 5;
    while ($i * $i <= $numero) {
        if ($numero % $i == 0 || $numero % ($i + 2) == 0) {
            return false;
        }
        $i += 6;
    }

    return true;
}

function somaDosPrimos($ini, $fim) {
    $soma = 0;

    for ($i = $ini; $i <= $fim; $i++) {
        if (numeroPrimo($i)) {
            $soma += $i;
        }
    }

    return $soma;
}

$ini = 1;
$fim = 1000000;

echo "A soma dos números primos entre $ini e $fim é: " . somaDosPrimos($ini, $fim);
?>
