# Minhas Vacinas

**Minhas Vacinas** é um sistema de gerenciamento de vacinas projetado para facilitar o registro e a gestão de informações de vacinação. O projeto oferece aos usuários uma maneira fácil e eficaz de gerenciar seus dados de vacinação, permitindo o acesso rápido a informações relevantes, o agendamento de vacinas e o recebimento de lembretes automáticos.

## Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Principais Funcionalidades](#principais-funcionalidades)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Instalação e Configuração](#instalação-e-configuração)
- [Uso](#uso)
- [Contribuição](#contribuição)
- [Licença](#licença)
- [Contato](#contato)

## Sobre o Projeto

Minhas Vacinas foi criado para melhorar a gestão de registros de vacinação em comunidades com alta taxa de alfabetização funcional. O sistema oferece uma interface intuitiva que ajuda os usuários a registrar e acompanhar suas vacinas de forma eficiente.

## Principais Funcionalidades

- **Registro e Gerenciamento de Usuários**: Usuários podem criar contas, fazer login e atualizar suas informações pessoais.
- **Agendamento de Vacinas**: Permite que os usuários agendem suas vacinas de acordo com suas necessidades.
- **Consulta de Informações sobre Vacinas**: Acesso a informações detalhadas sobre várias vacinas disponíveis.
- **Notificações por Email**: Lembretes automáticos para vacinas agendadas.
- **Interface Responsiva**: Design otimizado para funcionar em dispositivos móveis e desktops.

## Tecnologias Utilizadas

- **Backend**: PHP
- **Banco de Dados**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Framework de CSS**: Bootstrap
- **Envio de Emails**: PHPMailer

## Instalação e Configuração

### Pré-requisitos

- Servidor local (ex.: XAMPP ou WAMP)
- PHP 7.0 ou superior
- MySQL

### Passos de Instalação

1. **Clone o repositório ou baixe o Zip [aqui](https://codeload.github.com/psilvagg/Minhas-Vacinas/zip/refs/heads/main?token=AZI7DN33BRMFMT2WIKIKLY3HB2TGO)**

   ```bash
   git clone https://github.com/psilvagg/Minhas Vacinas.git

   ```

2. **Navegue até o diretório do projeto:**

   ```bash
   cd Minhas Vacinas

   ```

3. **Configure o banco de dados:**

   > Execute o script SQL localizado em `sql/Vacina.sql`

   ```bash
    cd Minhas Vacinas/sql/Vacina.sql

   ```

4. **Configuração do Servidor**
   > Coloque o conteúdo do diretório clonado na pasta `htdocs` do XAMPP ou na raiz do seu servidor local.

## Observação

- Configure o PHPMailer conforme necessário.
