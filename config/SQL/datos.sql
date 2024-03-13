-- La contraseña es 1234
INSERT INTO Usuarios (email, nombreUsu, pass, pais, CP, ciudad, direccion) 
VALUES
('usuario1@gmail.com', 'usuario1','$2y$11$5ImQD7.fVQmcFkzldodtL../AevbpENIFc4xcqpuhVgajRq8KEjaO', 'España', 28001, 'Malaga', 'Calle Falsa, 1234');

-- La contraseña es 1234
INSERT INTO Administradores (email, nombreAdmin, rol, pass) 
VALUES
('superAdmin@gmail.com', 'SuperAdmin', 0,'$2y$11$cSnV5usVfZCHj1P3TUDgCeNJu0DX8I9sYmCDGH0ouMw6QqHvpoJyS'),
('admin@gmail.com', 'administrador', 1,'$2y$11$cSnV5usVfZCHj1P3TUDgCeNJu0DX8I9sYmCDGH0ouMw6QqHvpoJyS');

INSERT INTO Categorias (nombreCat, descripcionCat) 
VALUES
('Anime', 'Figuras de anime de distintas series'),
('Gundam', 'Maquetas Gundam'),
('Maquetas', 'Maquetas variadas'),
('Merchandising', 'Tazas, llaveros, camisetas, etc'),
('Coleccionables', 'Cartas, Beyblades, etc');

INSERT INTO SubCategorias (nombreSubCat, descripcionSubCat, idCategoria)
VALUES
('Spy x Family', 'Figuras la serie Spy x Family', 1),
('Dragon Ball', 'Figuras la serie Dragon Ball', 1),
('Evangelion', 'Figuras la serie Evangelion', 1),
('Chainsaw Man', 'Figuras la serie Chainsaw Man', 1),
('Entry Grade', 'Gunplas Master Grade', 2),
('Master Grade', 'Gunplas Master Grade', 2),
('Real Grade', 'Gunplas Real Grade', 2),
('High Grade', 'Gunplas High Grade', 2),
('Figuras', 'Figuras de la serie Gundam', 2),
('Aviones', 'Maquetas de aviones de distintas epocas', 3), 
('Barcos', 'Maquetas de barcos de distintas epocas', 3),
('Coches', 'Maquetas de coches de distintas epocas', 3),
('Tazas', 'Tazas de distintas series', 4),
('Llaveros', 'Llaveros de distintas series', 4),
('Camisetas', 'Camisetas de distintas series', 4),
('Beyblade', 'Seleccion de beyblades', 5),
('Pokemon trading game', 'Cartas Pokemon', 5);

-- TODO quedan por añadir varias columnas
-- TODO Añadir productos reales esto es para pruebas
INSERT INTO Productos (nombreProd, descripcionProd, precioProd, stock, idCategoria, idSubCategoria)
VALUES 
('Yor', 'Categoria Anime', 29.99, 100, 1, 1),
('Anya', 'Categoria Anime', 29.99, 100, 1, 1),
('Bond', 'Categoria Anime', 29.99, 100, 1, 1),
('Goku', 'Categoria Anime', 29.99, 100, 1, 2),
('Vegeta', 'Categoria Anime', 29.99, 100, 1, 2),
('Bulma', 'Categoria Anime', 29.99, 100, 1, 2),
('EVA 00', 'Categoria Anime', 29.99, 100, 1, 3),
('EVA 01', 'Categoria Anime', 29.99, 100, 1, 3),
('EVA 02', 'Categoria Anime', 29.99, 100, 1, 3),
('Power', 'Categoria Anime', 29.99, 100, 1, 4),
('Denji', 'Categoria Anime', 29.99, 100, 1, 4),
('Aki', 'Categoria Anime', 29.99, 100, 1, 4),
('RX-78-2', 'EG', 29.99, 100, 2, 5),
('Aerial', 'MG', 29.99, 100, 2, 6),
('Barbatos', 'RG', 29.99, 100, 2, 7),
('MX-78', 'HG', 29.99, 100, 2, 8),
('Char', 'Figuras Gundam', 29.99, 100, 2, 9),
('Amuro', 'Figuras Gundam', 29.99, 100, 2, 9),
('Suletta', 'Figuras Gundam', 29.99, 100, 2, 9),
('Miorine', 'Figuras Gundam', 29.99, 100, 2, 9),
('Avion', 'Avion WW2', 29.99, 100, 3, 10),
('Barco', 'Barco WW2', 29.99, 100, 3, 11),
('Coche', 'Coche WW2', 29.99, 100, 3, 12),
('Taza de goku', 'Merchan', 29.99, 100, 4, 13),
('Llavero de goku', 'Merchan', 29.99, 100, 4, 14),
('Camiseta de goku', 'Merchan', 29.99, 100, 4, 15),
('Beyblade X', 'Beyblades', 29.99, 100, 5, 16),
('Expansion caminos luminosos', 'Cartas Pokemon', 29.99, 100, 5, 17),
('Expansion caminos sombrios', 'Cartas Pokemon', 29.99, 100, 5, 17),
('Cartas pikachu', 'Cartas Pokemon', 29.99, 100, 5, 17);

INSERT INTO Detalles (idProducto)
VALUES 
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34);