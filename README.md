# Api de contas e transações

## Instação


```
composer install

cp .env.example .env
touch database/database.sqlite
php artisan migrate

```


## Execução

### Testes automatizados
```
php artisan test
```

### Execução do servidor da aplicação

```
php artisan serve
```

### Execução das etapas do desafio

1. Validar se uma conta existe
```
curl --request GET \
  --url 'http://127.0.0.1:8000/api/conta?id=2' \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json'
```

2. Criar uma conta com saldo inicial de R$ 500
```
curl --request POST \
  --url http://127.0.0.1:8000/api/conta \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/8.2.0' \
  --data '{
	"conta_id": 1234,
	"valor": 500
}'
```
3. Consultar o saldo dela
```
curl --request GET \
  --url 'http://127.0.0.1:8000/api/conta?id=1234' \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json'
```
4. Efetue uma compra no valor de R$50 utilizando a opção de débito.
```
curl --request POST \
  --url http://127.0.0.1:8000/api/transacao \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/8.2.0' \
  --data '{
	"conta_id": 1234,
	"valor": 50,
	"forma_pagamento": "D"
}'
```
5. Execute uma compra de R$100 usando a opção de crédito.
```
curl --request POST \
  --url http://127.0.0.1:8000/api/transacao \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/8.2.0' \
  --data '{
	"conta_id": 1234,
	"valor": 100,
	"forma_pagamento": "C"
}'
```
6. Realize uma transferência via Pix no valor de R$75.
```
curl --request POST \
  --url http://127.0.0.1:8000/api/transacao \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/8.2.0' \
  --data '{
	"conta_id": 1234,
	"valor": 75,
	"forma_pagamento": "P"
}'
```
