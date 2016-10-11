BEGIN;

CREATE OR REPLACE FUNCTION MoisToInt(m enumMois) RETURNS INTEGER AS $MoisToInt$
BEGIN
    CASE
        WHEN m = 'janvier' THEN
            RETURN 1;
        WHEN m = 'fevrier' THEN
            RETURN 2;
        WHEN m = 'mars' THEN
            RETURN 3;
        WHEN m = 'avril' THEN
            RETURN 4;
        WHEN m = 'mai' THEN
            RETURN 5;
        WHEN m = 'juin' THEN
            RETURN 6;
        WHEN m = 'juillet' THEN
            RETURN 7;
        WHEN m = 'aout' THEN
            RETURN 8;
        WHEN m = 'septembre' THEN
            RETURN 9;
        WHEN m = 'octobre' THEN
            RETURN 10;
        WHEN m = 'novembre' THEN
            RETURN 11;
        WHEN m = 'decembre' THEN
            RETURN 12;
    END CASE;
END;
$MoisToInt$ LANGUAGE plpgsql;

COMMIT;


