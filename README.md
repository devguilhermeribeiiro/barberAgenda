# Schedules API – PHP 8.4

Uma API RESTful desenvolvida em PHP 8.4, utilizando arquitetura em camadas para gerenciamento de agendamentos numa barbearia.

## 🧱 Arquitetura

O projeto segue uma arquitetura em camadas, promovendo separação de responsabilidades e facilitando manutenção e testes:

- **Controller (Handlers)**: Define os endpoints da API utilizando um router simples feito por mim e delega o processamento à camada de serviço.
- **Service**: Contém a lógica de negócio da aplicação, orquestrando as interações entre as camadas.
- **Repository (DAO)**: Responsável pela persistência e acesso aos dados no banco de dados.
- **DTO (Data Transfer Object)**: Define objetos usados para transportar dados entre camadas, garantindo encapsulamento e evitando exposições indesejadas do modelo de domínio.

## 💉 Injeção de Dependência

O projeto implementa um **container de injeção de dependência customizado**, responsável por instanciar e gerenciar os componentes da aplicação de forma manual. Essa abordagem segue os princípios de:

- **Inversão de Controle (IoC)**: As dependências são fornecidas por um container central, não sendo criadas diretamente pelas classes consumidoras.
- **Injeção de Dependência (DI)**: Permite menor acoplamento entre os componentes da aplicação.
- **Responsabilidade Única**: As classes mantêm foco exclusivo na sua lógica de negócio, delegando a criação de dependências ao container.

Essa implementação substitui o uso de soluções externas como o Spring Framework, mantendo o controle completo do fluxo e da estrutura da aplicação.

## 🚀 Tecnologias Utilizadas

- **PHP 8.4**
- **Composer**: Gerenciador de dependencias.
- **NGINX**: Servidor WEB.
- **PostgreSQL**: Banco de dados relacional utilizado na persistência dos dados.
- **Docker**: Facilita o empacotamento e a execução da aplicação em qualquer ambiente.

## 📁 Estrutura do Projeto

```
├── composer.json
├── docker-compose.yaml
├── public
│   └── index.php
├── README.md
├── Server
│   ├── Nginx
│   │   └── server.conf
│   └── Php
│       └── Dockerfile
├── src
│   ├── Bootstrap
│   │   └── App.php
│   ├── Config
│   │   ├── Database.php
│   │   ├── DependencyContainer.php
│   │   └── Router.php
│   ├── Controllers
│   │   └── ScheduleController.php
│   ├── Dao
│   │   └── ScheduleDao.php
│   ├── Dto
│   │   ├── ScheduleRequestDto.php
│   │   └── ScheduleResponseDto.php
│   ├── Entity
│   │   └── Schedule.php
│   ├── Repository
│   │   └── ScheduleRepository.php
│   ├── Services
│   │   └── ScheduleService.php
│   └── Utils
│       └── Exceptions
│           └── DatabaseConnectionError.php
└── vendor
    ├── autoload.php
    └── composer
        ├── autoload_classmap.php
        ├── autoload_namespaces.php
        ├── autoload_psr4.php
        ├── autoload_real.php
        ├── autoload_static.php
        ├── ClassLoader.php
        └── LICENSE

18 directories, 26 files

```

## ⚙️ Configuração com Docker

Para rodar a aplicação, tudo o que você precisa é do Docker instalado.
### Passos:

1. Certifique-se de que o Docker está instalado em sua máquina.

2. Inicie a aplicaçao com docker-compose:
```bash
docker compose -f 'docker-compose.yaml' up -d --build 
```
- Crie a tabela de usuários:

```bash
docker exec  barberagenda_db \
psql -U barberagenda -d barberagenda \
-c "CREATE TABLE IF NOT EXISTS schedules(
    id integer GENERATED ALWAYS AS IDENTITY NOT NULL,
    service varchar(255) NOT NULL,
    barber varchar(255) NOT NULL,
    "date" date NOT NULL,
    hour time without time zone NOT NULL,
    PRIMARY KEY(id)
);
"

```

## 📌 Endpoints

A API expõe os seguintes endpoints:

- `GET /schedules`: Retorna todos os agendamentos.
- `GET /schedules/{id}`: Retorna um agendamento específico.
- `POST /schedules`: Cria um novo agendamento.
- `PUT /schedules/{uuid}`: Atualiza um agendamento existente.
- `DELETE /schedules/{id}`: Remove um agendamento.

## 📄 Licença

Este projeto está licenciado sob a [MIT License](LICENSE).