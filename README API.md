# API TEST Merqueo

El enpoind debe apuntar a la URL del dominio, mas el prefijo **api/v1**.

En este ejemplo usaremos el dominio **http::127.0.0.1:8000/api/v1**.

* * * * *
### **GET** caja/empty

``` {.url .svelte-1suc8s6}
http://127.0.0.1:8000/api/v1/caja/vaciar
```

#### Example response:

``` JSON
{
  "data": {
    "id": 3,
    "type": "emptyBox",
    "total": 82354950,
    "created_at": "2021-06-02T02:37:23.000000Z",
    "get_detail": [
      {
        "amount": 1000,
        "type_movement": "output",
        "value": 50000,
        "type": "billetes",
        "count": 0
      },
      {
        "amount": 2001,
        "type_movement": "output",
        "value": 10000,
        "type": "billetes",
        "count": 0
      },
      {
        "amount": 100,
        "type_movement": "output",
        "value": 5000,
        "type": "billetes",
        "count": 0
      },
      {
        "amount": 3402,
        "type_movement": "output",
        "value": 2000,
        "type": "billetes",
        "count": 0
      },
      {
        "amount": 1000,
        "type_movement": "output",
        "value": 1000,
        "type": "monedas",
        "count": 0
      },
      {
        "amount": 3400,
        "type_movement": "output",
        "value": 1000,
        "type": "billetes",
        "count": 0
      },
      {
        "amount": 1001,
        "type_movement": "output",
        "value": 500,
        "type": "monedas",
        "count": 0
      },
      {
        "amount": 202,
        "type_movement": "output",
        "value": 200,
        "type": "monedas",
        "count": 0
      },
      {
        "amount": 2001,
        "type_movement": "output",
        "value": 50,
        "type": "monedas",
        "count": 0
      }
    ]
  }
}
```

* * * * *
### **POST** caja/loadBase

``` {.url .svelte-1suc8s6}
http://127.0.0.1:8000/api/v1/caja/cargarBase
```
#### Params
1) [array]
1) **type**[String].
   **Available values**: monedas, billetes.
1) **value**[integer]
	**Available values**: 50, 100, 200, 500, 1000, 2000, 5000, 10000, 20000, 50000, 100000
1) **count**[integer]: Cantidad a registrar.

#### Body json
```JSON
    [
      {
        "type": "monedas",
        "value": 200,
        "count": 200
      },
      {
        "type": "monedas",
        "value": 50,
        "count": 2000
      },
      {
        "type": "monedas",
        "value": 500,
        "count": 1000
      },
      {
        "type": "monedas",
        "value": 1000,
        "count": 1000
      },
      {
        "type": "billetes",
        "value": 1000,
        "count": 3400
      },
      {
        "type": "billetes",
        "value": 2000,
        "count": 3400
      },
      {
        "type": "billetes",
        "value": 5000,
        "count": 100
      },
      {
        "type": "billetes",
        "value": 50000,
        "count": 1000
      },
      {
        "type": "billetes",
        "value": 10000,
        "count": 2000
      }
    ]
```

#### Example response:

``` JSON
{
  "data": {
    "id": 1,
    "type": "loadBase",
    "total": 82340000,
    "created_at": "2021-06-02T02:57:53.000000Z",
    "get_detail": [
      {
        "amount": 200,
        "type_movement": "input",
        "value": 200,
        "type": "monedas",
        "count": 200
      },
      {
        "amount": 2000,
        "type_movement": "input",
        "value": 50,
        "type": "monedas",
        "count": 2000
      },
      {
        "amount": 1000,
        "type_movement": "input",
        "value": 500,
        "type": "monedas",
        "count": 1000
      },
      {
        "amount": 1000,
        "type_movement": "input",
        "value": 1000,
        "type": "monedas",
        "count": 1000
      },
      {
        "amount": 3400,
        "type_movement": "input",
        "value": 1000,
        "type": "billetes",
        "count": 3400
      },
      {
        "amount": 3400,
        "type_movement": "input",
        "value": 2000,
        "type": "billetes",
        "count": 3400
      },
      {
        "amount": 100,
        "type_movement": "input",
        "value": 5000,
        "type": "billetes",
        "count": 100
      },
      {
        "amount": 1000,
        "type_movement": "input",
        "value": 50000,
        "type": "billetes",
        "count": 1000
      },
      {
        "amount": 2000,
        "type_movement": "input",
        "value": 10000,
        "type": "billetes",
        "count": 2000
      }
    ]
  }
}
```

### **POST** caja/estado

```
http://127.0.0.1:8000/api/v1/caja/estado
```

#### Example response:

``` JSON
{
  "data": [
    {
      "id": 11,
      "value": 100000,
      "type": "billetes",
      "count": 9
    },
    {
      "id": 8,
      "value": 50000,
      "type": "billetes",
      "count": 1013
    },
    {
      "id": 10,
      "value": 20000,
      "type": "billetes",
      "count": 55
    },
    {
      "id": 9,
      "value": 10000,
      "type": "billetes",
      "count": 2059
    },
    {
      "id": 7,
      "value": 5000,
      "type": "billetes",
      "count": 100
    },
    {
      "id": 6,
      "value": 2000,
      "type": "billetes",
      "count": 3398
    },
    {
      "id": 5,
      "value": 1000,
      "type": "billetes",
      "count": 3400
    },
    {
      "id": 4,
      "value": 1000,
      "type": "monedas",
      "count": 1000
    },
    {
      "id": 3,
      "value": 500,
      "type": "monedas",
      "count": 999
    },
    {
      "id": 1,
      "value": 200,
      "type": "monedas",
      "count": 199
    },
    {
      "id": 2,
      "value": 50,
      "type": "monedas",
      "count": 1998
    }
  ]
}
```

* * * * *

### **POST** caja/movimientos

```
http://127.0.0.1:8000/api/v1/caja/movimientos
```
#### Params
1) **dateStart**[String]:Fecha de inicio de busqueda
   **Available values**: Format YYYY-mm-dd.
1) **dateFinish**[String]: Fecha limite de búsqueda
   **Available values**: Format YYYY-mm-dd.

#### Body json
``` JSON
{
    "dateStart": "2021-05-30",
    "dateFinish": "2021-06-02"
}
```

#### Example response:

``` JSON
{
  "data": [
    {
      "id": 2,
      "type": "payment",
      "total": 3250000,
      "created_at": "2021-06-02T02:58:01.000000Z",
      "get_detail": [
        {
          "amount": 9,
          "type_movement": "input",
          "value": 100000,
          "type": "billetes",
          "count": 9
        },
        {
          "amount": 13,
          "type_movement": "input",
          "value": 50000,
          "type": "billetes",
          "count": 1013
        },
        {
          "amount": 55,
          "type_movement": "input",
          "value": 20000,
          "type": "billetes",
          "count": 55
        },
        {
          "amount": 60,
          "type_movement": "input",
          "value": 10000,
          "type": "billetes",
          "count": 2059
        },
        {
          "amount": 1,
          "type_movement": "output",
          "value": 10000,
          "type": "billetes",
          "count": 2059
        },
        {
          "amount": 2,
          "type_movement": "output",
          "value": 2000,
          "type": "billetes",
          "count": 3398
        },
        {
          "amount": 1,
          "type_movement": "output",
          "value": 500,
          "type": "monedas",
          "count": 999
        },
        {
          "amount": 1,
          "type_movement": "output",
          "value": 200,
          "type": "monedas",
          "count": 199
        },
        {
          "amount": 2,
          "type_movement": "output",
          "value": 50,
          "type": "monedas",
          "count": 1998
        }
      ]
    },
    {
      "id": 1,
      "type": "loadBase",
      "total": 82340000,
      "created_at": "2021-06-02T02:57:53.000000Z",
      "get_detail": [
        {
          "amount": 1000,
          "type_movement": "input",
          "value": 50000,
          "type": "billetes",
          "count": 1013
        },
        {
          "amount": 2000,
          "type_movement": "input",
          "value": 10000,
          "type": "billetes",
          "count": 2059
        },
        {
          "amount": 100,
          "type_movement": "input",
          "value": 5000,
          "type": "billetes",
          "count": 100
        },
        {
          "amount": 3400,
          "type_movement": "input",
          "value": 2000,
          "type": "billetes",
          "count": 3398
        },
        {
          "amount": 3400,
          "type_movement": "input",
          "value": 1000,
          "type": "billetes",
          "count": 3400
        },
        {
          "amount": 1000,
          "type_movement": "input",
          "value": 1000,
          "type": "monedas",
          "count": 1000
        },
        {
          "amount": 1000,
          "type_movement": "input",
          "value": 500,
          "type": "monedas",
          "count": 999
        },
        {
          "amount": 200,
          "type_movement": "input",
          "value": 200,
          "type": "monedas",
          "count": 199
        },
        {
          "amount": 2000,
          "type_movement": "input",
          "value": 50,
          "type": "monedas",
          "count": 1998
        }
      ]
    }
  ]
}
```
* * * * *
### **POST** caja/realizarPago

``` {.url .svelte-1suc8s6}
http://127.0.0.1:8000/api/v1/caja/realizarPago
```


#### Params
1) **totalPay**[Integer]:Valor total a pagar
1) **biilsAndCoin**[Array]: Registro de monedas y billetes a registrar:

1) **type**[String].
   **Available values**: monedas, billetes.
1) **value**[integer]
	**Available values**: 50, 100, 200, 500, 1000, 2000, 5000, 10000, 20000, 50000, 100000
1) **count**[integer]: Cantidad a registrar.



#### Body json
``` JSON
{
  "totalPay":  3235200,
  "biilsAndCoin": [
    {
      "value": 10000,
      "type": "billetes",
      "count": 60
    },
    {
      "value": 20000,
      "type": "billetes",
      "count": 55
    },
    {
      "value": 50000,
      "type": "billetes",
      "count": 13
    },
    {
      "value": 100000,
      "type": "billetes",
      "count": 9
    }
  ]
}
```

#### Example response:

```JSON
{
  "data": {
    "validate": true,
    "change": 14800,
    "moneyChange": [
      {
        "value": 10000,
        "type": "billetes",
        "count": 1
      },
      {
        "value": 2000,
        "type": "billetes",
        "count": 2
      },
      {
        "value": 500,
        "type": "monedas",
        "count": 1
      },
      {
        "value": 200,
        "type": "monedas",
        "count": 1
      },
      {
        "value": 50,
        "type": "monedas",
        "count": 2
      }
    ]
  }
}
```
