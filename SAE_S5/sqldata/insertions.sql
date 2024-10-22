-- 1. Insertions dans la table LIEUX
INSERT INTO LIEUX (ID, nom, adresse, nbPlacesAssises, nbPlacesDebout, images) VALUES
('L1', 'Théâtre National', '123 Rue du Théâtre, Paris', 500, 1000, 'theatre1.jpg'),
('L2', 'Salle des Fêtes', '45 Boulevard de la Musique, Lyon', 300, 700, 'salleFetes.jpg'),
('L3', 'Stade Municipal', '12 Rue des Sports, Marseille', 1000, 2000, 'stade.jpg');

-- 2. Insertions dans la table SOIREES
INSERT INTO SOIREES (ID, nom, thematique, dateSoiree, lieuSoiree, nbPlaces, tarif, tarifReduit) VALUES
('S1', 'Soirée Comédie', 'Comédie', '2024-11-05 20:00:00', 'L1', 1000, 20.0, 15.0),
('S2', 'Soirée Jazz', 'Jazz', '2024-11-12 21:00:00', 'L2', 500, 25.0, 18.0),
('S3', 'Concert Rock', 'Rock', '2024-12-01 19:30:00', 'L3', 3000, 30.0, 22.0);

-- 3. Insertions dans la table SPECTACLES
INSERT INTO SPECTACLES (ID, titre, description, images, urlVideo, style, horaire) VALUES
('SP1', 'Spectacle Humour', 'Un show plein de rires avec les meilleurs humoristes.', 'humour.jpg', 'http://humour.com', 'Humour', '2024-11-05 20:30:00'),
('SP2', 'Concert Jazz', 'Un concert intime de jazz avec un groupe de musiciens talentueux.', 'jazz.jpg', 'http://jazz.com', 'Jazz', '2024-11-12 21:30:00'),
('SP3', 'Concert Rock', 'Un show énergique de rock avec des artistes de renom.', 'rock.jpg', 'http://rock.com', 'Rock', '2024-12-01 20:00:00');

-- 4. Insertions dans la table USERS
INSERT INTO USERS (ID, email, passwd, nom, prenom, numeroTel, birthdate, eligible) VALUES
(gen_random_uuid(), 'user1@example.com', 'password123', 'Dupont', 'Jean', '0601020304', '1980-05-15', TRUE),
(gen_random_uuid(), 'user2@example.com', 'password123', 'Martin', 'Lucie', '0605060708', '1990-07-22', TRUE),
(gen_random_uuid(), 'user3@example.com', 'password123', 'Durand', 'Pierre', '0608091011', '1995-09-30', FALSE);

-- 5. Insertions dans la table BILLETS
INSERT INTO BILLETS (ID, ID_acheteur, Id_soiree, typeTarif, prix) VALUES
('B1', (SELECT ID FROM USERS WHERE email = 'user1@example.com'), 'S1', 'Normal', 20),
('B2', (SELECT ID FROM USERS WHERE email = 'user2@example.com'), 'S2', 'Réduit', 18),
('B3', (SELECT ID FROM USERS WHERE email = 'user3@example.com'), 'S3', 'Normal', 30);

-- 6. Insertions dans la table ARTISTES
INSERT INTO ARTISTES (ID_artiste, pseudonyme, nom, prenom) VALUES
('A1', 'Le Comique', 'Dumont', 'Arthur'),
('A2', 'JazzMan', 'Roche', 'Paul'),
('A3', 'RockStar', 'Mercier', 'David');

-- 7. Insertions dans la table ARTISTESPECTACLE
INSERT INTO ARTISTESPECTACLE (ID_artiste, ID_spectacle) VALUES
('A1', 'SP1'),
('A2', 'SP2'),
('A3', 'SP3');

-- 8. Insertions dans la table SPECTACLESOIREE
INSERT INTO SPECTACLESOIREE (ID_soiree, ID_spectacle) VALUES
('S1', 'SP1'),
('S2', 'SP2'),
('S3', 'SP3');
