## Requisitos

* PHP 8.2 ou superior
* MySQL 8 ou superior
* Composer

## Como rodar o projeto baixado

Duplicar o arquivo ".env.example" e renomear para ".env".<br>
Alterar no arquivo .env as credenciais do banco de dados<br>

Instalar as dependências do PHP
```
composer install
```

Gerar a chave no arquivo .env
```
php artisan key:generate
```

Executar as migration para criar a base de dados e as tabelas
```
php artisan migrate
```

Executar as seed para cadastrar registros no banco de dados
```
php artisan db:seed
```

Iniciar o projeto criado com Laravel
```
php artisan serve
```

Para acessar a API, é recomendado utilizar o Insomnia para simular requisições à API.
```
http://127.0.0.1:8000/api/user
```


## Sequencia para criar o projeto
Criar o projeto com Laravel
```
composer create-project laravel/laravel .
```

Alterar no arquivo .env as credenciais do banco de dados<br>

Criar o arquivo de rotas para API
```
php artisan install:api
```

Iniciar o projeto criado com Laravel
```
php artisan serve
php artisan serve --host=localhost --port=3000
```

Para acessar a API, é recomendado utilizar o Insomnia para simular requisições à API.
```
http://127.0.0.1:8000/api/user
http://localhost:3000/api/user
```

## Como usar o GitHub
Baixar os arquivos do Git
```
git clone --branch <branch_name> <repository_url> .
```

Verificar a branch
```
git branch 
```

Baixar as atualizações
```
git pull
```