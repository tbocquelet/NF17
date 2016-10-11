BEGIN;

CREATE OR REPLACE FUNCTION trigConf() RETURNS TRIGGER AS $trigConf$ 
BEGIN
        INSERT INTO Information VALUES('Annonce de la conférence n° '||NEW.ID, now(), NULL, NEW.ID, NEW.createur);
	INSERT INTO Ouverte VALUES(NEW.ID, NEW.espaceProposant);
        RETURN NEW;
END; 
$trigConf$ LANGUAGE plpgsql;

CREATE TRIGGER trigConf AFTER INSERT
	ON Conference
	FOR EACH ROW EXECUTE PROCEDURE trigConf();

CREATE OR REPLACE FUNCTION trigOuv() RETURNS TRIGGER AS $trigOuv$ 
BEGIN
        
        INSERT INTO Publie VALUES('Annonce de la conférence n° '||NEW.conference, NEW.espace);
        RETURN NEW;
END; 
$trigOuv$ LANGUAGE plpgsql;

CREATE TRIGGER trigOuv AFTER INSERT
	ON Ouverte
	FOR EACH ROW EXECUTE PROCEDURE trigOuv();

COMMIT;
