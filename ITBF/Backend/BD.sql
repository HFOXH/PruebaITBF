-- Creación de la tabla de hoteles
CREATE TABLE hoteles (
    id serial PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    nit VARCHAR(12) NOT NULL
);

-- Creación de tabla de tipos de habitaciones
CREATE TABLE tipos_habitacion (
    id serial PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL CHECK (nombre IN ('Estandar', 'Junior', 'Suite')),
    cantidad INT NOT NULL,
    acomodacion VARCHAR(50) NOT NULL CHECK (acomodacion IN ('Sencilla', 'Doble', 'Triple')),
    hotel_id INT REFERENCES hoteles(id) -- Agregar una columna de clave foránea para referenciar el hotel
);

INSERT INTO tipos_habitacion (nombre, cantidad, acomodacion, hotel_id)
VALUES ('Estandar', 25, 'Sencilla', 12);