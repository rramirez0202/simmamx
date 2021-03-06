# Servicios Calendarizados y Reportados Este Mes
# Barras
# 	Calendarizados, Servicios en calendario
# 	Reportados (Total), Servicios reportados
# 	Calendarizados y Reportados, Servicios en calendario reportados
# 	No Reportados, Servicios en calendario no reportados
#	Extra, Servicios fuera de calendario reportados

SELECT 'Serv. Calendarizados' AS 'Item',COUNT(DISTINCT idgenerador,fecha) AS 'Cantidad'
FROM calendario AS cal INNER JOIN relgencal USING(idcalendario) INNER JOIN generador AS gen USING(idgenerador)
__WHR__ AND YEAR(cal.fecha) = YEAR(CURDATE()) AND MONTH(cal.fecha) = MONTH(CURDATE())
UNION
SELECT 'Serv. Rep. (Total)',COUNT(DISTINCT idgenerador,fecha)
FROM manifiesto AS man INNER JOIN relgenman USING(idmanifiesto) INNER JOIN generador AS gen USING(idgenerador)
__WHR__ AND YEAR(man.fecha) = YEAR(CURDATE()) AND MONTH(man.fecha) = MONTH(CURDATE())
UNION
SELECT 'Serv. Calend. y Rep',COUNT(DISTINCT idgenerador,fecha)
FROM manifiesto AS man INNER JOIN relgenman USING(idmanifiesto) INNER JOIN generador AS gen USING(idgenerador) LEFT JOIN relgencal USING(idgenerador) LEFT JOIN calendario USING(idcalendario,fecha)
__WHR__ AND YEAR(man.fecha) = YEAR(CURDATE()) AND MONTH(man.fecha) = MONTH(CURDATE()) AND idcalendario IS NOT NULL
UNION
SELECT 'Serv. Rep. sin Cal.',COUNT(DISTINCT idgenerador,fecha)
FROM manifiesto AS man INNER JOIN relgenman USING(idmanifiesto) INNER JOIN generador AS gen USING(idgenerador) LEFT JOIN relgencal USING(idgenerador) LEFT JOIN calendario USING(idcalendario,fecha)
__WHR__ AND YEAR(man.fecha) = YEAR(CURDATE()) AND MONTH(man.fecha) = MONTH(CURDATE()) AND idcalendario IS NULL
UNION
SELECT 'Serv. Calend. Pend. de Rep.',COUNT(DISTINCT idgenerador,fecha) as t
FROM calendario AS cal INNER JOIN relgencal USING(idcalendario) INNER JOIN generador AS gen USING(idgenerador)
__WHR__ AND YEAR(cal.fecha) = YEAR(CURDATE()) AND MONTH(cal.fecha) = MONTH(CURDATE()) AND CONCAT(CONVERT(idgenerador,CHAR(10)),'-',CONVERT(fecha,CHAR(10))) NOT IN (
	SELECT CONCAT(CONVERT(idgenerador,CHAR(10)),'-',CONVERT(fecha,CHAR(10))) FROM manifiesto AS man INNER JOIN relgenman USING (idmanifiesto) INNER JOIN generador AS gen USING(idgenerador)
	__WHR__ AND YEAR(man.fecha) = YEAR(CURDATE()) AND MONTH(man.fecha) = MONTH(CURDATE())
)