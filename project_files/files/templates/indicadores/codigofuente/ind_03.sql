# Servicios Con icidencia Este Mes
# Pie
# Cada motivo del pie

SELECT cat.descripcion AS 'Item',COUNT(*) AS 'Cantidad'
FROM manifiesto AS man INNER JOIN relgenman USING(idmanifiesto) INNER JOIN generador AS gen USING(idgenerador) INNER JOIN catalogodet AS cat ON man.motivo = cat.idcatalogodet
__WHR__ AND YEAR(man.fecha) = YEAR(CURDATE()) AND MONTH(man.fecha) = MONTH(CURDATE())
GROUP BY cat.descripcion;