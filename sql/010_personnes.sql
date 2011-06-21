DROP TABLE IF EXISTS personnes;
CREATE TABLE personnes (
    id INT NOT NULL AUTO_INCREMENT,
    id_unil INT,
    id_chuv INT,
    id_adifac INT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    adresse VARCHAR(100),
    tel VARCHAR(15),
    email VARCHAR(50) NOT NULL,
    date_naissance DATE NOT NULL,
    etat_civil VARCHAR(10),
    sexe VARCHAR(1) NOT NULL,
    pays_id INT NOT NULL,
    canton_id INT,
    permis_id INT,
    titre_lecon_inaug VARCHAR(100),
    date_lecon_inaug DATE,
    actif BOOLEAN NOT NULL DEFAULT TRUE,
    created TIMESTAMP NULL DEFAULT NULL,
    modified TIMESTAMP NULL DEFAULT NULL,
    util_creat INT,
    util_modif INT,
    PRIMARY KEY (id),
    FOREIGN KEY (pays_id) REFERENCES pays(id),
    FOREIGN KEY (canton_id) REFERENCES cantons(id),
    FOREIGN KEY (permis_id) REFERENCES permis(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
