<?php
// URL da API
$url = "https://api.opendatasus.saude.gov.br/v1/covid-19/vacinacao";

// Usando file_get_contents para consumir a API
$response = file_get_contents($url);

if ($response === FALSE) {
  echo "Erro ao consumir a API";
} else {
  // Decodificando a resposta JSON
  $data = json_decode($response, true);
  echo '<pre>';
  print_r($data);
  echo '</pre>';
}
