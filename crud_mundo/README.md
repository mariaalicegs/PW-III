# CRUD Mundo - Sistema de Gerenciamento Geográfico

## Sobre o projeto

O **CRUD Mundo** é uma aplicação web completa voltada para o gerenciamento de informações geográficas, cobrindo continentes, países, cidades e governantes. O sistema conta com controle de acesso seguro, autenticação de usuários, alteração obrigatória de senha no primeiro acesso, registro de atividades (logs) e bloqueio automático de segurança.

O objetivo do projeto é demonstrar a implementação prática de uma arquitetura web integrando *Front-End* e *Back-End*, com persistência de dados em banco relacional e regras de negócio para integridade de dados.

---

## Tecnologias Utilizadas

- **Front-End:**
  - HTML (Estruturação)
  - CSS (Estilização)
  - JavaScript (Validações de formulário e dinamicidade)

- **Back-End:**
  - PHP

- **Banco de Dados:**
  - MySQL (`bd_mundo`)

- **Controle de Versão:**
  - GitHub

---

## Funcionalidades

### Autenticação e Segurança
- **Login e Autenticação:** Tela de login para acesso restrito ao sistema.
- **Bloqueio por Tentativas:** Bloqueio automático de acesso do usuário após determinadas tentativas consecutivas com senha errada.
- **Troca Obrigatória de Senha:** Exigência de troca de senha no primeiro acesso do usuário ao sistema.
- **Manutenção de Senha:** Tela de alteração de senha de acesso com validação da senha atual, nova senha e confirmação de nova senha.
- **Registro de Logs:** Gravação de logs das ações e eventos realizados no sistema.

### Gerenciamento Geográfico (CRUD)
- **Continentes:** Inserção, listagem, edição e exclusão de continentes.
- **Países:** Inserção, listagem, edição e exclusão de países vinculados aos continentes.
- **Cidades:** Inserção, listagem, edição e exclusão de cidades associadas aos países.
- **Governantes:** Inserção, listagem, edição e exclusão de governantes vinculados a países ou cidades.

---

## Estrutura do Projeto

```text
crud-mundo/
├── css/          # Arquivos de estilo (CSS) e imagens
├── js/        # Arquivos script (JS)
└── README.md        # Informações do projeto
```

---

## Como Executar o Projeto

### Pré-requisitos
- Servidor Web com suporte a PHP (ex: XAMPP, WAMP, Laragon ou Docker).
- Banco de Dados MySQL.

### Passo a Passo
- **Clonar o repositório**
- **Mover para a pasta do servidor local:** Copie a pasta do projeto para o diretório de execução do seu servidor web (ex: htdocs no XAMPP).
- **Configurar o Banco de Dados:**
  - Acesse o MySQL
  - Crie o banco de dados bd_mundo
  - Importe o arquivo SQL localizado na pasta database/
- **Configurar a Conexão PHP:** Verifique o arquivo de conexão com o banco (localizado em src/ ou na raiz de configuração) e certifique-se de que o usuário e senha do MySQL estejam adequados para o seu ambiente local.
- **Acessar a Aplicação:** Abra o navegador e acesse: http://localhost/crud-mundo

---

## Autor
**Nome:** Maria Alice Gomes da Silva
**Curso:** Desenvolvimento de Sistemas
