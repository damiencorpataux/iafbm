DROP TABLE IF EXISTS permis;
CREATE TABLE permis (
    id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
) TYPE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO permis VALUES (1,'Permis A');
INSERT INTO permis VALUES (2,'Permis B');