drop table FileShare;
drop table User;
drop table File;

CREATE TABLE User (
    User_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(18) NOT NULL,
    Password VARCHAR(32) NOT NULL,
    Email VARCHAR(50)
);

CREATE TABLE File (
    File_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    File_Path VARCHAR(100) NOT NULL,
    File_Type VARCHAR(6) NOT NULL,
    Last_Modified DATE NOT NULL,
    Size INT(32) NOT NULL
);

CREATE TABLE FileShare (
    User_ID INT(8) UNSIGNED NOT NULL,
    File_ID INT(8) UNSIGNED NOT NULL,
    Permission TINYINT NOT NULL,
    
    PRIMARY KEY (User_ID , File_ID),
    
    FOREIGN KEY (User_ID)
        REFERENCES User (User_ID)
        ON DELETE CASCADE,
    FOREIGN KEY (File_ID)
        REFERENCES FIle (File_ID)
        ON DELETE CASCADE
);

describe User;
describe File;
describe FileShare;

show tables;