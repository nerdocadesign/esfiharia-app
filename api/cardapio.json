// /api/cardapio.js
export default function handler(req, res) {
  const fs = require('fs');
  
  if (req.method === 'GET') {
    // Carregar os dados do arquivo cardapio.json
    fs.readFile('cardapio.json', 'utf8', (err, data) => {
      if (err) {
        res.status(500).json({ error: 'Erro ao ler arquivo JSON' });
        return;
      }
      res.status(200).json(JSON.parse(data));
    });
  } else if (req.method === 'POST') {
    // Salvar os dados no arquivo cardapio.json
    const dados = req.body; // O corpo do pedido conterá o JSON atualizado.
    fs.writeFile('cardapio.json', JSON.stringify(dados), (err) => {
      if (err) {
        res.status(500).json({ error: 'Erro ao salvar arquivo JSON' });
        return;
      }
      res.status(200).json({ success: true });
    });
  }
}
