/* 
 * MySQL for VMCUSTOM_THESISPRINTING
 * ekerner@ekerner.com
 */

CREATE TABLE IF NOT EXISTS #__vmcustom_thesisprinting_name_formats (
	id TINYINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name_format VARCHAR(128) NOT NULL,
	CONSTRAINT UNIQUE (name_format)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO #__vmcustom_thesisprinting_name_formats VALUES
(1, 'Smith J.'),
(2, 'Smith John'),
(3, 'J. Smith'),
(4, 'John Smith');

CREATE TABLE IF NOT EXISTS #__vmcustom_thesisprinting_spine_formats (
	id TINYINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	spine_format VARCHAR(256) NOT NULL,
	CONSTRAINT UNIQUE (spine_format)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO #__vmcustom_thesisprinting_spine_formats VALUES
(1, 'Bottom to Top'),
(2, 'Top to Bottom');

CREATE TABLE IF NOT EXISTS #__vmcustom_thesisprinting_universities (
	id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	logo1 VARCHAR(256),
	logo2 VARCHAR(256),
	university_name VARCHAR(256) NOT NULL,
	CONSTRAINT UNIQUE (university_name),
	color1 VARCHAR(32) DEFAULT '#000000',
	color2 VARCHAR(32) DEFAULT '#111111',
	name_format TINYINT,
	FOREIGN KEY (name_format) REFERENCES #__vmcustom_thesisprinting_name_formats(name_format) ON DELETE SET NULL,
	spine_format TINYINT,
	FOREIGN KEY (spine_format) REFERENCES #__vmcustom_thesisprinting_spine_formats(spine_format) ON DELETE SET NULL,
	published int(11) NOT NULL DEFAULT 1,
	ordering int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS #__vmcustom_thesisprinting_degrees (
	id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	degree_name VARCHAR(256) NOT NULL,
	CONSTRAINT UNIQUE (degree_name),
	degree_desc VARCHAR(256),
	published int(11) NOT NULL DEFAULT 1,
	ordering int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

