SELECT DISTINCT b.id, c.rut,c.nombre, e.rut, e.nombre, t.descripcion, r.descripcion, b.total, b.fecha_venta, ci.descripcion, s.nombre
FROM mascota m, raza r, sucursal s, boleta_mascota b, cliente c, detalleM d, empleado e, tipo_mascota t, ciudad ci
WHERE m.raza_id = r.id AND m.tipo_mascota_id = t.id AND m.sucursal_id = s.id AND s.ciudad_id = ci.id AND b.cliente_rut = c.rut AND b.empleado_rut = e.rut AND d.mascota_id = m.id AND d.boleta_m_id = b.id
