*Sistema de Gestão de Biblioteca Pessoal*
Um sistema completo de catálogo de livros desenvolvido em PHP, focado na organização pessoal de leituras, com integração de APIs e segurança de dados.

*Funcionalidades*
Autenticação Segura: Sistema de registo e login com criptografia de passwords (password_hash).

Gestão de Livros (CRUD): Permite registar, visualizar, editar e excluir livros da sua coleção.

Integração com Google Books API: Ao digitar o título, o sistema sugere automaticamente livros, preenchendo o autor, género e capas em alta resolução através da Fetch API.

Filtro por Utilizador: Cada utilizador tem a sua própria estante privada; os dados são isolados através de sessões PHP ($_SESSION).

Pesquisa Dinâmica: Procura de livros por título ou autor dentro da coleção do utilizador.

Status de Leitura: Funcionalidade para marcar/desmarcar livros como lidos, com indicadores visuais.

Sistema de Avaliação: Exibição de notas através de estrelas geradas dinamicamente.

Design Responsivo: Interface elegante com estilo "Dark Academia", totalmente adaptável a dispositivos móveis.

*Tecnologias Utilizadas*
Backend: PHP 8.x

Base de Dados: MySQL (MariaDB)

Frontend: HTML5, CSS3 (Variáveis, Flexbox, Grid) e JavaScript Moderno (ES6+).

API: Google Books API.

Segurança: PDO (PHP Data Objects) com Prepared Statements contra SQL Injection.

*Pré-requisitos e Instalação*
Ambiente Local: Recomenda-se o uso do XAMPP, WAMP ou Laragon.

Base de Dados:

Crie uma base de dados chamada ead_projeto.

Crie as tabelas usuarios e livros (conforme as chaves estrangeiras user_id).

Configuração:

Ajuste as credenciais de acesso no ficheiro config/conexao.php se necessário.

Execução:

Coloque os ficheiros na pasta htdocs e aceda a localhost/projeto_biblioteca/auth/login.php.

*Segurança Implementada*
O projeto foi desenvolvido seguindo boas práticas de segurança:

Proteção de Rotas: Verificação de sessão em todas as páginas sensíveis; se o utilizador não estiver logado, é redirecionado para o login.

Isolamento de Dados: Consultas SQL que utilizam sempre o user_id da sessão para garantir que um utilizador não consiga ver ou manipular dados de terceiros.

Tratamento de Dados: Uso de htmlspecialchars() na exibição de dados para prevenir ataques XSS.
