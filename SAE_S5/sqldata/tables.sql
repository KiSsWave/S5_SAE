-- Supprimer les tables en commençant par celles qui dépendent d'autres
DROP TABLE IF EXISTS COMMANDES CASCADE;
DROP TABLE IF EXISTS PANIERS CASCADE;
DROP TABLE IF EXISTS SPECTACLESOIREE CASCADE;
DROP TABLE IF EXISTS ARTISTESPECTACLE CASCADE;
DROP TABLE IF EXISTS BILLETS CASCADE;
DROP TABLE IF EXISTS SOIREES CASCADE;
DROP TABLE IF EXISTS SPECTACLES CASCADE;
DROP TABLE IF EXISTS ARTISTES CASCADE;
DROP TABLE IF EXISTS USERS CASCADE;
DROP TABLE IF EXISTS LIEUX CASCADE;


-- 1. Table LIEUX doit être créée en premier, car elle est référencée par la table SOIREES.
create table LIEUX
(
    ID              varchar primary key,
    nom             varchar,
    adresse         varchar,
    nbPlacesAssises int,
    nbPlacesDebout  int,
    images          varchar
);

-- 2. Table SOIREES doit être créée après LIEUX, car elle fait référence à LIEUX.
create table SOIREES
(
    ID          varchar primary key,
    nom         varchar,
    thematique  varchar,
    dateSoiree  timestamptz,
    lieuSoiree  varchar,
    nbPlaces    int,
    tarif       float,
    tarifReduit float,
    foreign key (lieuSoiree) references LIEUX (ID)
);

-- 3. Table SPECTACLES ne dépend d'aucune autre table, elle peut être créée maintenant.
create table SPECTACLES
(
    ID          varchar primary key,
    titre       varchar,
    description varchar,
    images      varchar,
    urlVideo    varchar,
    style       varchar,
    horaire     timestamptz
);

-- 4. Table USERS peut être créée maintenant, elle ne dépend d'aucune autre table.
create table USERS
(
    ID        uuid primary key,
    email     varchar,
    passwd    varchar,
    nom       varchar,
    prenom    varchar,
    numeroTel varchar,
    birthdate date,
    eligible  boolean,
    role      int
);

-- 5. Table BILLETS fait référence à USERS, donc elle doit être créée après.
create table BILLETS
(
    ID                varchar primary key,
    ID_acheteur       uuid,
    nom_acheteur      varchar,
    reference         varchar,
    dateHoraireSoiree timestamptz,
    typeTarif         varchar,
    prix              float,
    foreign key (ID_acheteur) references USERS (ID),
    foreign key (reference) references SOIREES (ID)
);

-- 6. Table ARTISTES peut être créée, car elle ne dépend d'aucune autre table.
create table ARTISTES
(
    ID_artiste varchar primary key not null,
    pseudonyme varchar,
    nom        varchar,
    prenom     varchar
);

-- 7. Table ARTISTESPECTACLE doit être créée après ARTISTES et SPECTACLES, car elle fait référence à ces deux tables.
create table ARTISTESPECTACLE
(
    ID_artiste   varchar,
    ID_spectacle varchar,
    foreign key (ID_artiste) references ARTISTES (ID_artiste),
    foreign key (ID_spectacle) references SPECTACLES (ID),
    primary key (ID_artiste, ID_spectacle)
);

-- 8. Table SPECTACLESOIREE doit être créée en dernier car elle dépend de SOIREES et SPECTACLES.
create table SPECTACLESOIREE
(
    ID_soiree    varchar,
    ID_spectacle varchar,
    foreign key (ID_soiree) references SOIREES (ID),
    foreign key (ID_spectacle) references SPECTACLES (ID),
    primary key (ID_soiree, ID_spectacle)
);

CREATE TABLE PANIERS
(
    "idsoiree"  character varying(255) NOT NULL,
    "iduser"    uuid                   NOT NULL,
    "nbplaces"  integer                NOT NULL,
    "categorie" character varying(255) NOT NULL,
    "montant"   float              NOT NULL,
    foreign key (idsoiree) references soirees (id),
    foreign key (iduser) references users (id),
    primary key (idsoiree, iduser, categorie)
);

CREATE TABLE COMMANDES
(
    "iduser" uuid NOT NULL,
    "idsoiree" character varying NOT NULL,
    "date_achat" timestamp NOT NULL,
    "placesvendues" integer,
    CONSTRAINT "commandes_pkey" PRIMARY KEY ("iduser", "idsoiree", "date_achat")
)