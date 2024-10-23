INSERT INTO LIEUX (ID, nom, adresse, nbPlacesAssises, nbPlacesDebout, images) VALUES
('L1', 'Le Zénith', 'Avenue du 7e Hussards, Nancy', 3000, 500, 'zenith.jpg'),
('L2', 'La Salle Poirel', '3 Rue de la Salle, Nancy', 800, 200, 'salle_poirel.jpg'),
('L3', 'Le Nouveau Relax', '9 Rue Saint-Georges, Nancy', 600, 100, 'nouveau_relax.jpg'),
('L4', 'La Maison de la Culture', '1 Rue des États-Unis, Nancy', 1200, 300, 'maison_culture.jpg');

INSERT INTO SOIREES (ID, nom, thematique, dateSoiree, lieuSoiree, nbPlaces, tarif, tarifReduit) VALUES
('S001', 'Soirée Rock Extravaganza', 'Concert', '2024-11-15 20:00:00+00', 'L1', 3500, 25.00, 15.00),
('S002', 'Festival Jazz & Blues', 'Festival', '2024-12-01 19:30:00+00', 'L2', 1000, 20.00, 12.00),
('S003', 'Classiques au Zénith', 'Concert', '2024-12-10 18:00:00+00', 'L1', 3000, 30.00, 18.00),
('S004', 'Soirée Musique du Monde', 'Concert', '2024-11-20 21:00:00+00', 'L3', 600, 15.00, 10.00),
('S005', 'Nuit de la Danse', 'Spectacle de Danse', '2024-11-25 20:00:00+00', 'L4', 1200, 22.00, 12.00),
('S006', 'Soirée Classique', 'Concert', '2024-12-15 19:00:00+00', 'L1', 400, 30.00, 18.00),
('S007', 'Éclats de Jazz', 'Concert', '2024-12-05 20:30:00+00', 'L2', 1000, 25.00, 15.00),
('S008', 'Fête de la Musique', 'Festival', '2024-12-20 17:00:00+00', 'L3', 600, 18.00, 10.00),
('S009', 'Nuit Opéra', 'Concert', '2024-12-30 19:00:00+00', 'L4', 800, 35.00, 20.00),
('S0010', 'Soirée de Réveillon', 'Événement Spécial', '2024-12-31 22:00:00+00', 'L1', 3500, 50.00, 30.00);

INSERT INTO SPECTACLES (ID, titre, description, images, urlVideo, style, horaire) VALUES
('SP1', 'Concert des Rolling Stones', 'Un concert inoubliable avec les plus grands hits.', 'rolling_stones.jpg', 'https://www.youtube.com/embed/kfORcR2VSbc?si=oKoDMGbkqVKa7fRA', 'Rock', '2024-11-15 21:00:00+00'),
('SP2', 'Soirée Jazz avec Duke Ellington', 'Une soirée pleine de mélodies jazzy.', 'duke_ellington.jpg', 'https://www.youtube.com/embed/cb2w2m1JmCY?si=x1Jl2j6Ie5HoPIVq', 'Jazz', '2024-12-01 20:00:00+00'),
('SP3', 'Symphonie n°5 de Beethoven', 'Une interprétation classique de l''œuvre de Beethoven.', 'beethoven.jpg', 'https://www.youtube.com/embed/-hO9iiy5zGQ?si=XddUCn6rx3-NoMIY', 'Classique', '2024-12-10 19:00:00+00'),
('SP4', 'Soirée Salsa', 'Plongée dans l’univers de la Salsa.', 'salsa.jpg', 'https://www.youtube.com/embed/hHspPE8Lz3M?si=ebuf4FSCACWs6Qsb', 'Salsa', '2024-11-20 21:30:00+00'),
('SP5', 'Danse Contemporaine', 'Spectacle de danse moderne et innovante.', 'danse_contemporaine.jpg', 'https://www.youtube.com/embed/GFbjAB9bwSc?si=jpg4hzaHT_NmGVxo', 'Danse', '2024-11-25 20:30:00+00'),
('SP6', 'Récital de Piano', 'Concert solo avec un pianiste renommé.', 'recital_piano.jpg', 'https://www.youtube.com/embed/atc19LIHxIE?si=uAPEXVqn9eSj61AV', 'Classique', '2024-12-15 18:30:00+00'),
('SP7', 'Jazz dans les Rues', 'Un concert en plein air avec des artistes locaux.', 'jazz_rues.jpg', 'https://www.youtube.com/embed/jft3BVoxqjo?si=ggeMaAGAhDye_EqE', 'Jazz', '2024-12-05 18:00:00+00'),
('SP8', 'Opéra : La Traviata', 'Interprétation de l’opéra classique.', 'traviata.jpg', 'https://www.youtube.com/embed/afhAqMeeQJk?si=4s7xs2qaNyTziXWz', 'Opéra', '2024-12-30 20:00:00+00'),
('SP9', 'Concert de Variété', 'Un mélange de pop et de rock.', 'variete.jpg', 'https://www.youtube.com/embed/Z8lUW9SKquY?si=rLjn36Bm0iY3Q_rQ', 'Variété', '2024-12-31 22:30:00+00'),
('SP10', 'Nuit d’Improvisation', 'Un spectacle d’improvisation théâtrale.', 'impro.jpg', 'https://www.youtube.com/embed/CUqyqqwKIfg?si=qs7JgpeCyBDlt2kz', 'Théâtre', '2024-12-31 23:00:00+00');

INSERT INTO USERS (ID, email, passwd, nom, prenom, numeroTel, birthdate, eligible, role) VALUES
('550e8400-e29b-41d4-a716-446655440000', 'user1@example.com', '$2y$10$eytz.9OZqI3m/YkxUYVJm.nOwVtT5RTOOZWG/NLamFHw6yoUuBo72', 'Dupont', 'Jean', '0612345678', '1990-05-15', TRUE, 1),
('550e8400-e29b-41d4-a716-446655440001', 'user2@example.com', '$2y$10$3Fi9g9d1lseYo3WwEjsDDuOcVOU7//8CsNclqPXIGiQgF8Veawi0a', 'Martin', 'Claire', '0623456789', '1985-03-25', TRUE, 2),
('550e8400-e29b-41d4-a716-446655440002', 'user3@example.com', '$2y$10$pDzD/s57igIQWuPdheuKiOXvNCN1F.K3QWZUAxqXqlcTWxEjDRqBG', 'Bernard', 'Pierre', '0634567890', '1992-08-30', TRUE, 3),
('550e8400-e29b-41d4-a716-446655440003', 'user4@example.com', '$2y$10$.gGXkLYyjVY69knAJAup1usB9BCVKfDNgkzrCEsl9KOpD7kdq387i', 'Durand', 'Marie', '0645678901', '1988-11-12', TRUE, 1),
('550e8400-e29b-41d4-a716-446655440004', 'user5@example.com', '$2y$10$pQ.sQ2n6UTKl22ZipZoxO.jX1nKO7fx/N8PoZPJD8Rwjx4ttTU.Ze', 'Leroy', 'Paul', '0656789012', '1995-06-21', TRUE, 2),
('550e8400-e29b-41d4-a716-446655440005', 'user6@example.com', '$2y$10$O4x0WE9R7aVr.UXrGDPFbuSUELrYyBekN9e8ErVwkVLzlVEPb2JFa', 'Roussel', 'Sophie', '0667890123', '1991-04-08', TRUE, 1),
('550e8400-e29b-41d4-a716-446655440006', 'user7@example.com', '$2y$10$JSPnEEuStdfUXo/CoEKw8O1O0Jauma1rTAqWqIyFIWaviMe1jnMxG', 'Pichon', 'Lucas', '0678901234', '1980-09-30', TRUE, 2),
('550e8400-e29b-41d4-a716-446655440007', 'user8@example.com', '$2y$10$sU3BnjGttKmXdmfgB85L6Oz0a1IIojM.czF3gc3Q3Wr/G3GgQtJcW', 'Bouvier', 'Emma', '0689012345', '1993-12-15', TRUE, 3),
('550e8400-e29b-41d4-a716-446655440008', 'user9@example.com', '$2y$10$nBwJHeTJ3GSJ3RkPp9JpEelhAWe2IJMf2EJqsnt./tSaAmtP9j0BK', 'Gauthier', 'Alice', '0690123456', '1987-02-14', TRUE, 1),
('550e8400-e29b-41d4-a716-446655440009', 'user10@example.com', '$2y$10$3KL5A7fqXmlAMdAWpEV04.ei7zuNrXoN3WqgJ5DfgzBB7AFPmUoxa', 'Moreau', 'Antoine', '0701234567', '1994-10-20', TRUE, 2);


INSERT INTO BILLETS (ID, ID_acheteur, nom_acheteur, reference, dateHoraireSoiree, typeTarif, prix) VALUES
('B1', '550e8400-e29b-41d4-a716-446655440000', 'Jean Dupont', 'S001', '2024-11-15 20:00:00+00','Standard', 25),
('B2', '550e8400-e29b-41d4-a716-446655440001', 'Claire Martin', 'S002', '2024-12-01 19:30:00+00','Réduit', 12),
('B3', '550e8400-e29b-41d4-a716-446655440002', 'Pierre Bernard', 'S003', '2024-12-10 18:00:00+00','Standard', 30),
('B4', '550e8400-e29b-41d4-a716-446655440003', 'Marie Durand', 'S001', '2024-11-15 20:00:00+00','Standard', 25),
('B5', '550e8400-e29b-41d4-a716-446655440004', 'Paul Leroy', 'S002', '2024-12-01 19:30:00+00','Réduit', 12),
('B6', '550e8400-e29b-41d4-a716-446655440005', 'Sophie Roussel', 'S004', '2024-11-20 21:00:00+00','Standard', 15),
('B7', '550e8400-e29b-41d4-a716-446655440006', 'Lucas Pichon', 'S005', '2024-11-25 20:00:00+00','Standard', 22),
('B8', '550e8400-e29b-41d4-a716-446655440007', 'Emma Bouvier', 'S003', '2024-12-10 18:00:00+00','Réduit', 18),
('B9', '550e8400-e29b-41d4-a716-446655440008', 'Alice Gauthier', 'S008', '2024-12-20 17:00:00+00','Standard', 35),
('B10', '550e8400-e29b-41d4-a716-446655440009', 'Antoine Moreau', 'S0010', '2024-12-31 22:00:00+00','Standard', 50);


INSERT INTO ARTISTES (ID_artiste, pseudonyme, nom, prenom) VALUES
('A1', '', 'Jagger', 'Mick'),
('A2', '', 'Ellington', 'Edward'),
('A3', '', 'van Beethoven', 'Ludwig'),
('A4', '', 'Dion', 'Céline'),
('A5', '', 'Mercury', 'Freddie'),
('A6', '', 'Krall', 'Diana'),
('A7', '', 'Ma', 'Yo-Yo'),
('A8', '', 'Gordon', 'Sting'),
('A9', '', 'Simone', 'Nina'),
('A10', '', 'Wolfgang', 'Mozart');

INSERT INTO ARTISTESPECTACLE (ID_artiste, ID_spectacle) VALUES
('A1', 'SP1'),
('A2', 'SP2'),
('A3', 'SP3'),
('A4', 'SP1'),
('A5', 'SP4'),
('A6', 'SP5'),
('A2', 'SP6'),
('A7', 'SP3'),
('A8', 'SP2'),
('A9', 'SP8'),
('A10', 'SP9');

INSERT INTO SPECTACLESOIREE (ID_soiree, ID_spectacle) VALUES
('S001', 'SP1'),
('S001', 'SP2'),
('S002', 'SP2'),
('S003', 'SP3'),
('S004', 'SP4'),
('S004', 'SP5'),
('S005', 'SP6'),
('S006', 'SP7'),
('S007', 'SP8'),
('S0010', 'SP9');
('S009', 'SP10');
