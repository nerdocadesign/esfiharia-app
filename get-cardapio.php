<?php
header('Content-Type: application/json');

// Substitua com sua chave real
$supabaseUrl = 'https://ajuzonfhftbknlmzqygw.supabase.co';
$supabaseKey = 'velhasvirgens';

$apiUrl = $supabaseUrl . '/rest/v1/cardapio?id=eq.1';

$headers = [
  "apikey: $supabaseKey",
  "Authorization: Bearer $supabaseKey",
  "Content-Type: application/json"
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (isset($data[0])) {
  echo json_encode([
    "categorias" => json_decode($data[0]['categorias']),
    "produtos" => json_decode($data[0]['produtos']),
    "header" => json_decode($data[0]['header']),
    "textoBotao" => $data[0]['textoBotao']
  ]);
} else {
  echo json_encode(["erro" => "Cardápio não encontrado"]);
}
