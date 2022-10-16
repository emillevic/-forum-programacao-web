<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function readXmlAsSimpleObject($path) {
    $xml = simplexml_load_file($path);
    return json_decode(json_encode($xml));
}

function getBirthYear($date) {
    [$year] = explode('-', $date);
    return $year;
}

$signos = readXmlAsSimpleObject('signs.xml')->signo or die('Erro ao ler XML.');
$birthday = $_GET['birthday'];
$birthYear = getBirthYear($birthday);
$birthday = DateTime::createFromFormat('Y-m-d', $birthday);

foreach ($signos as $signo) {

    $inicio = DateTime::createFromFormat('d/m/Y', "{$signo->dataInicio}/{$birthYear}");
    $fim = DateTime::createFromFormat('d/m/Y', "{$signo->dataFim}/{$birthYear}");

    if (
        $birthday >= $inicio &&
        $birthday <= $fim
    ) {
        echo 'O seu signo é: ' . $signo->signoNome . '<br>';
        echo 'Seu aniversário está entre: ' . $signo->dataInicio . ' e ' . $signo->dataFim . '<br>';
        echo 'Características: ' . $signo->descricao . '<br>';
        echo '<hr>';
    }
}
