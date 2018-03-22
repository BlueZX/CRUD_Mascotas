SELECT s.id, s.nombre, s.n_empleados
FROM sucursal s, mascota m, tipo_mascota t, detalleM d, boleta_mascota b
WHERE s.id = m.sucursal_id AND t.id = m.tipo_mascota_id AND m.id = d.mascota_id AND b.id = d.boleta_m_id AND s.n_empleados>9 AND t.descripcion='salvaje' AND b.fecha_venta>='01/01/2016' AND b.fecha_venta<='01/01/2017' 
