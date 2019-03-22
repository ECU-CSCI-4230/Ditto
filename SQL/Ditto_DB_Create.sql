create database Ditto_Drive;

use ditto_drive;

CREATE TABLE User (
    User_ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(18) NOT NULL,
    Password VARCHAR(32) NOT NULL,
    Email VARCHAR(50)
);

CREATE TABLE File (
    File_ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    File_Path VARCHAR(100) NOT NULL,
    File_Type VARCHAR(32) NOT NULL,
    Last_Modified DATE NOT NULL,
    File_Size INT(32) NOT NULL
);

CREATE TABLE FileShare (
    User_ID INT(10) UNSIGNED NOT NULL,
    File_ID INT(10) UNSIGNED NOT NULL,
    Permission TINYINT NOT NULL,
    PRIMARY KEY (User_ID , File_ID),
    FOREIGN KEY (User_ID)
        REFERENCES User (User_ID)
        ON DELETE CASCADE,
    FOREIGN KEY (File_ID)
        REFERENCES File (File_ID)
        ON DELETE CASCADE
);

describe User;
describe File;
describe FileShare;

show tables;
SHOW CREATE TABLE FileShare;
