SELECT c.rut,c.nombre,m.id,m.color_predominante
FROM cliente c, mascota m, raza r, boleta_mascota bm, detalleM dm, tipo_mascota tm
WHERE dm.mascota_id = m.id AND m.raza_id = r.id AND c.rut = bm.cliente_rut AND dm.boleta_m_id = bm.id AND tm.descripcion='domestico' AND r.descripcion='labrador' AND c.rut NOT IN (
      SELECT cl.rut
      FROM cliente cl, mascota ma, raza ra, boleta_mascota bom, detalleM dem
      WHERE cl.rut = bom.cliente_rut AND ma.id = dem.mascota_id AND bom.id = dem.boleta_m_id AND ra.id = ma.raza_id AND ra.descripcion='chiguagua'
      );
