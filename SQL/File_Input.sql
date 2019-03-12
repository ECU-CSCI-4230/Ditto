Insert Into File (File_Path, File_Type, Last_Modified, Size)
Values ("p1","t1",Now(), 0), 
("p2","t2",Now(), 1),
("p3","t3",Now(), 22);

SELECT 
    *
FROM
    File