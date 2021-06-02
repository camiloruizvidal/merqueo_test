MERQUEO
=======
cURL

### **GET** caja/empty

``` {.url .svelte-1suc8s6}
http://127.0.0.1:8000/api/v1/caja/vaciar
```

* * * * *

Example request:



``` {.svelte-1suc8s6}
curl "http://127.0.0.1:8000/api/v1/caja/vaciar" \
  -X GET
```

 

### **POST** caja/loadBase

``` {.url .svelte-1suc8s6}
http://127.0.0.1:8000/api/v1/caja/cargarBase
```

Headers

Content-Type

application/json

Body json

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

* * * * *

Example request:



``` {.svelte-1suc8s6}
curl "http://127.0.0.1:8000/api/v1/caja/cargarBase" \
  -H 'Content-Type: application/json' \
  -X POST \
  -d '[
   {
      "type":"monedas",
      "value":200,
      "count":200
   },
  {
      "type":"monedas",
      "value":50,
      "count":2000
   },
   {
      "type":"monedas",
      "value":500,
      "count":1000
   },
   {
      "type":"monedas",
      "value":1000,
      "count":1000
   },
   {
      "type":"billetes",
      "value":1000,
      "count":3400
   },
   {
      "type":"billetes",
      "value":2000,
      "count":3400
   },
   {
      "type":"billetes",
      "value":5000,
      "count":100
   },
   {
      "type":"billetes",
      "value":50000,
      "count":1000
   },
   {
      "type":"billetes",
      "value":10000,
      "count":2000
   }
]'
```

 

### **POST** caja/estado

``` {.url .svelte-1suc8s6}
http://127.0.0.1:8000/api/v1/caja/estado
```

Headers

Content-Type

application/json

* * * * *

Example request:



``` {.svelte-1suc8s6}
curl "http://127.0.0.1:8000/api/v1/caja/estado" \
  -H 'Content-Type: application/json' \
  -X POST
```

 

### **POST** caja/movimientos

``` {.url .svelte-1suc8s6}
http://127.0.0.1:8000/api/v1/caja/movimientos
```

Headers

Content-Type

application/json

Body json

    {
      "dateStart": "2021-05-30",
      "dateFinish": "2021-06-02"
    }

* * * * *

Example request:



``` {.svelte-1suc8s6}
curl "http://127.0.0.1:8000/api/v1/caja/movimientos" \
  -H 'Content-Type: application/json' \
  -X POST \
  -d '{
  "dateStart":"2021-05-30",
  "dateFinish":"2021-06-02"
}'
```

 

### **POST** caja/realizarPago

``` {.url .svelte-1suc8s6}
http://127.0.0.1:8000/api/v1/caja/realizarPago
```

Headers

Content-Type

application/json

Body json

    {
      "totalPay": 3235200,
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

* * * * *

Example request:



``` {.svelte-1suc8s6}
curl "http://127.0.0.1:8000/api/v1/caja/realizarPago" \
  -H 'Content-Type: application/json' \
  -X POST \
  -d '{
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
}'
```
