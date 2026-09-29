# SAEP — Sistema de Agendamento Educacional do Planetário

Sistema de agendamento de sessões para o planetário do IFAC, desenvolvido como projeto acadêmico para a disciplina de Programação para a Web (2B I.P.I 2026). A aplicação permite gerenciar sessões disponíveis e reservas, evitando conflitos de horário e overbooking.

## Tecnologias e ferramentas

- **PHP puro (sem framework)** — o roteamento e a estrutura da aplicação são construídos manualmente, sem uso de frameworks como Laravel ou Symfony, para fins de aprendizado e controle total sobre a implementação.
- **Composer** — gerenciador de dependências do PHP, usado para instalar bibliotecas auxiliares e configurar o autoload das classes do projeto (PSR-4, namespace `App\` mapeado para `app/`).
- **PostgreSQL** — banco de dados relacional escolhido pelo suporte a *range types* e *exclusion constraints*, que ajudam a garantir a integridade dos agendamentos (evitando sobreposição de horários) diretamente no nível do banco, como camada final de proteção contra overbooking.
- **Docker e Docker Compose** — orquestram os containers da aplicação (PHP + Apache), do banco de dados e do pgAdmin, garantindo um ambiente de desenvolvimento consistente e fácil de reproduzir.
- **pgAdmin** — interface visual para administração e inspeção do banco PostgreSQL durante o desenvolvimento.

### Bibliotecas em uso (via Composer)

- **vlucas/phpdotenv** — carregamento de variáveis de ambiente a partir de arquivos `.env`, evitando credenciais fixas no código.
- **nesbot/carbon** — manipulação de datas e horários; usada nas regras de negócio de `Horario` para calcular conflitos, buffers e disponibilidade (ver seção [Modelo de domínio](#modelo-de-domínio)).
- **respect/validation** — validação de dados de entrada (formulários de agendamento, e-mails, campos obrigatórios).

## Como rodar o projeto

### Pré-requisitos

- Docker
- Docker Compose

### Passos

1. Clone o repositório:
   ```bash
   git clone https://github.com/smaSamuel/SAEP
   cd SAEP
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
  /app
    /Models        → entidades de domínio (Horario, Evento, ReservaEspaco, Visitacao, Feedback...)
    /Exceptions    → exceções customizadas de regra de negócio (ex: HorarioIndisponivelException)
    /Controllers   → lógica de tratamento das requisições
    /Services      → regras de negócio que dependem de banco, múltiplas entidades ou autorização
    /Repositories  → acesso ao banco de dados via PDO
/db
  /init            → scripts SQL executados na criação do banco
docker-compose.yml
Dockerfile
```

O autoload segue PSR-4: o namespace `App\` é mapeado para o diretório `app/` (ver `composer.json`). Por isso, o nome de cada arquivo de classe/enum/interface precisa bater exatamente (maiúsculas incluídas) com o nome declarado dentro dele — essencial em ambiente Linux (usado pelos containers), que diferencia maiúsculas de minúsculas em nomes de arquivo.

## Modelo de domínio

As entidades do sistema foram modeladas começando pelo domínio de negócio (o problema em si), e não pelos atores do sistema (Cliente, Monitor, Administrador) — para evitar que decisões de autenticação/perfil influenciassem prematuramente as regras de agendamento.

As entidades de domínio seguem o estilo **rico**: cada uma carrega os métodos de regra de negócio que dependem só dos próprios dados (ex: comparação entre dois horários). Regras que dependem de banco de dados, múltiplas entidades ou autorização de ator ficam na camada de `Services`.

### Entidades e relações

```
Evento 1:N ReservaEspaco
ReservaEspaco N:1 Evento
ReservaEspaco 1:1 Horario
Horario  ← referenciado por ReservaEspaco (0..1) OU Visitacao (0..1), nunca as duas ao mesmo tempo
Visitacao 1:1 Horario
Visitacao 1:1 Feedback (opcional, só existe após a visita ocorrer)
Feedback 1:1 Visitacao
```

- **Evento** — representa um evento público ou temático (nome, descrição, tipo/categoria), que pode ocupar várias sessões (`Horario`) diferentes.
- **Horario** — a sessão em si (início, fim, status). É o recurso central e escasso do sistema: `ReservaEspaco` e `Visitacao` competem por ele de forma mutuamente exclusiva.
- **ReservaEspaco** — reserva do espaço do planetário para um evento ou apresentação privada, feita por um Monitor ou Administrador em um `Horario` ainda não disponível para visitação pública.
- **Visitacao** — agendamento feito por um cliente para visitar o planetário em um `Horario` específico.
- **Feedback** — avaliação (nota/comentário) que um cliente deixa após uma `Visitacao`.

### Regras de negócio de `Horario`

`Horario` possui três estados possíveis (`Livre`, `Reservado`, `EmVisitacao`), controlados por métodos de transição que validam a própria mudança de estado (`reservar()`, `marcarEmVisitacao()`, `liberar()`), lançando `HorarioIndisponivelException` quando a transição não é permitida.

- **Conflito de horário** (`conflitaCom`): dois horários conflitam se há sobreposição de tempo considerando um buffer mínimo entre eles (tempo de preparo/limpeza da sala entre sessões).
- **Disponibilidade para visitação** (`disponivelParaVisitacao`): um horário só pode ser reservado por um cliente se estiver livre, dentro da semana corrente, e com pelo menos 60 minutos de antecedência em relação ao momento da marcação.
- **Disponibilidade para reserva de espaço** (`disponivelParaReserva`): um horário só pode ser reservado por um Monitor/Administrador se estiver livre e **fora** da semana corrente (sem limite adicional de antecedência).

A checagem de conflito acontece **antes** de qualquer escrita no banco (camada de `Service`, buscando os horários "vizinhos" e comparando um a um), com a constraint do PostgreSQL funcionando como proteção final contra sobreposição.

## Contexto

Projeto desenvolvido para fins acadêmicos, como parte da disciplina de Programação para a Web, ministrada pelo professor Breno Silveira, com o objetivo de aplicar conceitos de desenvolvimento back-end, front-end e modelagem de banco de dados para criar um sistema que resolva um problema real. A equipe é formada por 6 (seis) pessoas, cada uma com sua própria responsabilidade:

- **Samuel** — líder do grupo e programador back-end
- **Rianna** — documentação
- **Luisz** — documentação
- **Erik** — documentação
- **Lorrany** — front-end
- **Kayo** — front-end
