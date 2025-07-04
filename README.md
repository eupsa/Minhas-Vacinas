
# 💉 Minhas Vacinas

Plataforma web para **gestão digital de vacinação**, com objetivo de eliminar o uso de papéis e cartões físicos.

> 🎓 Este projeto foi desenvolvido como parte de um projeto acadêmico durante o curso Técnico em Informática.

![image](https://github.com/user-attachments/assets/b7e9a711-9616-47d5-8477-4928725c8677)

👉 Acesse: [minhasvacinas.pedrotech.cloud](https://minhasvacinas.pedrotech.cloud/)

---

## ✅ Funcionalidades

- Cadastro e login de usuários
- Registro de vacinas por data e nome
- Compartilhamento de histórico via link público
- Exportação em formato digital

---

## 🛠️ Tecnologias

- **Back-end:** PHP + MySQL  
- **Front-end:** HTML5, CSS3, JavaScript  
- **Estilo:** Bootstrap, TailwindCSS

---

## 🚀 Como rodar localmente

### 1. Clone o repositório

HTTPS:

```bash
git clone https://github.com/eupsa/Minhas-Vacinas.git
```

ou SSH:

```bash
git clone git@github.com:eupsa/Minhas-Vacinas.git
```

### 2. Instale as dependências PHP

```bash
composer install
```

### 3. Configure as variáveis de ambiente

Crie o arquivo `.env` baseado no `.env.example`:

```bash
cp .env.example .env
```

Edite com suas credenciais de banco e configurações.

### 4. Importe o banco de dados

Crie um banco no MySQL e importe o arquivo `minhasvacinas.sql`.

```sql
-- No MySQL
CREATE DATABASE minhasvacinas;
USE minhasvacinas;
-- Depois importe o SQL
```

### 5. Inicie o servidor local

```bash
php -S localhost:80
```

### 6. Acesse no navegador

```
http://localhost
```

---

## 👨‍💻 Autor

Pedro — [@eupsa](https://github.com/eupsa)

---

## 📄 Licença

Este projeto está sob a licença MIT.
