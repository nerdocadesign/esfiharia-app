<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Esfiharia Delivery</title>
  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
</head>
<body>
  <div>
    <h1>Admin - Cardápio</h1>
    <form id="formCardapio">
      <input type="text" id="nomeEsfiharia" placeholder="Nome da Esfiharia" />
      <textarea id="categoriasInput" placeholder="Categorias (JSON)" rows="4"></textarea>
      <textarea id="produtosInput" placeholder="Produtos (JSON)" rows="4"></textarea>
      <textarea id="headerInput" placeholder="Header (JSON)" rows="4"></textarea>
      <input type="text" id="textoBotaoInput" placeholder="Texto do botão" />
      <button type="submit">Salvar</button>
    </form>
  </div>

  <script>
    const supabaseUrl = 'https://ajuzonfhftbknlmzqygw.supabase.co';
    const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFqdXpvbmZoZnRia25sbXpxeWd3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDU0MzgwNzYsImV4cCI6MjA2MTAxNDA3Nn0.E_DiHTcVkcafm4tgQfm1bvCYwNEPHb6kxDHpuKqki2w'; // Substitua pela chave ANON
    const supabase = supabase.createClient(supabaseUrl, supabaseKey);

    // Carregar dados do cardápio
    supabase
      .from('cardapio')
      .select('*')
      .eq('id', 1)
      .single()
      .then(({ data, error }) => {
        if (error) {
          console.error('Erro ao buscar cardápio:', error);
          return;
        }

        document.getElementById('nomeEsfiharia').value = data.header.nome || '';
        document.getElementById('categoriasInput').value = JSON.stringify(data.categorias, null, 2);
        document.getElementById('produtosInput').value = JSON.stringify(data.produtos, null, 2);
        document.getElementById('headerInput').value = JSON.stringify(data.header, null, 2);
        document.getElementById('textoBotaoInput').value = data.textoBotao || '';
      })
      .catch(error => console.error('Erro ao carregar dados do Supabase:', error));

    // Salvar dados
    document.getElementById('formCardapio').addEventListener('submit', async function (e) {
      e.preventDefault();

      const categorias = JSON.parse(document.getElementById('categoriasInput').value);
      const produtos = JSON.parse(document.getElementById('produtosInput').value);
      const header = JSON.parse(document.getElementById('headerInput').value);
      const textoBotao = document.getElementById('textoBotaoInput').value;

      await supabase
        .from('cardapio')
        .update({
          categorias: JSON.stringify(categorias),
          produtos: JSON.stringify(produtos),
          header: JSON.stringify(header),
          textoBotao: textoBotao
        })
        .eq('id', 1);
      alert('Cardápio atualizado com sucesso!');
    });
  </script>
</body>
</html>
