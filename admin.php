<?php
header('Content-Type: application/json');

$servername = "fdb1028.awardspace.net";
$username = "3552835_cardapio";
$password = "v3lhasvirg3ns";
$dbname = "3552835_cardapio";

// Conectar ao banco
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    echo json_encode(['error' => 'Erro na conexão com o banco de dados.']);
    exit;
}

// Se for POST, atualiza os dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('php://input');
    $dados = json_decode($jsonData, true);

    $sql = "UPDATE cardapio SET categorias = ?, produtos = ?, header = ?, textoBotao = ? WHERE id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssss",
        json_encode($dados['categorias']),
        json_encode($dados['produtos']),
        json_encode($dados['header']),
        $dados['textoBotao']
    );
    $stmt->execute();
    echo json_encode(['success' => true]);
    $stmt->close();
    $conn->close();
    exit;
}

// Se for GET, retorna os dados
$sql = "SELECT * FROM cardapio WHERE id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$dados = [
    'categorias' => json_decode($row['categorias']),
    'produtos' => json_decode($row['produtos']),
    'header' => json_decode($row['header']),
    'textoBotao' => $row['textoBotao']
];

echo json_encode($dados);

$conn->close();
