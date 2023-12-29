CREATE TABLE users (
    id_us INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(40) UNIQUE NOT NULL,
    password VARCHAR(20) NOT NULL
);

CREATE TABLE tournoi (
    id_tournoi INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    intitule VARCHAR(40) NOT NULL,
    nbre_equipes INT,
    date_debut DATE NOT NULL,
    date_fin DATE,
    FOREIGN KEY (id_user) REFERENCES users(id_us) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE equipe (
    id_equipe INT PRIMARY KEY AUTO_INCREMENT,
    nom_equipe VARCHAR(50) NOT NULL,
    pays VARCHAR(50),
    autres_informations VARCHAR(255),
    tournoi_id INT,
    user_id INT,
    FOREIGN KEY (tournoi_id) REFERENCES tournoi(id_tournoi) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id_us) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `match` (
    id_match INT PRIMARY KEY AUTO_INCREMENT,
    id_tournoi INT,
    equipe1 VARCHAR(255),
    equipe2 VARCHAR(255),
    score_equipe1 INT,
    score_equipe2 INT,
    FOREIGN KEY (id_tournoi) REFERENCES tournoi (id_tournoi)
);



-- ---------------------------------Apres modifications





DROP TABLE if EXISTS users;
DROP Table IF EXISTS tournoi;