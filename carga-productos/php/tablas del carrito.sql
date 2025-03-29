CREATE TABLE IF NOT EXISTS carrito_cabecera(
    id int autoincrement primary key,
    cliente int,
    total int,
    finalizado int
);
CREATE TABLE IF NOT EXISTS carrito_detalle(
    id int autoincrement primary key,
    cabecera_id int,
    posicion_producto int,
    producto_id int,
    precio_unitario int,
    cantidad int,
    total_pagar_producto int,
    FOREIGN KEY (cabecera_id) REFERENCES  carrito_cabecera(id)
);