// /api/cardapio.js
const mysql = require('mysql2');

// Conexão com o banco de dados do AwardSpace
const db = mysql.createConnection({
   host: 'fdb1028.awardspace.net',
  user: '3552835_cardapio',
  password: 'v3lhasvirg3ns', // substitua pela senha real do banco
  database: '3552835_cardapio',
  port: 3306
});

module.exports = async (req, res) => {
  if (req.method === 'GET') {
    // Buscar o cardápio mais recente
    db.query('SELECT * FROM cardapio ORDER BY id DESC LIMIT 1', (err, results) => {
      if (err) {
        console.error('Erro ao buscar cardápio:', err);
        res.status(500).json({ error: 'Erro ao buscar o cardápio' });
        return;
      }

      if (results.length > 0) {
        res.status(200).json(results[0]);
      } else {
        res.status(200).json({ categorias: [], produtos: [], header: {}, textoBotao: 'Meu Pedido' });
      }
    });

  } else if (req.method === 'POST') {
    const { categorias, produtos, header, textoBotao } = req.body;

    if (!categorias || !produtos || !header || !textoBotao) {
      return res.status(400).json({ error: 'Dados incompletos para salvar o cardápio.' });
    }

    // Inserir o cardápio
    db.query(
      'INSERT INTO cardapio (categorias, produtos, header, textoBotao) VALUES (?, ?, ?, ?)',
      [JSON.stringify(categorias), JSON.stringify(produtos), JSON.stringify(header), textoBotao],
      (err) => {
        if (err) {
          console.error('Erro ao inserir cardápio:', err);
          res.status(500).json({ error: 'Erro ao salvar o cardápio' });
          return;
        }

        res.status(200).json({ message: 'Cardápio salvo com sucesso!' });
      }
    );

  } else {
    res.status(405).json({ error: 'Método não permitido' });
  }
};
