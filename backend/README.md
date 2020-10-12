# Instuções para rodar o projeto:

<br />

## Configurando Arquivo .env

<br />

Depois de clonar o projeto no diretório de sua preferência, duplique o arquivo com nome: 
<strong>.env.example</strong> que está na raiz do projeto em um arquivo com o nome <strong>.env</strong> ainda na raiz do projeto.

<br/>

Em seguida adicione as configurações do DB como mostrados abaixo:

<br/>

DB_CONNECTION=mysql <br/>
DB_HOST= <span style="color:red">db</span> <br/>
DB_PORT=3306 <br/>
DB_DATABASE=<span style="color:red">prontuarios</span> <br/>
DB_USERNAME=root <br/>
DB_PASSWORD=<span style="color:red">docker</span> <br/>

<br/>

Após isso seu arquivo .env estará configurado.

<br/>

## Rodando projeto com docker-compose 

<br />

Utilize o comando descrito abaixo para rodar o projeto. O comando descrito ira criar um container com o projeto e inicia-lo junto de um NGINX server e um banco de dados MYSQL todos separados em seus respectivos containers Docker.

<br />

> docker-compose up -d

<br/>

Em seguida para instalar as dependencias do projeto execulte o comando abaixo. Ele ira fazer o download e a instalação de todas as dependências necesárias.

<br/>

> docker-compose exec app composer install

<br/>

Para criar o chave para validação de JWT utilize o comando descrito abaixo\
(PS: caso solicite permição para rodas este comando aceite-a digitando <strong>yes</strong>)

<br/>

> docker-compose exec app php artisan jwt:secret

<br/>

Por fim, execulte o comando abaixo para execultar todas as migrations que ira criar a estrutura necessária dentro do DB para rodar o projeto.

<br/>

> docker-compose exec app php artisan migrate:fresh --seed

<br/>

este comando também irá criar um <strong>usuário</strong> do tipo <strong>administrador</strong>
com os seguintes dados para autenticação:

<br/>

> CPF: 28733649049\
> SENHA: 123456

<br/>

## Rotas para teste (opcional)

<br/>

Todas as rotas do projeto estão em um arquivo <strong>insomnia.json</strong> caso haja a necessidade de testa-las. Este arquivo é um arquivo de importação para o software <strong>Insomina</strong>.
