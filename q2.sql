SELECT DISTINCT s.id, s.nombre, t.id, t.descripcion, count(*)
FROM mascota m, sucursal s, tipo_mascota t, detalleM d
WHERE t.id = m.tipo_mascota_id AND m.id = d.boleta_m_id AND s.id = m.sucursal_id
GROUP BY s.id, s.nombre, t.id, t.descripcion
