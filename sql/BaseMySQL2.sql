drop database tallerDB;
create database tallerDB;
use tallerDB;

CREATE TABLE articulos (
	identificador INT(11) NOT NULL AUTO_INCREMENT,
	texto VARCHAR(40) NOT NULL,
	precio FLOAT DEFAULT '0' NOT NULL,
	PRIMARY KEY (identificador)
);

INSERT INTO articulos (texto, precio) VALUES ('Rotomartillo', 1590);
INSERT INTO articulos (texto, precio) VALUES ('Pinzas de presion', 290);
INSERT INTO articulos (texto, precio) VALUES ('Desarmadores', 185);
INSERT INTO articulos (texto, precio) VALUES ('Esmeriladora 9"', 3330);
INSERT INTO articulos (texto, precio) VALUES ('Martillo de bola', 120);

CREATE TABLE usuarios (
	identificador VARCHAR(20) NOT NULL,
	contrasena VARCHAR(20) NOT NULL,
    roledeAcceso VARCHAR(20) NOT NULL,
	PRIMARY KEY (identificador)
);

INSERT INTO usuarios (identificador, contrasena, roledeAcceso) VALUES ( 'pikachu', 'Pikachu123@', 'cliente');
INSERT INTO usuarios (identificador, contrasena, roledeAcceso) VALUES ( 'estudiante', 'Estudiante123@', 'administrador');

delimiter //

CREATE PROCEDURE ps_crear_articulo
  (
  -- Texto del nuevo articulo.
  IN p_texto VARCHAR(25),
  -- Precio del nuevo articulo.
  IN p_precio DECIMAL(5,2),
  -- Identificador del nuevo articulo.
  OUT p_identificador INT
  )
BEGIN
  /*
  ** Insertar el nuevo articulo y
  ** recuperar el identificador asignado.
  */
  INSERT INTO articulos (texto,precio)
  VALUES (p_texto,p_precio);
  SET p_identificador = LAST_INSERT_ID();
END;
//

CREATE PROCEDURE ps_leer_articulos
  (
  -- Precio máximo.
  IN p_precio_max DECIMAL(5,2)
  )
BEGIN
  /*
  ** Seleccionar los articulos cuyo precio es
  ** inferior al importe pasado como parámetro.
  */
  SELECT
    texto
  FROM
    articulos
  WHERE
    precio < p_precio_max;
END;
//

CREATE FUNCTION fs_numero_articulos
  (
  -- Precio máximo.
  p_precio_max DECIMAL(5,2)
  )
  RETURNS INT
BEGIN
  /*
  ** Contar el número de articulos cuyo precio es
  ** inferior al importe pasado como parámetro.
  */
  DECLARE v_resultado INT;
  SELECT
    COUNT(*)
  INTO
    v_resultado
  FROM
    articulos
  WHERE
    precio < p_precio_max;
  RETURN v_resultado;
END;
//

delimiter ;
