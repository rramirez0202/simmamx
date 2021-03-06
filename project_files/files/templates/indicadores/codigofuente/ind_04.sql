# Servicios Con icidencia del Mes Anterior
# Pie
# Cada motivo del pie

SELECT cat.descripcion AS 'Item',COUNT(*) AS 'Cantidad'
FROM manifiesto AS man INNER JOIN relgenman USING(idmanifiesto) INNER JOIN generador AS gen USING(idgenerador) INNER JOIN catalogodet AS cat ON man.motivo = cat.idcatalogodet
__WHR__ AND YEAR(man.fecha) = IF(MONTH(CURDATE())=1,YEAR(CURDATE())-1,YEAR(CURDATE())) AND MONTH(man.fecha) = IF(MONTH(CURDATE())=1,12,MONTH(CURDATE())-1)
GROUP BY cat.descripcion;