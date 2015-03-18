--
-- Table structure for MySQL database
--
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alphabeticCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numericCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `minorUnit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alphabetic_codes` (`alphabeticCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;