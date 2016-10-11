BEGIN;

CREATE OR REPLACE VIEW vSalleIndiv
AS
	SELECT * FROM Salle WHERE type='indiv';

CREATE OR REPLACE VIEW vSalleCollec 
AS 
	SELECT * FROM Salle WHERE type='collec';

CREATE OR REPLACE VIEW vFormuleIllimite
AS 
	SELECT * FROM Formule WHERE type='I';

CREATE OR REPLACE VIEW vFormuleIllimiteBureau
AS 
	SELECT * FROM Formule WHERE type='IBI';

CREATE OR REPLACE VIEW vFormuleLimite
AS 
	SELECT * FROM Formule WHERE type='L';

COMMIT;
