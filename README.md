# Gerenciador de Tarefas

Sistema de gerenciamento de tarefas desenvolvido em PHP com CodeIgniter 4 para avaliação técnica. O objetivo foi criar um CRUD funcional, seguindo boas práticas de MVC, segurança e um layout responsivo.

## Tecnologias utilizadas
* **PHP 8+**
* **CodeIgniter 4**
* **PostgreSQL**
* **Bootstrap 5** (arquivos locais, sem dependência de CDN)

## Funcionalidades e Requisitos Atendidos
- CRUD completo (Criar, Listar, Editar e Excluir tarefas).
- Filtro de busca na tabela em tempo real (JavaScript puro).
- Exclusão segura com Modal de confirmação para evitar cliques acidentais.
- Segurança: Query Builder do framework para evitar SQL Injection e CSRF Token nos formulários.
- **Bônus (API REST):** Controller dedicado para responder em JSON, com tratamento de erros.

## Como rodar localmente

### 1. Clone o projeto e entre na pasta:
```bash

git clone [https://github.com/WesleyVinicius/gerenciador_tarefas.git](https://github.com/WesleyVinicius/gerenciador_tarefas.git)
cd seu-repositorio
```

### 2. Instale as dependências pelo Composer:
```bash

composer install
```

### 3. Configure o banco de dados:
Renomeie o arquivo `env` da raiz do projeto para `.env`. Abra o arquivo, descomente e preencha as credenciais do seu PostgreSQL:
```ini

database.default.hostname = localhost
database.default.database = nome_do_seu_banco
database.default.username = postgres
database.default.password = sua_senha
database.default.DBDriver = Postgre
database.default.charset = utf8
database.default.port = 5432
```

### 4. Inicie o servidor embutido:
```bash

php spark serve
```
O painel estará disponível em: `http://localhost:8080/tasks`

## Documentação e Teste da API REST

A API foi documentada no arquivo `testes_api.http` que está na raiz do projeto.

- **Teste direto no código:** Se você usa o PhpStorm ou o VS Code (com a extensão REST Client), basta abrir esse arquivo e executar as requisições (Play/Run) direto pela IDE.
- **Postman/Insomnia:** O arquivo também serve como documentação legível. Você pode abri-lo para ver as rotas e copiar os payloads (JSON) para testar na sua ferramenta de preferência.

---
Desenvolvido por Wesley Vinicius Fernandes.