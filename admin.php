<?php
header('Content-Type: application/json');

// Definir a URL do Supabase e a chave da API
$supabaseUrl = 'https://your-project-id.supabase.co'; // Substitua com a URL do seu projeto Supabase
$supabaseKey = 'your-api-key'; // Substitua com sua chave de API (serviço ou anon)

$apiUrl = $supabaseUrl . '/rest/v1/cardapio?id=eq.1'; // Endereço da API para o seu banco de dados, adaptado para o Supabase

// Função para fazer requisições ao Supabase
function supabaseRequest($method, $url, $data = null) {
    global $supabaseKey;

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n" .
                         "apikey: $supabaseKey\r\n",
            'method'  => $method,
        ]
    ];

    if ($data) {
        $options['http']['content'] = json_encode($data);
    }

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    if ($response === FALSE) {
        return json_encode(['error' => 'Erro ao comunicar com o Supabase']);
    }

    return $response;
}

// Se for POST, atualiza os dados no Supabase
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('php://input');
    $dados = json_decode($jsonData, true);

    // Atualiza o cardápio no Supabase
    $updateData = [
        'categorias' => json_encode($dados['categorias']),
        'produtos' => json_encode($dados['produtos']),
        'header' => json_encode($dados['header']),
        'textoBotao' => $dados['textoBotao']
    ];

    // Requisição PUT para atualizar os dados
    $response = supabaseRequest('PUT', $apiUrl, $updateData);
    echo $response;
    exit;
}

// Se for GET, retorna os dados do Supabase
$response = supabaseRequest('GET', $apiUrl);
$dados = json_decode($response, true);

// Verifica se o dado foi encontrado
if (count($dados) > 0) {
    $dados = $dados[0]; // Pega o primeiro registro (no caso, o único)
    echo json_encode([
        'categorias' => json_decode($dados['categorias']),
        'produtos' => json_decode($dados['produtos']),
        'header' => json_decode($dados['header']),
        'textoBotao' => $dados['textoBotao']
    ]);
} else {
    echo json_encode(['error' => 'Cardápio não encontrado']);
}
?>
