# API - Task Manager
**Equipe:** Lucas Manoel, Eliabe Henrique, Filipe Vinicius, Cláudio Gabriel, Josenildo Damacena, Alison Ferreira, Antônio Carlos.


Esta API foi desenvolvida como parte de uma atividade prática do curso de Sistemas de Informação da UNIFACOL – Centro Universitário Facol. O objetivo é aplicar os conhecimentos adquiridos em sala de aula na criação de uma interface de programação.


## Autenticação
### Registrar
**POST** `/api/register`
**Body** 
```json
{
  "name": "Lucas",
  "email": "lucas@email.com",
  "password": "12345678",
  "password_confirmation": "12345678"
}
```
Resposta **201 Created**:
```json
{
  "user": {
    "id": "123",
    "name": "Lucas",
    "email": "lucas@email.com",
    "created_at": "2025-05-21T14:00:00Z"
  },
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

### Login
**POST** `/api/login`
**Body**
```json
{
  "email": "lucas@email.com",
  "password": "12345678"
}
```
Resposta **200 OK**:
```json
{
  "user": {
    "id": "123",
    "name": "Lucas",
    "email": "lucas@email.com"
  },
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

### Logout
**POST** `/api/logout`
**Headers:**
Authorization: Bearer {token}
Resposta **200 OK**:
```json
{
  "message": "Logout realizado com sucesso."
}
```

## Usuário Atual
### Obter dados do usuário autenticado
**GET** `/api/user`
**Headers:**
Authorization: Bearer {token}
Resposta **200 OK**:`
```json
{
  "id": "123",
  "name": "Lucas",
  "email": "lucas@email.com",
  "created_at": "2025-05-21T14:00:00Z"
}
```


## Categorias
### Criar categoria
**POST** `/api/categories`

Headers:
Authorization: Bearer {token}
**Body**

```json
{
  "name": "Estudos"
}
```
Resposta **201 Created**:
```json
{
  "id": 3,
  "name": "Estudos",
  "created_at": "2025-05-21T14:00:00Z",
  "updated_at": "2025-05-21T14:00:00Z"
}
```

### Listar todas as categorias
**GET** `/api/categories`
**Headers:**
Authorization: Bearer {token}
Resposta **200 OK**:
```json
[
  {
    "id": 1,
    "name": "Trabalho",
    "created_at": "2025-05-21T14:00:00Z",
    "updated_at": "2025-05-21T14:00:00Z"
  },
  {
    "id": 2,
    "name": "Pessoal",
    "created_at": "2025-05-21T14:00:00Z",
    "updated_at": "2025-05-21T14:00:00Z"
  }
]
```

### Detalhar uma categoria
**GET** `/api/categories/{id}`
Headers:
Authorization: Bearer {token}
Resposta **200 OK**:
```json
{
  "id": 1,
  "name": "Trabalho",
  "created_at": "2025-05-21T14:00:00Z",
  "updated_at": "2025-05-21T14:00:00Z"
}
```

### Atualizar categoria
**PUT** `/api/categories/{id}`
Headers:
Authorization: Bearer {token}
**Body**
```json
{
  "name": "Lazer"
}
```
Resposta **200 OK**:
```json
{
  "id": 3,
  "name": "Lazer",
  "created_at": "2025-05-21T14:00:00Z",
  "updated_at": "2025-05-21T15:00:00Z"
}
```

### Deletar categoria
**DELETE** `/api/categories/{id}`
Headers:
Authorization: Bearer {token}
Resposta **204 No Content**:

### Listar tarefas por categoria
**GET** `/api/categories/{id}/tasks`
Headers:
Authorization: Bearer {token}
Resposta **200 OK**:
```json
[
  {
    "id": 10,
    "title": "Finalizar relatório",
    "description": "Relatório mensal para a equipe",
    "created_at": "2025-05-21T14:00:00Z",
    "updated_at": "2025-05-21T14:00:00Z"
  }
]
```


## Tarefas (Tasks)
### Criar tarefa
**POST** ´/api/tasks´
Headers:
Authorization: Bearer {token}
**Body**
```json
{
  "title": "Ler livro",
  "description": "Capítulo 5 do livro de Laravel",
  "category_id": 3
}
```
Resposta **201 Created**:
```json
{
  "id": 12,
  "title": "Ler livro",
  "description": "Capítulo 5 do livro de Laravel",
  "category_id": 3,
  "user_id": "u123",
  "created_at": "2025-05-21T14:00:00Z",
  "updated_at": "2025-05-21T14:00:00Z"
}
```

### Listar tarefas
**GET** `/api/tasks`
Headers:
Authorization: Bearer {token}
Resposta **200 OK**:
```json
[
  {
    "id": 10,
    "title": "Finalizar relatório",
    "description": "Relatório mensal para a equipe",
    "category": {
      "id": 1,
      "name": "Trabalho"
    },
    "created_at": "2025-05-21T14:00:00Z",
    "updated_at": "2025-05-21T14:00:00Z"
  },
  {
    "id": 11,
    "title": "Comprar presente",
    "description": null,
    "category": {
      "id": 2,
      "name": "Pessoal"
    },
    "created_at": "2025-05-21T14:00:00Z",
    "updated_at": "2025-05-21T14:00:00Z"
  }
]
```

### Detalhar uma tarefa
**GET** `/api/tasks/{id}`
Headers:
Authorization: Bearer {token}
Resposta **200 OK**:
```json
{
  "id": 12,
  "title": "Ler capítulo 5 de Redes",
  "description": "Estudar o capítulo 5 antes da aula de quarta-feira",
  "completed": false,
  "category_id": 1,
  "created_at": "2025-05-21T14:23:00Z",
  "updated_at": "2025-05-21T14:23:00Z"
}
```

### Atualizar tarefa
**PUT** `/api/tasks/{id}`
Headers:
Authorization: Bearer {token}
**Body** (campos opcionais)
```json
{
  "title": "Ler livro Laravel",
  "description": "Capítulo 5 e 6",
  "category_id": 2
}
```
Resposta **200 OK**:
```json
{
  "id": 12,
  "title": "Ler livro Laravel",
  "description": "Capítulo 5 e 6",
  "category_id": 2,
  "user_id": "u123",
  "created_at": "2025-05-21T14:00:00Z",
  "updated_at": "2025-05-21T15:00:00Z"
}
```

### Deletar tarefa
**DELETE** `/api/tasks/{id}`
Headers:
Authorization: Bearer {token}
Resposta **204 No Content**:
