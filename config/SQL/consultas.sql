SELECT nombreProd, precioProd, unidades, precioProd * unidades AS precioTotal
FROM Carritos;

SELECT idProducto, nombreProd, SUM(precioProd * unidades) AS precioTotal
FROM Carritos
GROUP BY idProducto, nombreProd;

SELECT precioProd * unidades AS precioTotal 
FROM Carritos 
WHERE idUsuario = 2;

SELECT ROUND(SUM(precioProd * unidades),2) AS precioTotal 
FROM Carritos 
WHERE idUsuario = 1;

SELECT COUNT(idProducto) AS numeroProductos
FROM Carritos
WHERE idUsuario = 2;

SELECT Productos.nombreProd ,Categorias.nombreCat, SubCategorias.nombreSubCat
FROM Productos
JOIN Categorias ON Productos.idCategoria = Categorias.idCategoria
JOIN SubCategorias ON Categorias.idCategoria = SubCategorias.idCategoria
WHERE Productos.idProducto = 2;


SELECT Productos.nombreProd ,Categorias.nombreCat, SubCategorias.nombreSubCat
FROM Productos
JOIN Categorias ON Productos.idCategoria = Categorias.idCategoria
JOIN SubCategorias ON Categorias.idCategoria = SubCategorias.idCategoria
WHERE Productos.idProducto = 2;

SELECT * FROM Productos WHERE idCategoria = 1 AND idSubCategoria = 1;

SELECT PP.*, P.fecha 
FROM PedidosProductos AS PP 
JOIN Pedidos AS P ON PP.idPedido = P.idPedido
WHERE P.idUsuario = 1;

SELECT PedidosProductos.*, Pedidos.fecha 
FROM PedidosProductos  
JOIN Pedidos ON PedidosProductos.idPedido = Pedidos.idPedido
WHERE Pedidos.idUsuario = 1
ORDER BY Pedidos.fecha DESC
LIMIT 1;

SELECT ROUND(SUM(PedidosProductos.precioProd * PedidosProductos.unidades), 2) AS precioTotal 
FROM PedidosProductos
JOIN Pedidos ON PedidosProductos.idPedido = Pedidos.idPedido
WHERE Pedidos.idUsuario = 1
ORDER BY Pedidos.fecha DESC
LIMIT 1;



