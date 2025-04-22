// /api/cardapio.js
import fs from 'fs';

export default function handler(req, res) {
  const caminhoArquivo = './cardapio.json';

  if (req.method === 'GET') {
    // Lê o conteúdo do arquivo JSON e envia de volta para o frontend
    fs.readFile(caminhoArquivo, 'utf8', (err, data) => {
      if (err) {
        return res.status(500).json({ error: 'Erro ao ler arquivo JSON' });
      }
      res.status(200).json(JSON.parse(data)); // Envia os dados para o frontend
    });
  } else if (req.method === 'POST') {
    // Atualiza o arquivo JSON com os dados enviados pelo frontend
    const novosDados = req.body;

    fs.writeFile(caminhoArquivo, JSON.stringify(novosDados, null, 2), 'utf8', (err) => {
      if (err) {
        return res.status(500).json({ error: 'Erro ao salvar dados no arquivo JSON' });
      }
      res.status(200).json({ success: true });
    });
  }
}
