# Instuções para rodar o projeto:

<br />

# Backend

<br />

## Configurando Arquivo .env (pular este passo caso ela já exista)

<br />

Na pasata <strong>./backend</strong> que está localizada na raiz do projeto existe um
arquivo com o nome <strong>.env.example</strong>. Duplique este arquivo dentro do mesmo
diretorio e o renomeie para <strong>.env</strong>.

<br/>

Em seguida adicione as configurações do DB como mostrados abaixo no arquivo <strong>.env</strong> recem criado:

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

# Rodando projeto com docker-compose 

<br />

Dentro do <strong>diretório raiz</strong> do projeto execulte o comando abaixo para
criar os containers docker o qual o sistema irá rodar sobre.

<br />

> docker-compose up -d

<br/>

Em seguida para instalar as dependencias do projeto execulte o comando abaixo. 
Ele ira fazer o download e a instalação de todas as dependências necesárias para o
backend.

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

# Rotas para teste (opcional)

<br/>

Todas as rotas do projeto estão em um arquivo <strong>insomnia.json</strong> 
caso haja a necessidade de testa-las. Este arquivo é um arquivo de importação para 
o software <strong>Insomina</strong>.
