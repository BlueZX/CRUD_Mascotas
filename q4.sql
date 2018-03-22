CREATE VIEW cantidad_a(id,total) AS(
    SELECT c.id, count(*)
    FROM accesorio a, categoria c, detalleA d
    WHERE c.id = a.categoria_id AND c.id = a.categoria_id
    GROUP BY c.id
);


SELECT a.id, a.descripcion, c.descripcion
FROM accesorio a, categoria c, cantidad_a ca
WHERE c.id = ca.id AND c.id = a.id AND ca.total = (SELECT max(total) FROM cantidad_a);
