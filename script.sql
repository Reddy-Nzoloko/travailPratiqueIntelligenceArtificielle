CREATE DATABASE diagnosticIA;
create TABLE IF NOT EXISTS users(id int PRIMARY key, nom VARCHAR(250), emails VARCHAR(200) NOT NULL UNIQUE, passwod VARCHAR(250) NOT NULL);
create TABLE diagnostic(id int PRIMARY key, dates date, maladies VARCHAR(250), syntomes_cite VARCHAR(250), user_id int, FOREIGN KEY (user_id) REFERENCES users(id));