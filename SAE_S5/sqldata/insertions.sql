-- Insertion des utilisateurs
INSERT INTO USERS (ID, email, passwd, nom, prenom, birthdate, eligible) VALUES
('550e8400-e29b-41d4-a716-446655440000', 'alice@example.com', 'passwd123', 'Dupont', 'Alice', '1990-05-12', true),
('550e8400-e29b-41d4-a716-446655440001', 'bob@example.com', 'passwd456', 'Martin', 'Bob', '1985-11-20', false),
('550e8400-e29b-41d4-a716-446655440002', 'charlie@example.com', 'passwd789', 'Durand', 'Charlie', '1992-08-05', true);

-- Insertion des soirées
INSERT INTO SOIREES (ID, nom, thematique, dateSoiree, lieuSoiree, nbPlaces, tarif, tarifReduit) VALUES
('S001', 'Soirée Jazz', 'Jazz', '2024-12-05 20:00:00', 'Salle de Concert A', 100, 50.0, 30.0),
('S002', 'Soirée Rock', 'Rock', '2024-12-10 21:00:00', 'Club Rock B', 200, 60.0, 40.0),
('S003', 'Soirée Comédie', 'Comédie', '2024-12-15 19:00:00', 'Théâtre C', 150, 45.0, 25.0);

-- Insertion des spectacles
INSERT INTO SPECTACLES (ID, titre, description, images, urlVideo, style, horaire) VALUES
('SP001', 'Jazz en Seine', 'Un concert de jazz avec les meilleurs musiciens de la scène parisienne.', 'image1.jpg', 'https://www.youtube.com/watch?v=k9IDvub7yoQ', 'Jazz', '2024-12-05 20:30:00'),
('SP002', 'Rock Legends', 'Un hommage aux plus grandes légendes du rock.', 'image2.jpg', 'https://www.youtube.com/watch?v=OJrbUQB7jn4', 'Rock', '2024-12-10 21:30:00'),
('SP003', 'Stand-up Night', 'Les meilleurs comédiens stand-up pour une soirée de rires.', 'image3.jpg', 'https://www.youtube.com/watch?v=3tj7m7K9fis', 'Metal', '2024-12-15 19:30:00');

-- Insertion des relations entre soirées et spectacles
INSERT INTO SPECTACLESOIREE (ID_soiree, ID_spectacle) VALUES
('S001', 'SP001'),
('S002', 'SP002'),
('S003', 'SP003');

-- Insertion des lieux
INSERT INTO LIEUX (nom, adresse, nbPlacesAssises, nbPlacesDebout, images) VALUES
('Salle de Concert A', '12 rue de la Musique, Paris', 80, 20, 'salleA.jpg'),
('Club Rock B', '18 avenue du Rock, Lyon', 100, 100, 'clubB.jpg'),
('Théâtre C', '5 place du Théâtre, Marseille', 150, 0, 'theatreC.jpg');

-- Insertion des billets
INSERT INTO BILLETS (ID_acheteur, nomSoiree, typeTarif, prix) VALUES
('550e8400-e29b-41d4-a716-446655440000', 'Soirée Jazz', 'tarif plein', 50),
('550e8400-e29b-41d4-a716-446655440001', 'Soirée Rock', 'tarif réduit', 40),
('550e8400-e29b-41d4-a716-446655440002', 'Soirée Métal', 'tarif plein', 45);

-- Insertion des artistes
INSERT INTO ARTISTES (ID_artiste, pseudonyme, nom, prenom) VALUES
('A001', 'JazzMaster', 'Dupuis', 'Jean'),
('A002', 'RockKing', 'Legrand', 'Pierre'),
('A003', 'FunnyGuy', 'Lemoine', 'Jacques');

-- Insertion des relations entre artistes et spectacles
INSERT INTO ARTISTESPECTACLE (ID_artiste, ID_spectacle) VALUES
('A001', 'SP001'),
('A002', 'SP002'),
('A003', 'SP003');
