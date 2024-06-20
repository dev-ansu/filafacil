# Sistema de Filas de Atendimento - FilaFacil


### Este repositório contém o código fonte de um sistema para gerenciamento de filas de atendimento. O sistema foi desenvolvido utilizando PHP, JavaScript, JQuery e Bootstrap.

## Funcionalidades

- Gerenciamento de filas de atendimento.
- Exibição do status atual da fila.
- Chamada de clientes na ordem correta.
- Notificações em tempo real.
- Interface amigável e responsiva.

## Tecnologias Utilizadas
- PHP: Linguagem de programação usada no backend para gerenciamento de dados e lógica de negócios.
- JavaScript: Linguagem de programação usada no frontend para interatividade e atualizações dinâmicas.
- JQuery: Biblioteca JavaScript usada para simplificar operações com o DOM e requisições AJAX.
- Bootstrap: Framework CSS usado para criar uma interface responsiva e moderna.

## Requisitos
PHP 7.4 ou superior
Servidor web (Apache)
Banco de dados MySQL

## Instalação

Clone o repositório:
```
git clone https://github.com/seu-usuario/sistema-filas-atendimento.git
```
Navegue até o diretório do projeto:
```
cd filafacil
```

Configure o arquivo config.php com as informações do seu banco de dados:

```
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'seu-usuario');
define('DB_PASSWORD', 'sua-senha');
define('DB_NAME', 'nome-do-banco-de-dados');
```

Crie um banco de dados chamado "filafacil"

Importe o banco de dados:

Utilize o arquivo database.sql para criar as tabelas necessárias no seu banco de dados.

Inicie o servidor web e acesse o sistema pelo navegador:

http://localhost/filafacil

### Uso

Usuarios: permite adicionar e listar usuários.
Guichês: permite adicionar e listar os guichês.
Cargos: permite adicionar e listar cargos.
Gerar nova senha: permite gerar uma nova senha a ser chamada.
Chamar senha: permite chamar uma senha.
Configurações: permite bloquear acessos a certas partes do sistema de um cargo.

## IMAGENS DO PROJETO

<img width="500" src="./assets/image1.png">
<img width="500" src="./assets/image2.png">
<img width="500" src="./assets/image3.png">
<img width="500" src="./assets/image4.png">