# Kilogramos Recolectados Este mes
# Barras
# Cada Residuo

SELECT res.nombre AS 'Item', sum(cantidad)  AS 'Cantidad'
FROM manifiesto AS man INNER JOIN relgenman USING(idmanifiesto) INNER JOIN generador AS gen USING(idgenerador) 
	INNER JOIN relmanrec USING(idmanifiesto) INNER JOIN recoleccion USING(idrecoleccion) INNER JOIN relresrec USING(idrecoleccion) INNER JOIN residuo AS res USING(idresiduo)
__WHR__ AND YEAR(man.fecha) = YEAR(CURDATE()) AND MONTH(man.fecha) = MONTH(CURDATE()) AND cantidad != 0.0
GROUP BY res.nombre