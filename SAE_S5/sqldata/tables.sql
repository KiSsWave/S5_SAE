create table USERS(
	ID uuid primary key,
	email varchar,
	passwd varchar,
	nom varchar,
	prenom varchar,
    numeroTel varchar,
	birthdate date,
	eligible boolean
);

create table SOIREES(
	ID varchar primary key,
	nom varchar,
	thematique varchar,
	dateSoiree timestamptz,
	lieuSoiree varchar,
	nbPlaces int,
	tarif float,
	tarifReduit float
);

create table SPECTACLES(
	ID varchar primary key,
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
	ID_artiste varchar primary key not null
	pseudonyme varchar,
	nom varchar,
	prenom varchar
);

create table ARTISTESPECTACLE(
	ID_artiste varchar,
	ID_spectacle varchar,
	foreign key(ID_artiste) references ARTISTES(ID_artiste),
	foreign key(ID_spectacle) references SPECTACLES(ID),
	primary key(ID_artiste, ID_spectacle)
);