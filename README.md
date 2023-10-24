# app-mercado
O sistema possui as funcionalidades:
- Cadastro de tipos de produtos com seus valores percentuais de imposto;
- Cadastro de produtos com valor unitário;
- Cadastro de venda onde são vinculados os produtos e as quantidades.

A principal função do sistema é calcular o valor total da venda, discriminando os valores de impostos.

# inicialização
- Acessar a pasta **config** e renomear o arquivo **.env.example** para **.env**, inserindo nele os parâmetros corretos para acesso ao banco de dados PostgreSQL
- Restaurar o arquivo de banco **db_mercado.sql**, utilizando o comando: (Obs.: restaurei no próprio banco existente, por isso o parâmetro **-d**).
```
pg_restore -U {USUARIO} -d {BANCO_EXISTENTE} db_mercado.sql
```

- Na raiz do projeto, executar:
```
php -S localhost:8080
```