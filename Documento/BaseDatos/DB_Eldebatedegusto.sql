CREATE DATABASE  IF NOT EXISTS `eldebatedegusto` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `eldebatedegusto`;
-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: localhost    Database: eldebatedegusto
-- ------------------------------------------------------
-- Server version	5.6.27-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `almacen`
--

DROP TABLE IF EXISTS `almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `almacen` (
  `id_almacen` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `telefono` varchar(300) DEFAULT NULL,
  `cantidadMin` decimal(10,2) DEFAULT NULL,
  `restaurante_id` int(11) NOT NULL,
  PRIMARY KEY (`id_almacen`),
  KEY `fk_almacen_restaurante1_idx` (`restaurante_id`),
  CONSTRAINT `fk_almacen_restaurante1` FOREIGN KEY (`restaurante_id`) REFERENCES `restaurante` (`id_restaurante`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `almacen`
--

LOCK TABLES `almacen` WRITE;
/*!40000 ALTER TABLE `almacen` DISABLE KEYS */;
/*!40000 ALTER TABLE `almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) DEFAULT NULL,
  `ci` varchar(45) DEFAULT NULL,
  `cuenta` varchar(45) DEFAULT NULL,
  `contrasena` varchar(45) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `fechanacimiento` varchar(45) DEFAULT NULL,
  
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallefactura`
--

DROP TABLE IF EXISTS `detallefactura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detallefactura` (
  `factura_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `plato_id` int(11) DEFAULT NULL,
  `Producto_Id` int(11) DEFAULT NULL,
  KEY `fk_detalleFactura_factura1_idx` (`factura_id`),
  KEY `fk_detalleFactura_plato1_idx` (`plato_id`),
  KEY `fk_detalleFactura_Producto1_idx` (`Producto_Id`),
  CONSTRAINT `fk_detalleFactura_Producto1` FOREIGN KEY (`Producto_Id`) REFERENCES `producto` (`Id_Producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalleFactura_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id_factura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalleFactura_plato1` FOREIGN KEY (`plato_id`) REFERENCES `plato` (`id_plato`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallefactura`
--

LOCK TABLES `detallefactura` WRITE;
/*!40000 ALTER TABLE `detallefactura` DISABLE KEYS */;
/*!40000 ALTER TABLE `detallefactura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallepedido`
--

DROP TABLE IF EXISTS `detallepedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detallepedido` (
  `pedido_id` int(11) NOT NULL,
  `plato_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `Producto_Id` int(11) DEFAULT NULL,
  KEY `fk_detallePedido_pedido1_idx` (`pedido_id`),
  KEY `fk_detallePedido_plato1_idx` (`plato_id`),
  KEY `fk_detallePedido_Producto1_idx` (`Producto_Id`),
  CONSTRAINT `fk_detallePedido_Producto1` FOREIGN KEY (`Producto_Id`) REFERENCES `producto` (`Id_Producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detallePedido_pedido1` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detallePedido_plato1` FOREIGN KEY (`plato_id`) REFERENCES `plato` (`id_plato`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallepedido`
--

LOCK TABLES `detallepedido` WRITE;
/*!40000 ALTER TABLE `detallepedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `detallepedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(300) DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  PRIMARY KEY (`id_direccion`),
  KEY `fk_direccion_cliente1_idx` (`cliente_id`),
  CONSTRAINT `fk_direccion_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` varchar(45) DEFAULT NULL,
  `nroFactura` int(11) DEFAULT NULL,
  `nombre` varchar(300) DEFAULT NULL,
  `nit` varchar(45) DEFAULT NULL,
  `codigoControl` varchar(45) DEFAULT NULL,
  `autorizacion` varchar(100) DEFAULT NULL,
  `llavedosificacion` longtext,
  `total` decimal(10,2) DEFAULT NULL,
  `totalDescrito` varchar(300) DEFAULT NULL,
  `estado` varchar(45) DEFAULT 'ACTIVA',
  `sucursal_id` int(11) NOT NULL,
  PRIMARY KEY (`id_factura`),
  KEY `fk_factura_sucursal1_idx` (`sucursal_id`),
  CONSTRAINT `fk_factura_sucursal1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingrediente`
--

DROP TABLE IF EXISTS `ingrediente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingrediente` (
  `plato_id_plato` int(11) NOT NULL,
  `Producto_Id_Producto` int(11) NOT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  KEY `fk_ingrediente_plato1_idx` (`plato_id_plato`),
  KEY `fk_ingrediente_Producto1_idx` (`Producto_Id_Producto`),
  CONSTRAINT `fk_ingrediente_Producto1` FOREIGN KEY (`Producto_Id_Producto`) REFERENCES `producto` (`Id_Producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingrediente_plato1` FOREIGN KEY (`plato_id_plato`) REFERENCES `plato` (`id_plato`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingrediente`
--

LOCK TABLES `ingrediente` WRITE;
/*!40000 ALTER TABLE `ingrediente` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingrediente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kardex`
--

DROP TABLE IF EXISTS `kardex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kardex` (
  `Id_Kardex` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) DEFAULT NULL,
  `precio_compra` decimal(10,2) DEFAULT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  `movimiento` varchar(45) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL,
  `Producto_Id` int(11) NOT NULL,
  `personal_id` int(11) NOT NULL,
  `sucursal_id` int(11) DEFAULT NULL,
  `almacen_id` int(11) DEFAULT NULL,
  `factura_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_Kardex`),
  KEY `fk_Kardex_Producto_idx` (`Producto_Id`),
  KEY `fk_Kardex_personal1_idx` (`personal_id`),
  KEY `fk_Kardex_sucursal1_idx` (`sucursal_id`),
  KEY `fk_Kardex_almacen1_idx` (`almacen_id`),
  KEY `fk_Kardex_factura1_idx` (`factura_id`),
  CONSTRAINT `fk_Kardex_Producto` FOREIGN KEY (`Producto_Id`) REFERENCES `producto` (`Id_Producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kardex_almacen1` FOREIGN KEY (`almacen_id`) REFERENCES `almacen` (`id_almacen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kardex_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id_factura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kardex_personal1` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id_personal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kardex_sucursal1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kardex`
--

LOCK TABLES `kardex` WRITE;
/*!40000 ALTER TABLE `kardex` DISABLE KEYS */;
/*!40000 ALTER TABLE `kardex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesa`
--

DROP TABLE IF EXISTS `mesa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mesa` (
  `id_mesa` int(11) NOT NULL AUTO_INCREMENT,
  `nromesa` varchar(45) DEFAULT NULL,
  `sucursal_id` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT 'LIBRE',
  PRIMARY KEY (`id_mesa`),
  KEY `fk_mesa_sucursal1_idx` (`sucursal_id`),
  CONSTRAINT `fk_mesa_sucursal1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesa`
--

LOCK TABLES `mesa` WRITE;
/*!40000 ALTER TABLE `mesa` DISABLE KEYS */;
/*!40000 ALTER TABLE `mesa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` varchar(50) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL COMMENT 'estado:  pagado delivery\n              pagado restaurante\n              atendiendo restaurante\n              pendiente delivery',
  `mesa_id` int(11) DEFAULT NULL,
  `personal_id` int(11) DEFAULT NULL,
  `nro` int(11) DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `fk_pedido_mesa1_idx` (`mesa_id`),
  KEY `fk_pedido_personal1_idx` (`personal_id`),
  KEY `fk_pedido_cliente1_idx` (`cliente_id`),
  CONSTRAINT `fk_pedido_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_mesa1` FOREIGN KEY (`mesa_id`) REFERENCES `mesa` (`id_mesa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_personal1` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id_personal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal` (
  `id_personal` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) DEFAULT NULL,
  `cuenta` varchar(40) DEFAULT NULL,
  `contrasena` varchar(40) DEFAULT NULL,
  `rol` varchar(100) DEFAULT NULL,
  `sueldo` decimal(10,2) DEFAULT NULL,
  `estado` varchar(45) DEFAULT 'activo',
  `fechaContratado` varchar(45) DEFAULT NULL,
  `sucursal_id` int(11) DEFAULT NULL,
  `almacen_id` int(11) DEFAULT NULL,
  `telefono` varchar(200) DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_personal`),
  KEY `fk_personal_sucursal1_idx` (`sucursal_id`),
  KEY `fk_personal_almacen1_idx` (`almacen_id`),
  CONSTRAINT `fk_personal_almacen1` FOREIGN KEY (`almacen_id`) REFERENCES `almacen` (`id_almacen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_personal_sucursal1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plato`
--

DROP TABLE IF EXISTS `plato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plato` (
  `id_plato` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `preparacion` longtext,
  PRIMARY KEY (`id_plato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plato`
--

LOCK TABLES `plato` WRITE;
/*!40000 ALTER TABLE `plato` DISABLE KEYS */;
/*!40000 ALTER TABLE `plato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `Id_Producto` int(11) NOT NULL AUTO_INCREMENT,
  `Precio_Compra` decimal(10,2) DEFAULT NULL,
  `Precio_Venta` decimal(10,2) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `Unidad_Id` int(11) NOT NULL,
  PRIMARY KEY (`Id_Producto`),
  KEY `fk_Producto_Unidad1_idx` (`Unidad_Id`),
  CONSTRAINT `fk_Producto_Unidad1` FOREIGN KEY (`Unidad_Id`) REFERENCES `unidad` (`Id_Unidad`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regional`
--

DROP TABLE IF EXISTS `regional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regional` (
  `id_regional` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_regional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regional`
--

LOCK TABLES `regional` WRITE;
/*!40000 ALTER TABLE `regional` DISABLE KEYS */;
/*!40000 ALTER TABLE `regional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurante`
--

DROP TABLE IF EXISTS `restaurante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurante` (
  `id_restaurante` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) DEFAULT NULL,
  `razon_social` longtext,
  `logo` longtext,
  `fechaCreacion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_restaurante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurante`
--

LOCK TABLES `restaurante` WRITE;
/*!40000 ALTER TABLE `restaurante` DISABLE KEYS */;
/*!40000 ALTER TABLE `restaurante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL,
  `sucursal_id` int(11) DEFAULT NULL,
  `almacen_id` int(11) DEFAULT NULL,
  `Producto_Id` int(11) NOT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_stock`),
  KEY `fk_stock_sucursal1_idx` (`sucursal_id`),
  KEY `fk_stock_almacen1_idx` (`almacen_id`),
  KEY `fk_stock_Producto1_idx` (`Producto_Id`),
  CONSTRAINT `fk_stock_Producto1` FOREIGN KEY (`Producto_Id`) REFERENCES `producto` (`Id_Producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_stock_almacen1` FOREIGN KEY (`almacen_id`) REFERENCES `almacen` (`id_almacen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_stock_sucursal1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursal`
--

DROP TABLE IF EXISTS `sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sucursal` (
  `id_sucursal` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(250) DEFAULT NULL,
  `nit` varchar(45) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `nro_Factura` int(11) DEFAULT NULL,
  `fecha_factura` varchar(45) DEFAULT NULL,
  `llave_docificacion` longtext,
  `sucursalcol` varchar(45) DEFAULT NULL,
  `regional_id` int(11) DEFAULT NULL,
  `cantidadMinima` decimal(10,2) DEFAULT NULL,
  `restaurante_id` int(11) NOT NULL,
  PRIMARY KEY (`id_sucursal`),
  KEY `fk_sucursal_regional1_idx` (`regional_id`),
  KEY `fk_sucursal_restaurante1_idx` (`restaurante_id`),
  CONSTRAINT `fk_sucursal_regional1` FOREIGN KEY (`regional_id`) REFERENCES `regional` (`id_regional`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sucursal_restaurante1` FOREIGN KEY (`restaurante_id`) REFERENCES `restaurante` (`id_restaurante`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursal`
--

LOCK TABLES `sucursal` WRITE;
/*!40000 ALTER TABLE `sucursal` DISABLE KEYS */;
/*!40000 ALTER TABLE `sucursal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefono`
--

DROP TABLE IF EXISTS `telefono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telefono` (
  `id_telefono` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) DEFAULT NULL,
  `sucursal_id` int(11) NOT NULL,
  PRIMARY KEY (`id_telefono`),
  KEY `fk_telefono_sucursal1_idx` (`sucursal_id`),
  CONSTRAINT `fk_telefono_sucursal1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefono`
--

LOCK TABLES `telefono` WRITE;
/*!40000 ALTER TABLE `telefono` DISABLE KEYS */;
/*!40000 ALTER TABLE `telefono` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidad`
--

DROP TABLE IF EXISTS `unidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidad` (
  `Id_Unidad` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id_Unidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidad`
--

LOCK TABLES `unidad` WRITE;
/*!40000 ALTER TABLE `unidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `unidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'eldebatedegusto'
--

--
-- Dumping routines for database 'eldebatedegusto'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-15 10:11:45
