CREATE TABLE adminusers(
	AdminID int not null AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL,
	password VARCHAR(15) NOT NULL,
    Lastlogin DATE,
	PRIMARY KEY (AdminID)
	);

INSERT INTO adminusers (username,password)
   VALUES ('admin','passme');