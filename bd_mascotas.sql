CREATE TABLE raza(id INTEGER NOT NULL,
                  descripcion VARCHAR(20),
                  PRIMARY KEY(id)
);
CREATE TABLE tipo_mascota(id INTEGER NOT NULL,
                  descripcion VARCHAR(20),
                  PRIMARY KEY(id)
);

CREATE TABLE categoria(id INTEGER NOT NULL,
                  descripcion VARCHAR(20),
                  PRIMARY KEY(id)
);
CREATE TABLE puesto(id INTEGER NOT NULL,
                  descripcion VARCHAR(50),
                  PRIMARY KEY(id)
);
CREATE TABLE region(id INTEGER NOT NULL,
                  descripcion VARCHAR(50),
                  PRIMARY KEY(id)
);
CREATE TABLE ciudad(id INTEGER NOT NULL,
                  descripcion VARCHAR(50),
                  region_id INTEGER NOT NULL,
                  FOREIGN KEY(region_id) REFERENCES region(id),
                  PRIMARY KEY(id)
);

CREATE TABLE sucursal(id INTEGER NOT NULL,
                  nombre VARCHAR(20),
                  telefono INTEGER,
                  n_empleados INTEGER,
                  calle VARCHAR(30),
                  numero INTEGER,
                  ciudad_id INTEGER NOT NULL,
                  FOREIGN KEY(ciudad_id) REFERENCES ciudad(id),
                  PRIMARY KEY(id)
);

CREATE TABLE empleado(rut VARCHAR(12) NOT NULL,
                  nombre VARCHAR(20),
                  telefono INTEGER,
                  calle VARCHAR(30),
                  numero INTEGER,
                  ciudad_id INTEGER NOT NULL,
                  sucursal_id INTEGER NOT NULL,
                  puesto_id INTEGER NOT NULL,
                  PRIMARY KEY(rut),
                  FOREIGN KEY(ciudad_id) REFERENCES ciudad(id),
                  FOREIGN KEY(sucursal_id) REFERENCES sucursal(id),
                  FOREIGN KEY(puesto_id) REFERENCES puesto(id)
);
CREATE TABLE cliente(rut VARCHAR(12) NOT NULL,
                  nombre VARCHAR(20),
                  telefono INTEGER,
                  calle VARCHAR(30),
                  numero INTEGER,
                  ciudad_id INTEGER NOT NULL,
                  PRIMARY KEY(rut),
                  FOREIGN KEY(ciudad_id) REFERENCES ciudad(id)
);

CREATE TABLE boleta_mascota(id INTEGER NOT NULL,
                  fecha_venta DATE,
                  monto_neto INTEGER,
                  iva INTEGER,
                  total INTEGER,
                  cliente_rut VARCHAR(12) NOT NULL,
                  empleado_rut varchar(12) NOT NULL,
                  FOREIGN KEY(empleado_rut) REFERENCES empleado(rut),
                  FOREIGN KEY(cliente_rut) REFERENCES cliente(rut),
                  PRIMARY KEY(id)
);
 
CREATE TABLE boleta_accesorio(id INTEGER NOT NULL,
                  fecha_venta DATE,
                  monto_neto INTEGER,
                  iva INTEGER,
                  total INTEGER,
                  cliente_rut VARCHAR(12) NOT NULL,
                  empleado_rut varchar(12) NOT NULL,
                  FOREIGN KEY(empleado_rut) REFERENCES empleado(rut),
                  FOREIGN KEY(cliente_rut) REFERENCES cliente(rut),
                  PRIMARY KEY(id)
);


 
CREATE TABLE mascota(id INTEGER NOT NULL,
                    tamano INTEGER,
                    precio_venta INTEGER,
                    color_predominante VARCHAR(20),
                    raza_id INTEGER NOT NULL,
                    tipo_mascota_id INTEGER NOT NULL,
                    sucursal_id INTEGER NOT NULL,
                    PRIMARY KEY(id),
                    FOREIGN KEY(raza_id) REFERENCES raza(id),
                    FOREIGN KEY(tipo_mascota_id) REFERENCES tipo_mascota(id),
                    FOREIGN KEY(sucursal_id) REFERENCES sucursal(id)
);
 
CREATE TABLE accesorio(id INTEGER NOT NULL,
                  descripcion VARCHAR(50),
                  precio_venta INTEGER,
                  categoria_id INTEGER NOT NULL,
                  sucursal_id INTEGER NOT NULL,
                  PRIMARY KEY(id),
                  FOREIGN KEY(categoria_id) REFERENCES categoria(id),
                  FOREIGN KEY(sucursal_id) REFERENCES sucursal(id)
);
 
CREATE TABLE detalleA(accesorio_id INTEGER NOT NULL,
                      boleta_a_id INTEGER NOT NULL,
                      PRIMARY KEY(accesorio_id,boleta_a_id),
                      FOREIGN KEY(accesorio_id) REFERENCES accesorio(id),
                      FOREIGN KEY(boleta_a_id) REFERENCES boleta_accesorio(id)
);
 
CREATE TABLE detalleM(mascota_id INTEGER NOT NULL,
                      boleta_m_id INTEGER NOT NULL,
                      PRIMARY KEY(mascota_id,boleta_m_id),
                      FOREIGN KEY(mascota_id) REFERENCES mascota(id),
                      FOREIGN KEY(boleta_m_id) REFERENCES boleta_mascota(id)
);

INSERT INTO raza VALUES(1,'boxer');
INSERT INTO raza VALUES(2,'labrador');
INSERT INTO raza VALUES(3,'chiguagua');

INSERT INTO tipo_mascota VALUES(1,'domestico');
INSERT INTO tipo_mascota VALUES(2,'salvaje');
INSERT INTO tipo_mascota VALUES(3,'semi-domestico');

INSERT INTO categoria VALUES(1,'juguete');
INSERT INTO categoria VALUES(2,'alimento');
INSERT INTO categoria VALUES(3,'collar');

INSERT INTO puesto VALUES(1,'gerente');
INSERT INTO puesto VALUES(2,'vendedor');
INSERT INTO puesto VALUES(3,'veterinario');

INSERT INTO region VALUES(1,'biobio');
INSERT INTO region VALUES(2,'ñuble');
INSERT INTO region VALUES(3,'atacama');

INSERT INTO ciudad VALUES(1,'concepcion',1);
INSERT INTO ciudad VALUES(2,'chillan',2);
INSERT INTO ciudad VALUES(3,'chiguayante',1);

INSERT INTO sucursal VALUES(1,'perrogato',987654321,120,'calle falsa',123,1);
INSERT INTO sucursal VALUES(2,'mascotasasdf',987654322,91,'calle falsa',223,2);
INSERT INTO sucursal VALUES(3,'dinosauriossss',987654321,50,'calle falsa',333,1);

INSERT INTO empleado VALUES('10.000.000-1','morty smith',98765432,'calle zneel',736,1,1,2);
INSERT INTO empleado VALUES('11.000.000-1','Jerry smith',99735433,'calle beibi',313,1,1,1);
INSERT INTO empleado VALUES('12.220.000-1','juan asdf',98765432,'calle lgi',2332,2,2,3);

INSERT INTO cliente VALUES('19.234.321-K','Bojack',45665445,'calle rial',123,1);
INSERT INTO cliente VALUES('19.333.333-3','Rick Sanchez',75675745,'calle rial',333,2);
INSERT INTO cliente VALUES('19.222.123-1','BirdPerson',85868488,'calle rial',444,1);
 
INSERT INTO mascota VALUES(1,200,50000,'cafe',2,1,1);
INSERT INTO mascota VALUES(2,250,40000,'blanco',3,1,2);
INSERT INTO mascota VALUES(3,100,30000,'cafe',1,1,3);

INSERT INTO accesorio VALUES(1,'alimento de perro',12000,2,1);
INSERT INTO accesorio VALUES(2,'collar de perro',7000,3,1);
INSERT INTO accesorio VALUES(3,'collar de cocodrilo',17000,3,1);

INSERT INTO boleta_mascota VALUES(1,'12/01/1999',50000,9500,59500,'19.234.321-K','10.000.000-1');
INSERT INTO boleta_mascota VALUES(2,'12/01/2017',14000,2660,16660,'19.234.321-K','11.000.000-1');
INSERT INTO boleta_mascota VALUES(3,'10/12/2017',20000,3800,23800,'19.333.333-3','12.220.000-1');

INSERT INTO boleta_accesorio VALUES(1,'01/03/2017',10000,1900,11900,'19.234.321-K','10.000.000-1');
INSERT INTO boleta_accesorio VALUES(2,'09/01/2017',12000,2280,14280,'19.234.321-K','11.000.000-1');
INSERT INTO boleta_accesorio VALUES(3,'07/10/2017',6000,1140,7140,'19.333.333-3','12.220.000-1');

INSERT INTO detalleA VALUES(1,1);
INSERT INTO detalleA VALUES(2,2);
INSERT INTO detalleA VALUES(3,1);

INSERT INTO detalleM VALUES(1,1);
INSERT INTO detalleM VALUES(2,2);
INSERT INTO detalleM VALUES(3,3);

INSERT INTO mascota VALUES(4,232,10000,'azul',2,1,1);

INSERT INTO boleta_mascota VALUES(4,'13/12/2017',20000,3800,23800,'19.222.123-1','12.220.000-1');

INSERT INTO detalleM VALUES(4,4);

INSERT INTO mascota VALUES(5,332,10000,'rojo',2,1,2);

INSERT INTO boleta_mascota VALUES(5,'10/12/2017',20000,3800,23800,'19.222.123-1','10.000.000-1');

INSERT INTO detalleM VALUES(5,5);

INSERT INTO mascota VALUES(6,632,10000,'blanco',1,2,3);
