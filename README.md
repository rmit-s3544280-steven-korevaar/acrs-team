# acrs-team
Hello and welcome to our SEPT group github repository

Our Members:
- Steven Korevaar   s3544280
- Asli Yoruk s3503519
- Ryan Tran s3201690
- Christine Huynh s3438653


--PHP version: PHP 5.6.30
--Database version:	MariaDB 10.1.21
	-MariaDB is compatible with MySQL version 5.6


	
How to host a local php and database server-
---------------------------------------------------------------------
1.	Get xampp, with php version: 5.6.30 and database version: 10.1.21
	The portable version is recommended as you do not need to install.
	link below for windows -
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/5.6.30/
	
2.	Extract the compressed file into the root directory of your 
partition.

3.	Locate xampp-control.exe and run it.

4.	Start Apache and MySQL.



Where to put the gitHub repository
---------------------------------------------------------------------
1.	Locate the 'htdocs' directory in xampp, usually found at the path
	below, if xampp was extracted into the root directory -
	/xampp/htdocs/

2.	Move/Copy the entire gitHub repository folder into the htdocs
	directory.
	

	
How to access the webpage
---------------------------------------------------------------------
1.	Open a browser of choice.

2.	In the URL go to -
http://localhost/'What_you_named_the_gitHub_repository_folder'/index.php



Create tables and insert dummy records into mysql
---------------------------------------------------------------------
1.	Locate the 'mysql.exe' executable in xampp, usually found at the 
	path below, if xampp was extracted into the root directory -
	/xampp/mysql/bin/
	
2.	Open a command line here and run the executable, with the 
	login option and "root" username.
	xammp by default does not have a password on the default mysql root
	user. 
	Enter in command below-
	
	mysql.exe -u root
	
4.	Run the sql scripts located inside the sqlScripts directory 
	there are the createTables.sql and insertDummyRecords.sql 
	scripts.
	Enter in command below-
	
	source <Full_File_Path>
	i.e.
	source C:\xampp\htdocs\Education\SEPTGitHub\sqlScripts\createTables.sql
	and 
	source C:\xampp\htdocs\Education\SEPTGitHub\sqlScripts\insertDummyRecords.sql