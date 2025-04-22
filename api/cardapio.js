const mysql = require('mysql2');

const db = mysql.createConnection({
  host: 'localhost', // ou o host do banco de dados
  user: 'seu_usuario',
  password: 'sua_senha',
  database: 'seu_banco'
});

export default async (req, res) => {
  if (req.method === 'GET') {
    // Recupera o cardápio
    db.query('SELECT * FROM cardapio', (err, results) => {
      if (err) {
        res.status(500).json({ error: 'Erro ao buscar o cardápio' });
        return;
      }
      res.status(200).json(results);
    });
  } else if (req.method === 'POST') {
    // Atualiza o cardápio
    const { categorias, produtos, header, textoBotao } = req.body;
    db.query(
      'INSERT INTO cardapio (categorias, produtos, header, textoBotao) VALUES (?, ?, ?, ?)',
      [JSON.stringify(categorias), JSON.stringify(produtos), JSON.stringify(header), textoBotao],
      (err, results) => {
        if (err) {
          res.status(500).json({ error: 'Erro ao atualizar o cardápio' });
          return;
        }
        res.status(200).json({ message: 'Cardápio atualizado!' });
      }
    );
  } else {
    res.status(405).json({ error: 'Método não permitido' });
  }
};
