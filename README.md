# acrs-team
Hello and welcome to our Software Engineering: Process and Tools
Assignment - Part 1 - 

Group Members:
-----------------------------------------------------------------------
- Steven Korevaar	s3544280
- Asli Yoruk	s3503519
- Ryan Tran	s3201690
- Christine Huynh	s3438653

Tutor:
-----------------------------------------------------------------------
Lawrence Cavedon

Tutorial/Lab Day and time:
-----------------------------------------------------------------------
Tuesday 9:30am - 11:30am

Installation of web server stack
-----------------------------------------------------------------------
Document located in Part_A_submission\06-SEPT-PartA-UserDocumentation.pdf
under Installation and Setup Guide of XAMPP and Database.

Directory - Part_1_submission
-----------------------------------------------------------------------
Contains individual document files for Assignment part 1 submission.

Tools
-----------------------------------------------------------------------
Slack - 
https://acrs-team.slack.com/signup

Trello - 
https://trello.com/invite/b/5FdBGdSQ/c18e758d729f54f1895dac9b35b3a24b/acrs-team

GitHub - 
https://github.com/rmit-s3544280-steven-korevaar/acrs-team


XAMPP Component versions
-----------------------------------------------------------------------
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.1.1/xampp-portable-win32-7.1.1-0-VC14.zip/download
- PHP version: PHP 7.1.1
- Database version:	MariaDB 10.1.21
- MariaDB is compatible with MySQL version 5.6


	
How to host a local php and database server-
---------------------------------------------------------------------
1.	Get xampp, with php version: 7.1.1 and database version: 10.1.21
	The portable version is recommended as you do not need to install.
	link below for windows -
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.1.1/
	
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
	
4.	Run the sql script located inside the sqlScripts directory 
	Enter in command below-
	
	source <Full_File_Path>
	i.e.
	source C:\xampp\htdocs\Education\SEPTGitHub\sqlScripts\createTablesAndInsertDummyRecords.sql