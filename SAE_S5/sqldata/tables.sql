create table USERS(
	ID uuid primary key,
	email varchar,
	passwd varchar,
	nom varchar,
	prenom varchar,
	birthdate date,
	eligible boolean
);

create table SOIREES(
	ID SERIAL primary key
	nom varchar,
	thematique varchar,
	dateSoiree timestamptz,
	lieuSoiree varchar,
	nbPlaces int,
	tarif double,
	tarifReduit double
);

create table SPECTACLES(
	ID SERIAL primary key,
	titre varchar,
	description varchar,
	images varchar,
	urlVideo varchar,
	style varchar,
	horaire timestamptz
);

create table SPECTACLESOIREE(
	ID_soiree varchar,
	ID_spectacle varchar,
	foreign key(ID_soiree) references SOIREES(ID),
	foreign key(ID_spectacle) references SPECTACLES(ID),
	primay key(nomSoiree, titreSpectacle)
);

create table LIEUX(
	nom varchar primary key,
	adresse varchar,
	nbPlacesAssises int,
	nbPlacesDebout int,
	images varchar
);

create table BILLETS(
	ID_acheteur uuid,
	nomSoiree varchar,
	typeTarif varchar
	prix int
),

create table ARTISTES(
	ID_artiste SERIAL primary key not null
	pseudonyme varchar,
	nom varchar,
	prenom varchar
);

create table ARTISTESPECTACLE(
	ID_artiste int,
	ID_spectacle varchar,
	foreign key(ID_artiste) references ARTISTES(ID_artiste),
	foreign key(ID_spectacle) references SPECTACLES(ID),
	primary key(ID_artiste, ID_spectacle)
);