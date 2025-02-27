📚 Empower Books - Projeto de Livraria
Bem-vindo ao Empower Books, uma livraria online desenvolvida para os amantes da leitura. Este projeto foi criado como parte do teste final de um curso de programação web.

🔍 Visão Geral
O Empower Books é uma plataforma virtual que permite aos usuários:
✅ Explorar e pesquisar livros em diferentes categorias.
✅ Comprar livros online de forma prática.
✅ Acompanhar pedidos e histórico de compras.
✅ Acessar detalhes dos livros, como sinopse, autor e avaliações.

✨ Funcionalidades Principais
📖 Pesquisa de Livros: Busque livros por título, autor, categoria e palavras-chave.
🛒 Carrinho de Compras: Adicione livros ao carrinho e finalize a compra.
👤 Conta de Usuário: Cadastro, login e gerenciamento de perfil.
⭐ Avaliações e Comentários: Avalie e comente sobre os livros comprados.
⚙️ Área Administrativa: Os administradores podem gerenciar estoque, categorias e pedidos.

🛠 Tecnologias Utilizadas
🔹 Front-End
HTML5, CSS3, JavaScript
Bootstrap (para estilização responsiva)
🔹 Back-End
PHP (processamento de dados e regras de negócio)
MySQL (banco de dados para armazenar usuários, livros e pedidos)
🔹 Outras Tecnologias
XAMPP/WAMP (para rodar o servidor localmente)
Git e GitHub (controle de versão)

📌 Instalação e Configuração
1️⃣ Clone o repositório
git clone https://github.com/seu-usuario/EmpowerBooks.git

2️⃣ Configure o banco de dados
Crie um banco de dados chamado dados_livraria no MySQL.
Importe o arquivo banco_de_dados/dados_livraria.sql para criar as tabelas necessárias.

3️⃣ Configure as credenciais do banco no projeto
No arquivo conexao.php, edite as credenciais:
$host = "localhost";
$user = "root";  // Substitua pelo seu usuário do MySQL
$password = "";  // Substitua pela sua senha do MySQL
$database = "empower_books";
$dbc = mysqli_connect($host, $user, $password, $database);

4️⃣ Inicie o servidor localmente
Se estiver usando o XAMPP, inicie o Apache e o MySQL.
Acesse http://localhost/dados_livraria/ no navegador.

👥 Como Contribuir
💡 Quer ajudar a melhorar o Empower Books? Siga estes passos:
Faça um fork deste repositório.
Crie uma branch para sua nova feature:

git checkout -b minha-nova-feature

Faça as alterações e commite:

git commit -m "Adicionei uma nova funcionalidade"

Envie para o seu repositório remoto:

git push origin minha-nova-feature

Abra um Pull Request explicando as mudanças.
💡 Sugestões de melhorias:
🔹 Implementar um sistema de cupons de desconto.
🔹 Melhorar a interface da página de administração.
🔹 Criar uma API para integração com outras plataformas.

✒️ Autor
👤 Kauan Benitez
📧 [kauanbenitez04@gmail.com
+351 935610979 ]
🌐 [(https://github.com/KaKaBarros04)]

📜 Licença
📝 Este projeto está licenciado sob a MIT License

🚀 Gostou do projeto? Deixe uma ⭐ no repositório e contribua!
