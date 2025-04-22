// api/cardapio.js
const fs = require('fs');
const path = require('path');

// Função para ler o arquivo JSON
async function readCardapio() {
  const filePath = path.join(__dirname, '..', 'cardapio.json');
  try {
    const data = fs.readFileSync(filePath, 'utf-8');
    return JSON.parse(data);
  } catch (err) {
    return { error: 'Não foi possível ler o arquivo do cardápio.' };
  }
}

// Função para escrever o arquivo JSON
async function writeCardapio(data) {
  const filePath = path.join(__dirname, '..', 'cardapio.json');
  try {
    fs.writeFileSync(filePath, JSON.stringify(data, null, 2));
    return { success: true };
  } catch (err) {
    return { error: 'Não foi possível salvar o arquivo do cardápio.' };
  }
}

module.exports = async (req, res) => {
  if (req.method === 'GET') {
    // Retorna o conteúdo atual do cardápio
    const cardapio = await readCardapio();
    res.status(200).json(cardapio);
  } else if (req.method === 'POST') {
    // Atualiza o conteúdo do cardápio
    const updatedCardapio = req.body;
    const result = await writeCardapio(updatedCardapio);
    if (result.success) {
      res.status(200).json({ message: 'Cardápio atualizado com sucesso.' });
    } else {
      res.status(500).json({ error: result.error });
    }
  } else {
    res.status(405).json({ error: 'Método não permitido' });
  }
};
