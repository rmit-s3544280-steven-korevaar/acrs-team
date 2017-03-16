/* Script used to initialise database for Software Engineering-
 * Process and Tools assignment part 1.
 *
 * Script will create the database and all the
 * necessary tables needed for the website to interface with
 * mariadb/mysql.
 */
 
/* Create database, used to store assignment tables */
create database if not exists SEPT_Assignment_Part_1;

/* Selecting the created database. */
use SEPT_Assignment_Part_1;

/* Create tables. */
create table business(
name text not null,
ownerName text not null,
address text not null,
phoneNo varchar(11) not null,
ABN varchar(11) primary key
);

create table employee(
employeeName text,
jobTitle text,
businessID varchar(11) not null,
employeeID varchar(3) primary key,
CONSTRAINT fk_employee_business
	foreign key (businessID) REFERENCES business (ABN)
	ON DELETE CASCADE
	ON UPDATE RESTRICT
);

/* Creating table to store the starting and ending work time
 * for an individual employee, the tricky part is when storing time,
 * it is easier to store it in minutes than in hours, as minutes
 * is easier to work with because you can always divide it by 60, to
 * get hours.
 *
 * This is why I am storing the time as an integer,
 * as 24 hours * 60 minutes = 1440 minutes, 4 characters.
 */
create table workPeriod(
workingDate date not null,
startTime integer(4) not null,
endTime integer(4) not null,
employeeID varchar(3) not null,
CONSTRAINT fk_workPeriod_employee
	foreign key (employeeID) REFERENCES employee (employeeID)
	ON DELETE CASCADE
	ON UPDATE RESTRICT
);

create table user(
username varchar(255) primary key,
fullname text,
address text,
phoneNo varchar(11),
password char(40) not null
);

create table booking(
bookingID integer not null auto_increment,
username varchar(255) not null,
bookingDate date not null,
startTime integer(4) not null,
endTime integer(4) not null,
businessID varchar(11) not null,
otherDetails text,
CONSTRAINT pk_booking PRIMARY KEY (bookingID,username),
CONSTRAINT fk_booking_business FOREIGN KEY (businessID)
REFERENCES business(ABN)
	ON DELETE CASCADE
	ON UPDATE RESTRICT
);

create table userBusiness(
username varchar(255) not null,
ABN varchar(11) not null,
CONSTRAINT pk_userBusiness PRIMARY KEY (username,ABN)
);
