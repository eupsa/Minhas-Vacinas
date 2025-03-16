# Minhas Vacinas

Minhas Vacinas é uma plataforma desenvolvida para promover a conscientização sobre a vacinação, permitindo que os usuários gerenciem seu histórico de vacinas e acessem informações atualizadas sobre imunização.

## Tecnologias Utilizadas
- **Backend:** PHP 8.3+, Node.js
- **Frontend:** [Bootstrap](https://getbootstrap.com/) e [SweetAlert](https://sweetalert2.github.io/)
- **Banco de Dados:** MySQL
- **Hospedagem:** Ubuntu Server 24.04.1 LTS (Amazon Lightsail e Oracle Cloud)
- **Outras Tecnologias:** [PHPMailer](https://packagist.org/packages/phpmailer/phpmailer), [Pdf-Puppeteer](https://www.npmjs.com/package/pdf-puppeteer)

## Funcionalidades
- Cadastro e login de usuários (com autenticação de dois fatores)
- Recuperação e redefinição de senha
- Painel do usuário com gerenciamento de perfil e vacinas
- Seção de ajuda com suporte e informações adicionais
- Armazenamento seguro das informações de vacinação

## Requisitos para Execução
Antes de rodar o projeto, certifique-se de ter os seguintes requisitos:

### Backend:
1. PHP 8.3+
2. Composer e Node.js
3. MySQL

## Instalação e Execução
```sh
# Clone o repositório
git clone https://github.com/psilvagg/Minhas-Vacinas
cd Minhas-Vacinas

# Instale as dependências (Composer)
composer install

# Instale as dependências (Node)
npm i

# Crie uma cópia do arquivo de configuração
cp .env.example .env

# Preencha as credenciais no arquivo .env

# Inicie o servidor PHP
php -S localhost:80
```

## Contribuição
Contribuições são bem-vindas! Para contribuir:
1. Faça um fork do repositório
2. Crie uma branch (`feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova funcionalidade'`)
4. Envie um pull request


# Licença
MIT License

Copyright (c) 2025 Pedro S.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.