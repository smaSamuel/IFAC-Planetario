# Planetário IFAC - Sistema de Agendamentos

ESte sistema de agendamento de sessões para o planetário do IFAC, desenvolvido como projeto acadêmico para a disciplina de programação para a web (2B I.P.I 2026). A aplicação permite gerenciar sessões disponíveis e reservas, evitando conflitos de horário e overbooking. Escolhemos o nome SAEP para o projeto sendo este uma abreviação de Sistema de Agendamento Educacional do Planetário.

## Tecnologias e ferramentas

- **PHP puro (sem framework)** — o roteamento e a estrutura da aplicação são construídos manualmente, sem uso de frameworks como Laravel ou Symfony, para fins de aprendizado e controle total sobre a implementação.
- **Composer** — gerenciador de dependências do PHP, usado para instalar bibliotecas auxiliares e configurar o autoload das classes do projeto.
- **PostgreSQL** — banco de dados relacional escolhido pelo suporte a *range types* e *exclusion constraints*, que ajudam a garantir a integridade dos agendamentos (evitando sobreposição de horários) diretamente no nível do banco.
- **Docker e Docker Compose** — orquestram os containers da aplicação (PHP + Apache), do banco de dados e do pgAdmin, garantindo um ambiente de desenvolvimento consistente e fácil de reproduzir.
- **pgAdmin** — interface visual para administração e inspeção do banco PostgreSQL durante o desenvolvimento.

### Bibliotecas planejadas (via Composer)

- **vlucas/phpdotenv** — carregamento de variáveis de ambiente a partir de arquivos `.env`, evitando credenciais fixas no código.
- **nesbot/carbon** — manipulação de datas e horários, essencial para calcular disponibilidade e conflitos entre sessões.
- **respect/validation** — validação de dados de entrada (formulários de agendamento, e-mails, campos obrigatórios).

## Como rodar o projeto

### Pré-requisitos

- Docker
- Docker Compose

### Passos

1. Clone o repositório:
   ```bash
   git clone <url-do-repositorio>
   cd planetario-ifac
   ```

2. Crie um arquivo `.env` na raiz do projeto com as variáveis necessárias:
   ```
   DB_USERNAME=planetario_user
   DB_PASSWORD=planetario_pass
   POSTGRES_USER=planetario_user
   POSTGRES_PASSWORD=planetario_pass
   PGADMIN_DEFAULT_EMAIL=admin@planetario.local
   PGADMIN_DEFAULT_PASSWORD=admin_pass
   ```

3. Suba os containers:
   ```bash
   docker-compose up -d --build
   ```

4. Acesse:
   - Aplicação: [http://localhost:8080](http://localhost:8080)
   - pgAdmin: [http://localhost:5050](http://localhost:5050)

### Instalando dependências PHP

Com os containers em execução, instale as bibliotecas do Composer dentro do container da aplicação:

```bash
docker exec -it planetario_app composer install
```

## Estrutura do projeto

```
/src
  /public          → index.php (front controller), assets públicos
  /Controllers     → lógica de tratamento das requisições
  /Models          → representação das entidades (sessões, agendamentos)
  /Services        → regras de negócio (verificação de disponibilidade, conflitos)
  /Repositories     → acesso ao banco de dados via PDO
/db
  /init            → scripts SQL executados na criação do banco
docker-compose.yml
Dockerfile
```

## Contexto

Projeto desenvolvido para fins acadêmicos, como parte de disciplina do curso programação para web adminsitrada pelo professor Breno Silveira, com o objetivo de aplicar conceitos de desenvolvimento back-end, front-end e modelagem de banco de dado, para criar um sistema que resovla um problema real, a equipe e foramda por 6 (seis) pessoas com cada pessoa com sua propria responsabilidade, elas são: Samuel (lider do grupo e programador back-end), Rianna (documentação), Luisz (Documentação), Erik (documentação) Lorrany (Front-end) e Kayo (Front-end)
