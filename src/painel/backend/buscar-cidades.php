<?php
if (isset($_GET['state'])) {
    $state = $_GET['state'];

    // Dados fictícios de cidades por estado
    $cities = [
        'SP' => ['São Paulo', 'Campinas', 'Santos'],
        'RJ' => ['Rio de Janeiro', 'Niterói', 'Petrópolis'],
        'MG' => ['Belo Horizonte', 'Uberlândia', 'Ouro Preto']
    ];

    // Retorna as cidades do estado selecionado
    echo json_encode($cities[$state] ?? []);
}
