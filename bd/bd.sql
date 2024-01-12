CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    tipo ENUM('Administrador', 'Usuario') NOT NULL,
    password VARCHAR(255) NOT NULL,
    fechaCaptura DATE NOT NULL
);

CREATE TABLE categoriasProductos (
    id_categoria INT AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    nombre VARCHAR(150),
    fechaCaptura DATE,
    PRIMARY KEY(id_categoria)
);

CREATE TABLE imagenes (
    id_imagen INT AUTO_INCREMENT,
    id_categoria INT NOT NULL,
    nombre VARCHAR(500),
    ruta VARCHAR(500),
    fechaSubida DATE,
    PRIMARY KEY(id_imagen)
);

CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT NULL,
    id_imagen INT NOT NULL,
    id_usuario INT NOT NULL,
    nombre VARCHAR(50),
    descripcion VARCHAR(500),
    precio FLOAT,
    fechaCaptura DATE,
    estado BOOLEAN DEFAULT TRUE,
    cantidad INT NOT NULL
);

CREATE TABLE inventario_productos (
    id_inventario_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    cantidad INT,
    fecha_ingreso DATE,
    precio FLOAT
);

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nombre VARCHAR(200),
    apellido VARCHAR(200),
    cuit INT NOT NULL,
    direccion VARCHAR(200),
    email VARCHAR(200),
    telefono VARCHAR(200),
    telefono2 VARCHAR(200)
);

CREATE TABLE ventas (
    id_venta INT NOT NULL,
    id_cliente INT,
    id_producto INT,
    id_usuario INT,
    precio FLOAT,
    fechaCompra DATE
);

CREATE TABLE imagenesInsumos (
    id_imagen INT AUTO_INCREMENT,
    id_categoria INT NOT NULL,
    nombre VARCHAR(500),
    ruta VARCHAR(500),
    fechaSubida DATE,
    PRIMARY KEY(id_imagen)
);

create table insumos(
				id_insumo int auto_increment,
				id_categoria INT NULL,
                id_proveedor INT NULL,
				id_imagen INT NOT NULL,
				id_usuario INT NOT NULL,
				nombre varchar(50),
				descripcion varchar(500),
				precio float,
				fechaCaptura date,
                estado BOOLEAN DEFAULT TRUE,
                cantidad INT NOT NULL,

				primary key(id_insumo)

						);

CREATE TABLE inventario_insumos (
    id_inventario_insumo INT AUTO_INCREMENT PRIMARY KEY,
    id_insumo INT NOT NULL,
    cantidad INT,
    fecha_ingreso DATE,
    id_proveedor INT NULL DEFAULT NULL,
    metodo_pago ENUM('efectivo', 'tarjeta', 'transferencia', 'otros') DEFAULT NULL,
    numero_factura VARCHAR(50) DEFAULT NULL,
    fecha_pago DATE DEFAULT NULL,
    estado_pago ENUM('pendiente', 'pagado', 'parcialmente_pagado', 'otros') DEFAULT NULL,
    precio float
);

CREATE TABLE categoriasInsumos (
    id_categoria INT AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    nombre VARCHAR(150),
    fechaCaptura DATE,
    PRIMARY KEY(id_categoria)
);

CREATE TABLE proveedores (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    razon_social VARCHAR(200),
    direccion VARCHAR(200),
    email VARCHAR(200),
    telefono VARCHAR(200),
    telefono2 VARCHAR(200),
    cuit INT NOT NULL
);

CREATE TABLE cabecera_remito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    fecha DATE NOT NULL,
    descuentos DECIMAL(10, 2),
    metodo_pago VARCHAR(50)
);

CREATE TABLE detalle_remito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cabecera_remito_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    importe DECIMAL(10, 2)
);

CREATE TABLE cabecera_nota_credito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    fecha DATE NOT NULL,
    descuentos DECIMAL(10, 2)
);

CREATE TABLE detalle_nota_credito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cabecera_nota_credito_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    importe DECIMAL(10, 2)
);


CREATE TABLE ajustes_productos_test (
    id_ajuste_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT,
    cantidad INT,
    motivo VARCHAR(100),
    id_usuario INT,
    fechaCaptura DATETIME

);


CREATE TABLE gastos (
    id_gasto INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT,
    id_usuario INT,
    nombre VARCHAR(255),
    descripcion VARCHAR(255), 
    cantidad INT,
    precio DECIMAL(10, 2),
    fecha_captura DATE,
    fecha_gasto DATE,
    metodo_pago ENUM('efectivo', 'tarjeta', 'transferencia', 'otros'),
    numero_factura VARCHAR(50),
    estado_pago ENUM('pendiente', 'pagado', 'parcialmente_pagado', 'otros') 
);


CREATE TABLE categoriasGastos (
    id_categoria INT AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    nombre VARCHAR(150),
    fechaCaptura DATE,
    PRIMARY KEY (id_categoria)
);

CREATE TABLE ajustes_insumos_test (
    id_ajuste_insumo INT AUTO_INCREMENT PRIMARY KEY,
    id_insumo INT,
    cantidad INT,
    motivo VARCHAR(100),
    id_usuario INT,
    fechaCaptura DATE
);



/*trigger para actualizar el inventario despues de vender*/


DELIMITER //
CREATE TRIGGER actualizar_inventario_despues_venta
AFTER INSERT ON detalle_remito
FOR EACH ROW
BEGIN
    DECLARE cantidad_vendida INT;

    SELECT cantidad INTO cantidad_vendida FROM detalle_remito WHERE id = NEW.id;


    INSERT INTO inventario_productos (id_producto, cantidad, fecha_ingreso)
    VALUES (NEW.producto_id, -cantidad_vendida, CURDATE());
END;
//
DELIMITER ;


/*fin*/



/*trigger para setear la cantidad en insumo despues de actualizarla en inventario*/


DELIMITER //

CREATE TRIGGER actualizar_cantidad_insumo AFTER INSERT ON inventario_insumos
    FOR EACH ROW
    BEGIN
        DECLARE total_cantidad INT;

        SELECT SUM(cantidad) INTO total_cantidad FROM inventario_insumos WHERE id_insumo = NEW.id_insumo;
        
        UPDATE insumos SET cantidad = total_cantidad WHERE id_insumo = NEW.id_insumo;
    END;
    
//
DELIMITER ;

DELIMITER //

CREATE TRIGGER actualizar_precio_insumo AFTER INSERT ON inventario_insumos
    FOR EACH ROW
    BEGIN
        DECLARE nuevo_precio FLOAT;

       
        SET nuevo_precio = NEW.precio;

        
        UPDATE insumos SET precio = nuevo_precio WHERE id_insumo = NEW.id_insumo;
    END;
    
//
DELIMITER ;


/*fin*/



/*trigger de ajuste productos e insumos*/

DELIMITER //

CREATE TRIGGER after_insert_ajuste_inventario
AFTER INSERT ON ajustes_productos_test
FOR EACH ROW
BEGIN
    DECLARE producto_precio FLOAT;
    SELECT precio INTO producto_precio FROM productos WHERE id_producto = NEW.id_producto;
    
    INSERT INTO inventario_productos (id_producto, cantidad, precio, fecha_ingreso)
    VALUES (NEW.id_producto, NEW.cantidad, producto_precio, CURDATE());
END;
//
DELIMITER ;


DELIMITER //

CREATE TRIGGER after_insert_ajuste_inventario_insumos
AFTER INSERT ON ajustes_insumos_test
FOR EACH ROW
BEGIN
    DECLARE insumo_precio FLOAT;
    SELECT precio INTO insumo_precio FROM insumos WHERE id_insumo = NEW.id_insumo;
    
    INSERT INTO inventario_insumos (id_insumo, cantidad, precio, fecha_ingreso)
    VALUES (NEW.id_insumo, NEW.cantidad, insumo_precio, CURDATE());
END;
//
DELIMITER ;


/*fin*/


/*trigger para setear la cantidad en productos despues de actualizarla en el inventario*/

DELIMITER //
CREATE TRIGGER actualizar_cantidad_producto AFTER INSERT ON inventario_productos
    FOR EACH ROW
    BEGIN
        DECLARE total_cantidad INT;

        SELECT SUM(cantidad) INTO total_cantidad FROM inventario_productos WHERE id_producto = NEW.id_producto;
        
        UPDATE productos SET cantidad = total_cantidad WHERE id_producto = NEW.id_producto;
    END;

//
DELIMITER ;


/*fin*/


/*trigger aumentar unidades luego de la nota de credito*/

DELIMITER //

CREATE TRIGGER after_detalle_nota_credito_insert
AFTER INSERT ON detalle_nota_credito
FOR EACH ROW
BEGIN
    DECLARE producto_id_temp INT;
    DECLARE cantidad_temp INT;
    DECLARE usuario_id_temp INT;

    
    SELECT producto_id, cantidad INTO producto_id_temp, cantidad_temp
    FROM detalle_nota_credito
    WHERE id = NEW.id;

    SET usuario_id_temp = 1; 

    
    INSERT INTO ajustes_productos_test (id_producto, cantidad, motivo, id_usuario, fechaCaptura)
    VALUES (producto_id_temp, cantidad_temp, 'devolucion', usuario_id_temp, NOW());
END //

DELIMITER ;



/*fin*/



/*triggers de eliminaciones de categoria*/

-- DELIMITER //
-- CREATE TRIGGER eliminar_categoria_trigger 
-- AFTER DELETE ON categoriasProductos
-- FOR EACH ROW
-- BEGIN
--     UPDATE productos
--     SET id_categoria = NULL
--     WHERE id_categoria = OLD.id_categoria;
-- END;
-- //
-- DELIMITER ;



-- DELIMITER //
-- CREATE TRIGGER eliminar_categoria_insumos_trigger 
-- AFTER DELETE ON categoriasInsumos
-- FOR EACH ROW
-- BEGIN
--     UPDATE insumos
--     SET id_categoria = NULL
--     WHERE id_categoria = OLD.id_categoria;
-- END;
-- //
-- DELIMITER ;



-- DELIMITER //
-- CREATE TRIGGER eliminar_categoria_gastos_trigger 
-- AFTER DELETE ON categoriasGastos
-- FOR EACH ROW
-- BEGIN
--     UPDATE gastos
--     SET id_categoria = NULL
--     WHERE id_categoria = OLD.id_categoria;
-- END;
-- //
-- DELIMITER ;

/*fin */
