CREATE DATABASE Proyecto_RyuShop;

USE Proyecto_RyuShop;

CREATE TABLE Usuarios (
    idUsuario INT AUTO_INCREMENT,
    email VARCHAR(90) UNIQUE NOT NULL,
    nombreUsu VARCHAR(20) UNIQUE NOT NULL,
    pass VARCHAR(60) NOT NULL, 
    pais VARCHAR(50),
    cp CHAR(5),
    ciudad VARCHAR(50),
    direccion VARCHAR(200),
    PRIMARY KEY (idUsuario)
);

CREATE TABLE Administradores (
    idAdministrador INT AUTO_INCREMENT,
    email VARCHAR(90) UNIQUE NOT NULL,
    nombreAdmin VARCHAR(20) UNIQUE NOT NULL,
    -- 0 para los SuperAdmins 1 para admins
    rol TINYINT DEFAULT 1,
    pass VARCHAR(60) NOT NULL, 
    PRIMARY KEY (idAdministrador)
);

CREATE TABLE Pedidos (
    idPedido INT AUTO_INCREMENT,
    fecha DATE,
    enviado BOOLEAN DEFAULT 0,
    idUsuario INT NOT NULL,
    PRIMARY KEY (idPedido),
    FOREIGN KEY (idUsuario) REFERENCES Usuarios (idUsuario)
);

CREATE TABLE Categorias (
    idCategoria INT AUTO_INCREMENT, 
    nombreCat VARCHAR(50) UNIQUE,
    descripcionCat VARCHAR(200),
    PRIMARY KEY (idCategoria)
);

CREATE TABLE SubCategorias (
    idSubCategoria INT AUTO_INCREMENT,
    nombreSubCat VARCHAR(50) UNIQUE,
    descripcionSubCat VARCHAR(200),
    idCategoria INT NOT NULL,
    PRIMARY KEY (idSubCategoria),
    FOREIGN KEY (idCategoria) REFERENCES Categorias (idCategoria)
);

CREATE TABLE Productos (
    idProducto INT AUTO_INCREMENT, 
    nombreProd VARCHAR(50) NOT NULL,
    descripcionProd VARCHAR(200),
    precioProd FLOAT NOT NULL,
    imgProducto VARCHAR(300) DEFAULT './public/img/resources/placeholder-image.jpg',
    stock INT NOT NULL,
    sinStock BOOLEAN DEFAULT 0,
    idCategoria INT NOT NULL,
    idSubCategoria INT NOT NULL,
    PRIMARY KEY (idProducto),
    FOREIGN KEY (idCategoria) REFERENCES Categorias (idCategoria),
    FOREIGN KEY (idSubCategoria) REFERENCES SubCategorias (idSubCategoria)
);

CREATE TABLE Detalles (
    idDetalleProd INT AUTO_INCREMENT,
    frabricante VARCHAR(100) DEFAULT 'Sin datos',
    dimensiones VARCHAR(100) DEFAULT 'Sin datos',
    material VARCHAR(100) DEFAULT 'Sin datos',
    idProducto INT NOT NULL,
    PRIMARY KEY (idDetalleProd),
    FOREIGN KEY (idProducto) REFERENCES Productos (idProducto)
);

-- TODO Una vez se realiza el pedido el contenido se esta tabla se transfiere a la tabla pedidos
-- Y se vacia su contenido
CREATE TABLE Carritos (
    idCarrito INT AUTO_INCREMENT,
    idProducto INT NOT NULL,
    idUsuario INT NOT NULL,
    nombreProd VARCHAR(50),
    precioProd FLOAT,
    unidades INT,
    PRIMARY KEY (idCarrito),
    FOREIGN KEY (idUsuario) REFERENCES Usuarios (idUsuario),
    FOREIGN KEY (idProducto) REFERENCES Productos (idProducto)
);

-- El contenido del carrito se pasa a PedidosProductos una vez se ha finalizado la compra
CREATE TABLE PedidosProductos (
    idPedProd INT AUTO_INCREMENT,
    idPedido INT NOT NULL,
    idProducto INT NOT NULL,
    nombreProd VARCHAR(50),
    precioProd FLOAT,
    unidades INT NOT NULL,
    PRIMARY KEY (idPedProd),
    FOREIGN KEY (idPedido) REFERENCES Pedidos (idPedido),
    FOREIGN KEY (idProducto) REFERENCES Productos (idProducto)
);










