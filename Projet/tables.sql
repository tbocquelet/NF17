BEGIN;

CREATE TABLE IntervenantExt(
	mail VARCHAR(50) PRIMARY KEY,
	nom VARCHAR(30) NOT NULL,
	prenom VARCHAR(30) NOT NULL,
	age NUMERIC(3)
);

CREATE TABLE Manager(
	mail VARCHAR(50) PRIMARY KEY,
	nom VARCHAR(30) NOT NULL,
	prenom VARCHAR(30) NOT NULL,
	age NUMERIC(3)
);

CREATE TABLE Coworker(
	mail VARCHAR(50) PRIMARY KEY,
	nom VARCHAR(30) NOT NULL,
	prenom VARCHAR(30) NOT NULL,
	age NUMERIC(3),
	presentation TEXT,
	situationProfessionnelle VARCHAR(30) NOT NULL
);

CREATE TABLE Espace(
	ID SERIAL PRIMARY KEY,
	adresse_rue VARCHAR(50) NOT NULL,
	adresse_codePostal INTEGER NOT NULL,
	adresse_ville VARCHAR(50) NOT NULL,
	adresse_pays VARCHAR(50) NOT NULL,
	surface INTEGER,
	nbBureaux INTEGER,
	nbSalles INTEGER,
	description TEXT,
	gerant VARCHAR(50) NOT NULL REFERENCES Manager(mail),
	active BOOL NOT NULL,
	UNIQUE(adresse_rue, adresse_codePostal, adresse_ville, adresse_pays)
);

CREATE TYPE enumSalle AS ENUM('indiv', 'collec');

CREATE TABLE Salle(
	numero INTEGER, --INTEGER et pas SERIAL car le manager choisit le num
	type enumSalle NOT NULL,
	espace INTEGER REFERENCES Espace(ID),
	nbPlaces INTEGER,
	PRIMARY KEY(numero, espace)
);

CREATE TYPE enumFormule AS ENUM('I','IBI','L');

CREATE TABLE Formule(
	nom VARCHAR(30),
	espace INTEGER REFERENCES Espace(ID),
	tarif INTEGER,
	limite INTEGER,
	type enumFormule,
	createur VARCHAR(50) NOT NULL REFERENCES Manager(mail),
	active BOOL NOT NULL,
	PRIMARY KEY(nom,espace)
);

CREATE TYPE enumMois AS ENUM('janvier','fevrier','mars','avril','mai','juin','juillet','aout','septembre','octobre','novembre','decembre');

CREATE TABLE Mois(
	mois enumMois,
	annee INTEGER,
	formule VARCHAR(30),
	espace INTEGER,
	active BOOL NOT NULL,
	PRIMARY KEY(mois, annee, formule, espace),
	FOREIGN KEY(formule, espace) REFERENCES Formule(nom, espace) 
);

CREATE TABLE Souscription(
	mois enumMois,
	annee INTEGER,
	formule VARCHAR(30) NOT NULL,
	espace INTEGER NOT NULL,
	coworker VARCHAR(50) REFERENCES Coworker(mail),
	PRIMARY KEY(mois, annee, coworker),  /* si on suppose qu’un coworker ne peut souscrire qu’à une seule formule pour un mois donné */
	FOREIGN KEY(mois, annee, formule, espace) REFERENCES Mois(mois, annee, formule, espace)
);


CREATE TABLE Conference(
	ID SERIAL PRIMARY KEY,
	titre VARCHAR(50),
	date TIMESTAMP,
	resume TEXT,
	intervenantExt VARCHAR(50) REFERENCES IntervenantExt(mail),
	intervenantCoworker VARCHAR(50) REFERENCES Coworker(mail),
	intervenantManager VARCHAR(50) REFERENCES Manager(mail),
	espaceProposant INTEGER REFERENCES Espace(ID),
	createur VARCHAR(50) NOT NULL REFERENCES Manager(mail)
);

CREATE TABLE Information(
	nom VARCHAR(30) PRIMARY KEY,
	date TIMESTAMP,
	contenu TEXT,
	confAnnoncee INTEGER REFERENCES Conference(ID),
	auteur VARCHAR(50) NOT NULL REFERENCES Manager(mail)
);

CREATE TABLE Publie(
	info VARCHAR(30) REFERENCES Information(nom),
	espace INTEGER REFERENCES Espace(ID),
	PRIMARY KEY(info,espace)
);

CREATE TABLE Ouverte(
	conference INTEGER REFERENCES Conference(ID),
	espace INTEGER REFERENCES Espace(ID),
	PRIMARY KEY(conference,espace)
);

CREATE TABLE Occupe(
	coworker VARCHAR(50) REFERENCES Coworker(mail),
	espace INTEGER,
	salle INTEGER,
	PRIMARY KEY (coworker,espace,salle),
	FOREIGN KEY(espace, salle) REFERENCES Salle(espace, numero)
);

CREATE TABLE Domaine(
	nom VARCHAR(30) PRIMARY KEY
);

CREATE TABLE Activite(
	domaine VARCHAR(30) REFERENCES Domaine(nom),
	coworker VARCHAR(50) REFERENCES Coworker(mail)
);

COMMIT;

