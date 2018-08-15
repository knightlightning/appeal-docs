CREATE DATABASE appealstat;

USE appealstat;

CREATE TABLE courts (
    ID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE uploads (
    ID INT NOT NULL AUTO_INCREMENT,
    upload_date DATE NOT NULL,
    court_id INT NOT NULL,
    court_type ENUM('criminal','civil') NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (court_id) REFERENCES courts(ID)
);

CREATE TABLE files (
    ID INT NOT NULL AUTO_INCREMENT,
    upload_id INT NOT NULL,
    name VARCHAR(255) CHARACTER SET utf8 NOT NULL,
    upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID)
);

INSERT INTO courts(name) VALUES('Большеуковский районный суд');
INSERT INTO courts(name) VALUES('Большереченский районный суд');
INSERT INTO courts(name) VALUES('Знаменский районный суд');
INSERT INTO courts(name) VALUES('Калачинский городской суд');
INSERT INTO courts(name) VALUES('Азовский районный суд');
INSERT INTO courts(name) VALUES('Исилькульский городской суд');
INSERT INTO courts(name) VALUES('Горьковский районный суд');
INSERT INTO courts(name) VALUES('Кировский районный суд');
INSERT INTO courts(name) VALUES('Кормиловский районный суд');
INSERT INTO courts(name) VALUES('Колосовский районный суд');
INSERT INTO courts(name) VALUES('Куйбышевский районный суд');
INSERT INTO courts(name) VALUES('Крутинский районный суд');
INSERT INTO courts(name) VALUES('Ленинский районный суд');
INSERT INTO courts(name) VALUES('Любинский районный суд');
INSERT INTO courts(name) VALUES('Марьяновский районный суд');
INSERT INTO courts(name) VALUES('Муромцевский районный суд');
INSERT INTO courts(name) VALUES('Называевский городской суд');
INSERT INTO courts(name) VALUES('Нижнеомский районный суд');
INSERT INTO courts(name) VALUES('Москаленский районный суд');
INSERT INTO courts(name) VALUES('Нововаршавский районный суд');
INSERT INTO courts(name) VALUES('Оконешниковский районный суд');
INSERT INTO courts(name) VALUES('Омский районный суд');
INSERT INTO courts(name) VALUES('Одесский районный суд');
INSERT INTO courts(name) VALUES('Павлоградский районный суд');
INSERT INTO courts(name) VALUES('Октябрьский районный суд');
INSERT INTO courts(name) VALUES('Русско-Полянский районный суд');
INSERT INTO courts(name) VALUES('Первомайский районный суд');
INSERT INTO courts(name) VALUES('Полтавский районный суд');
INSERT INTO courts(name) VALUES('Саргатский районный суд');
INSERT INTO courts(name) VALUES('Седельниковский районный суд');
INSERT INTO courts(name) VALUES('Усть-Ишимский районный суд');
INSERT INTO courts(name) VALUES('Таврический районный суд');
INSERT INTO courts(name) VALUES('Советский районный суд');
INSERT INTO courts(name) VALUES('Тюкалинский городской суд');
INSERT INTO courts(name) VALUES('Тарский городской суд');
INSERT INTO courts(name) VALUES('Тевризский районный суд');
INSERT INTO courts(name) VALUES('Черлакский районный суд');
INSERT INTO courts(name) VALUES('Центральный районный суд');
INSERT INTO courts(name) VALUES('Шербакульский районный суд');
