# LOCK BOX
 
> Aplicação web para armazenar notas pessoais com criptografia dupla de ponta a ponta — suas anotações nunca ficam expostas sem sua senha.
 
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://www.sqlite.org/)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![DaisyUI](https://img.shields.io/badge/DaisyUI-FF9903?style=for-the-badge&logo=daisyui&logoColor=white)](https://daisyui.com/)

![Project Preview](https://github.com/user-attachments/assets/8a3f1a9d-7618-419f-b3e6-6cd1ea2bde8f)
![Project Preview](https://github.com/user-attachments/assets/8620a383-ecf9-4024-a424-2a2a6184fa7c)
![Project Preview](https://github.com/user-attachments/assets/d66730b2-775f-4f69-9867-42d50ef8c945)
![Project Preview](https://github.com/user-attachments/assets/c6b808d2-0f83-488f-9b9d-2187999b7557)

---
 
## 🎯 Sobre
 
O **LockBox** é uma aplicação web de anotações seguras construída com PHP puro, seguindo o padrão MVC sem depender de nenhum framework. O foco do projeto é a **privacidade**: cada nota é criptografada com dupla camada (AES-256-CBC + HMAC SHA3-512) antes de ser salva no banco de dados.
 
O conteúdo das notas só pode ser visualizado após o usuário confirmar a senha da conta, e permanece mascarado com asteriscos em todos os outros momentos — mesmo que alguém tenha acesso direto ao banco de dados, os dados são ilegíveis sem as chaves de criptografia.
 
O projeto foi desenvolvido do zero para consolidar conceitos de roteamento, middlewares, sessões e segurança em PHP sem o auxílio de frameworks como Laravel ou Symfony.
 
## ✨ Funcionalidades
 
- 🔐 **Criptografia dupla** — Notas cifradas com AES-256-CBC e autenticadas via HMAC SHA3-512
- 👁️ **Visualização protegida por senha** — O conteúdo só é revelado após reautenticação no momento da leitura
- 📝 **CRUD completo de notas** — Criar, listar, pesquisar, editar e deletar anotações
- 🔑 **Autenticação de usuários** — Registro e login com hash de senha (password_hash)
- 🛡️ **Middlewares de rota** — Separação entre rotas públicas (guest) e protegidas (auth)
- 🔍 **Busca por título** — Filtro de notas diretamente na listagem
 
## 🛠️ Tech Stack
 
**Backend:**
- PHP 8.1+ — Lógica da aplicação com MVC implementado do zero
- SQLite — Banco de dados leve via PDO com prepared statements
- OpenSSL — Criptografia AES-256-CBC das notas
- Composer — Autoload PSR-4
 
**Frontend:**
- TailwindCSS + DaisyUI — Estilização e componentes de UI
- PHP Views — Renderização server-side
 
**Ferramentas:**
- Laravel Pint — Code style (dev)
- PHP Built-in Server — Desenvolvimento local
 
## 🚀 Quick Start
 
```bash
# Clone o repositório
git clone https://github.com/yourusername/lock-box.git
cd lock-box
 
# Instale as dependências
composer install
 
# Configure as variáveis de ambiente
cp .env.example .env
# Edite o .env com suas chaves de criptografia
 
# Inicie o servidor de desenvolvimento
php -S localhost:8000 -t public public/server.php
```
 
Acesse `http://localhost:8000`
 
## 📁 Estrutura do Projeto
 
```
lock-box/
├── Core/                    # Núcleo do framework caseiro
│   ├── Database.php        # Abstração PDO
│   ├── Route.php           # Roteador HTTP
│   ├── Validacao.php       # Engine de validação
│   ├── Session.php         # Gerenciamento de sessão
│   ├── Flash.php           # Mensagens flash
│   └── functions.php       # Helpers globais (encrypt, decrypt, auth...)
│
├── app/
│   ├── Controllers/        # Controladores (Index, Login, Register, Notas/)
│   ├── Middlewares/        # AuthMiddleware e GuestMiddleware
│   └── Models/             # Nota.php e Usuario.php
│
├── config/
│   ├── config.php          # Configurações do banco e segurança
│   └── routes.php          # Definição de todas as rotas
│
├── views/                  # Templates PHP
│   ├── template/           # Layouts base (app e guest)
│   ├── partials/           # Componentes reutilizáveis (navbar, search)
│   └── notas/              # Views de CRUD de notas
│
├── database/
│   └── database.sqlite     # Banco de dados SQLite
│
└── public/
    └── index.php           # Entry point da aplicação
```
 
## 💡 Destaques Técnicos
 
### Criptografia em Dupla Camada
 
As notas são cifradas antes de qualquer escrita no banco de dados. O processo usa AES-256-CBC para a cifra principal e HMAC SHA3-512 para garantir a integridade dos dados — se a nota for adulterada no banco, a descriptografia falha silenciosamente.
 
```php
function encrypt($data) {
    $method = 'aes-256-cbc';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    $first_encrypted = openssl_encrypt($data, $method, $first_key, OPENSSL_RAW_DATA, $iv);
    $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, true);
    return base64_encode($iv . $second_encrypted . $first_encrypted);
}
```
 
### Roteador MVC Sem Framework
 
O sistema de rotas suporta GET, POST, PUT e DELETE com encadeamento fluente e injeção de middleware por rota:
 
```php
(new Route)
    ->get('/notas', Notas\IndexController::class, AuthMiddleware::class)
    ->post('/notas/criar', [Notas\CriarController::class, 'store'], AuthMiddleware::class)
    ->put('/nota', Notas\AtualizarController::class, AuthMiddleware::class)
    ->run();
```
 
### Visualização com Reautenticação
 
O conteúdo das notas é mascarado por padrão — exibido como `***` com o comprimento real do texto. Para revelar, o usuário precisa confirmar a senha, que é verificada via `password_verify()` e registrada na sessão com escopo limitado.
 
## 📚 O que Aprendi
 
**Técnico:**
- Implementação de um mini-framework MVC em PHP puro com roteamento, middlewares e autoload PSR-4
- Criptografia simétrica com AES-256-CBC e autenticação de mensagem com HMAC
- Gerenciamento de sessão e controle de acesso por middleware de rota
- Uso de PDO com prepared statements para prevenção de SQL Injection
 
**Boas práticas:**
- Separação de responsabilidades entre Controllers, Models e Views sem acoplamento
- Variáveis de ambiente para separar configurações sensíveis do código
- Validação centralizada e reutilizável com suporte a múltiplas regras por campo
 
## 🗺️ Roadmap
 
- [ ] Suporte a múltiplos bancos de dados (MySQL/PostgreSQL)
- [ ] Autenticação de dois fatores (2FA)
- [ ] Exportação de notas em formato criptografado
- [ ] API REST para acesso via mobile
- [ ] Testes automatizados com PHPUnit
 
## 📝 Observações
 
- Projeto **educacional** focado em segurança e arquitetura PHP
- As chaves de criptografia devem ser geradas de forma segura e nunca commitadas — use o `.env`
- O banco SQLite incluso é apenas para demonstração
 
## 📄 Licença
 
MIT License — veja [LICENSE](LICENSE) para detalhes.
 
## 👤 Autor
 
**Luan Neumann**

- LinkedIn: [luan-neumann-dev](https://www.linkedin.com/in/luan-neumann-dev/)
- GitHub: [@Luan-Neumann-Dev](https://github.com/Luan-Neumann-Dev)
 
---
 
⭐ Achou interessante? Deixa uma estrela!
