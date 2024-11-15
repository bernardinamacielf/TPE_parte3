# VENTAS API

## Integrantes:
* Dolores Garrido
* Bernardina Maciel Fonte

## Documentación de los Endpoints:

* Para realizar la tercera entrega del trabajo decidimos utilizar la tabla de productos.

- Para poder obtener una lista de todos los productos existentes, utilizamos el verbo 'GET'
ejemplo, GET http://localhost/tp_3/api/productos

- Para acceder a un producto en específico de la lista, también utilizamos 'GET', agregándole el id de dicho producto
ejemplo, GET http://localhost/tp_3/api/productos/:id

- Para eliminar un producto de la lista, utilizamos 'DELETE', agregándole el id de dicho producto
ejemplo, DELETE http://localhost/tp_3/api/productos/:id

- Para agregar un producto a la lista, utilizamos el verbo 'POST'. La información debe ser enviada en formato JSON a través del body de la solicitud.
ejemplo, POST http://localhost/tp_3/api/productos

{
    "nombre_producto": "Buclera Bellissima",
    "precio": "73440",
    "stock": 10,
    "ID_categoria": 2,
    "foto_url": "https://tiendas.contapyme.com.ar/clientes/goodgames/archivos/images/9/image_6144.jpg"
}

-Para editar un producto ya existente, utilizamos 'PUT'. La información debe ser enviada en formato JSON a través del body de la solicitud y debemos especificar el id del producto que queremos modificar.
ejemplo, PUT http://localhost/tp_3/api/productos/:id

{
    "nombre_producto": "Chaleco de cuero",
    "precio": "59900",
    "stock": 3,
    "ID_categoria": 1,
    "sin_stock": 1,
    "foto_url": "https://dcdn.mitiendanube.com/stores/947/310/products/img_2935-534d946d2bbd510ebd16962593853262-240-0.jpeg"
}

*aclaración: el campo 'sin_stock' es un booleano, por lo tanto cuando se edita se puede cambiar el valor de 0 a 1 o viceversa*

- Para ordenar opcionalmente al menos un campo de la tabla, utilizamos 'GET', 'orderBy' (permite especificar el campo por el cual desea ordenar los productos) y 'orderDirection' (define la dirección del ordenamiento, puede ser ASC para ascendente (predeterminado) o DESC para descendente).

ejemplo, GET http://localhost/tp_3/api/productos?orderBy=precio 
'GET' http://localhost/tp_3/api/productos?orderBy=precio&orderDirection=DESC 

## Requerimientos funcionales optativos.

En cuanto a los opcionales elegimos: 

- El servicio que obtiene una colección entera debe poder ordenarse por cualquiera de los campos de la tabla de manera ascendente o descendente. Utilizamos 'GET'

por defecto lo ordena de manera ascendente: GET http://localhost/tp_3/api/productos?orderBy=stock

si queremos descendente, GET http://localhost/tp_3/api/productos?orderBy=stock&orderDirection=DESC (Acá también puede ordenarse por cualquiera de los otros campos como, nombre_producto, stock, ID_categoria, sin_stock)

- El servicio que obtiene una colección entera debe poder filtrarse por alguno de sus campos

'filtro', Es el campo de la tabla por el cual queramos realizar el filtro (por ejemplo, ID_categoria, stock, precio).
Y 'valor', el valor que deseamos buscar en el campo indicado por filtro (por ejemplo, 2, 1, o 75000).

ejemplo completo, utilizando 'GET':
http://localhost/tp_3/api/productos?filtro=ID_categoria&valor=2 (Obtiene todos los productos cuyo campo ID_categoria tenga el valor 2).
http://localhost/tp_3/api/productos?filtro=stock&valor=5 (Obtiene todos los productos cuyo campo stock tenga el valor 5).
http://localhost/tp_3/api/productos?filtro=precio&valor=79000 (Obtiene todos los productos cuyo campo precio tenga el valor 79000).

- El servicio que obtiene una colección entera debe poder paginar
El endpoint que lista todos los productos permite la paginación para dividir los resultados en varias páginas y evitar sobrecargar la respuesta con demasiados datos a la vez.

'pagina', El número de página que deseamos obtener. Por defecto se considera la página 1.
'limite', El número máximo de productos por página.

http://localhost/tp_3/api/productos?pagina=1&limite=10 (Obtiene los primeros 10 productos de la lista).
http://localhost/tp_3/api/productos?pagina=2&limite=4 (Dependiendo de lo pedido en la solicitud anterior, va a obtener los productos disponibles).

## NOTA:
- Los productos comienzan a partir del ID_producto 26.
