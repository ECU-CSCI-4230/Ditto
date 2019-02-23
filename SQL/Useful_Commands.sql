/*Deletes a User*/
delete From User Where User.User_ID = 1;
 
Select * from (select File_ID from User join fileShare on User.User_ID = FileShare.User_ID) as s;

/*Select the relvent user data*/
Select File_Path, File_Type, Last_Modified, Size from (select File_ID from User join fileShare on User.User_ID = FileShare.User_ID) as s join file on s.File_ID = File.File_ID;
