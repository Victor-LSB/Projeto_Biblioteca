<?php

function gerarEstrelas($nota){
    $nota = max(0, min(5, $nota));
    $inteiras = floor($nota);
    $vazias = 5 - ceil($nota);
    $estrelas = "";

    for ($i = 0; $i < $inteiras; $i++) {
        $estrelas .= "⭐";
    }

    if ($nota > $inteiras) {
        $estrelas .= "🌗";
    }

    for ($i = 0; $i < $vazias; $i++) {
        $estrelas .= "🌑";
    }

    return $estrelas;
}

function buscarCapa($titulo) {
    $tituloFormatado = urlencode($titulo);
    $url = "https://www.googleapis.com/books/v1/volumes?q=intitle:" . $tituloFormatado;
    $json = file_get_contents($url);
    $dados = json_decode($json, true);
    if (isset($dados['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
        $capa = $dados['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
        $capa = str_replace("http://", "https://", $capa);
        return $capa;
    } else {
        return "capa_padrao.jpg"; 
    }
}