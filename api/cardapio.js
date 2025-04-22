// api/cardapio.js

import fs from 'fs';
import path from 'path';

// Caminho para o arquivo cardapio.json
const cardapioFilePath = path.join(process.cwd(), 'cardapio.json');

// Função handler que manipula a requisição
export default async function handler(req, res) {
  if (req.method === 'GET') {
    // Caso o método seja GET, retornamos o conteúdo atual do cardapio.json
    try {
      const data = fs.readFileSync(cardapioFilePath, 'utf-8');
      res.status(200).json(JSON.parse(data));
    } catch (error) {
      res.status(500).json({ error: 'Erro ao ler o arquivo JSON.' });
    }
  } else if (req.method === 'POST') {
    // Caso o método seja POST, atualizamos o conteúdo do cardapio.json
    try {
      const { body } = req;
      fs.writeFileSync(cardapioFilePath, JSON.stringify(body, null, 2));
      res.status(200).json({ message: 'Cardápio atualizado com sucesso!' });
    } catch (error) {
      res.status(500).json({ error: 'Erro ao salvar o arquivo JSON.' });
    }
  } else {
    // Resposta para outros métodos HTTP
    res.status(405).json({ error: 'Método não permitido.' });
  }
}
