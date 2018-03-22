CREATE VIEW cantidad_r(region_id,raza_id,cantidad) AS(
   SELECT re.id, r.id, count(*)
   FROM ciudad c, sucursal s, mascota m, raza r, region re,detalleM d
   WHERE re.id = c.region_id AND c.id = s.ciudad_id AND m.raza_id = r.id AND m.id = d.mascota_id AND m.sucursal_id = s.id
   GROUP BY re.id, r.id
);

CREATE VIEW max_r(id,total) AS(
   SELECT region_id, max(cantidad)
   FROM cantidad_r cr
   GROUP BY region_id
);

SELECT cr.region_id, r.descripcion
FROM raza r, cantidad_r cr, max_r mr
WHERE mr.id = cr.region_id AND cr.raza_id = r.id AND mr.total = cr.cantidad 
