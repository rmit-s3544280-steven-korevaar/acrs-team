/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *				Christine Huynh	s3438653
 *
 * Script used to initialise database for Software Engineering-
 * Process and Tools assignment part 1.
 *
 * Script will create the database and all the
 * necessary tables needed for the website to interface with
 * mariadb/mysql.
 *
 * Second part is to insert Dummy records for testing and allow 
 * the presentation of the website with relevant data. 
 *
 * Dummy bookings and employee work hours are only up to 28/04/2017.
 ********************************************************************/
 
/* Create database, used to store assignment tables */
drop database if exists SEPT_Assignment_Part_1;
create database SEPT_Assignment_Part_1;

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


create table workPeriod(
startDateTime datetime not null,
endDateTime datetime not null,
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
employee varchar(255) not null,
startDateTime datetime not null,
endDateTime datetime not null,
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


/* *********************************************************************
 * 
 * Insert dummy data into database;
 *
 ******************************************************************** */
/* Script used to insert dummy records for testing purposes.
 */
--Insert record into business: business-name, owner-name, address, ph-num, business-abn
insert into business values("The Dog Groomer","Chloe Jane Smith","98 Maine St VIC 3000","0398765432","56497978719");

--Insert record into employee: (employee-name, job-title, business-abn, employee-id)
insert into employee values("Daniel Carter","Clipper, Washer & Stylist","56497978719","001");
insert into employee values("Esther King","Clipper, Washer & Stylist","56497978719","002");
insert into employee values("Fiona Woodley","Clipper & Washer","56497978719","003");

--Insert record into workPeriod: (start-time, end-time, employee-id)
insert into workPeriod values("2017-03-20 09:00:00","2017-03-20 18:00:00","001"); --(emp-001, mon 20/03, 9am-6pm)
insert into workPeriod values("2017-03-21 09:00:00","2017-03-21 18:00:00","001"); --(emp-001, tue 21/03, 9am-6pm)
insert into workPeriod values("2017-03-22 09:00:00","2017-03-22 18:00:00","002"); --(emp-002, wed 22/03, 9am-6pm)
insert into workPeriod values("2017-03-23 09:00:00","2017-03-23 18:00:00","002"); --(emp-002, thur 23/03, 9am-6pm)
insert into workPeriod values("2017-03-24 09:00:00","2017-03-24 18:00:00","001"); --(emp-001, fri 24/03, 9am-6pm)
insert into workPeriod values("2017-03-24 09:00:00","2017-03-24 18:00:00","002"); --(emp-002, fri 24/03, 9am-6pm)
insert into workPeriod values("2017-03-25 09:00:00","2017-03-25 18:00:00","001"); --(emp-001, sat 20/03, 9am-6pm)
insert into workPeriod values("2017-03-25 09:00:00","2017-03-25 18:00:00","002"); --(emp-002, sat 25/03, 9am-6pm)
insert into workPeriod values("2017-03-25 09:00:00","2017-03-25 18:00:00","003"); --(emp-003, sat 25/03 9am-6pm)
insert into workPeriod values("2017-03-26 09:00:00","2017-03-26 18:00:00","001"); --(emp-001, sun 26/03, 9am-6pm)
insert into workPeriod values("2017-03-26 09:00:00","2017-03-26 18:00:00","002"); --(emp-002, sun 26/03, 9am-6pm)
insert into workPeriod values("2017-03-26 09:00:00","2017-03-26 18:00:00","003"); --(emp-003, sun 26/03, 9am-6pm)
--
insert into workPeriod values("2017-03-27 09:00:00","2017-03-27 18:00:00","001"); --(emp-001, mon 27/03, 9am-6pm)
insert into workPeriod values("2017-03-28 09:00:00","2017-03-28 18:00:00","001"); --(emp-001, tue 28/03, 9am-6pm)
insert into workPeriod values("2017-03-29 09:00:00","2017-03-29 18:00:00","002"); --(emp-002, wed 29/03, 9am-6pm)
insert into workPeriod values("2017-03-30 09:00:00","2017-03-30 18:00:00","002"); --(emp-002, thur 30/03, 9am-6pm)
insert into workPeriod values("2017-03-31 09:00:00","2017-03-31 18:00:00","001"); --(emp-001, fri 31/03, 9am-6pm)
insert into workPeriod values("2017-03-31 09:00:00","2017-03-31 18:00:00","002"); --(emp-002, fri 31/03, 9am-6pm)
insert into workPeriod values("2017-04-01 09:00:00","2017-04-01 18:00:00","001"); --(emp-001, sat 01/04, 9am-6pm)
insert into workPeriod values("2017-04-01 09:00:00","2017-04-01 18:00:00","002"); --(emp-002, sat 01/04, 9am-6pm)
insert into workPeriod values("2017-04-01 09:00:00","2017-04-01 18:00:00","003"); --(emp-003, sat 01/04 9am-6pm)
insert into workPeriod values("2017-04-02 09:00:00","2017-04-02 18:00:00","001"); --(emp-001, sun 02/04, 9am-6pm)
insert into workPeriod values("2017-04-02 09:00:00","2017-04-02 18:00:00","002"); --(emp-002, sun 02/04, 9am-6pm)
insert into workPeriod values("2017-04-02 09:00:00","2017-04-02 18:00:00","003"); --(emp-003, sun 02/04, 9am-6pm)
--
insert into workPeriod values("2017-04-03 09:00:00","2017-04-03 18:00:00","001"); --(emp-001, mon 03/04, 9am-6pm)
insert into workPeriod values("2017-04-04 09:00:00","2017-04-04 18:00:00","001"); --(emp-001, tue 04/04, 9am-6pm)
insert into workPeriod values("2017-04-05 09:00:00","2017-04-05 18:00:00","002"); --(emp-002, wed 05/04, 9am-6pm)
insert into workPeriod values("2017-04-06 09:00:00","2017-04-06 18:00:00","002"); --(emp-002, thur 06/04, 9am-6pm)
insert into workPeriod values("2017-04-07 09:00:00","2017-04-07 18:00:00","001"); --(emp-001, fri 07/04, 9am-6pm)
insert into workPeriod values("2017-04-07 09:00:00","2017-04-07 18:00:00","002"); --(emp-002, fri 07/04, 9am-6pm)
insert into workPeriod values("2017-04-08 09:00:00","2017-04-08 18:00:00","001"); --(emp-001, sat 08/04, 9am-6pm)
insert into workPeriod values("2017-04-08 09:00:00","2017-04-08 18:00:00","002"); --(emp-002, sat 08/04, 9am-6pm)
insert into workPeriod values("2017-04-08 09:00:00","2017-04-08 18:00:00","003"); --(emp-003, sat 08/04 9am-6pm)
insert into workPeriod values("2017-04-09 09:00:00","2017-04-09 18:00:00","001"); --(emp-001, sun 09/04, 9am-6pm)
insert into workPeriod values("2017-04-09 09:00:00","2017-04-09 18:00:00","002"); --(emp-002, sun 09/04, 9am-6pm)
insert into workPeriod values("2017-04-09 09:00:00","2017-04-09 18:00:00","003"); --(emp-003, sun 09/04, 9am-6pm)

insert into workPeriod values("2017-04-10 09:00:00","2017-04-10 18:00:00","001"); --(emp-001, mon 10/04, 9am-6pm)
insert into workPeriod values("2017-04-11 09:00:00","2017-04-11 18:00:00","001"); --(emp-001, tue 11/04, 9am-6pm)
insert into workPeriod values("2017-04-12 09:00:00","2017-04-12 15:00:00","002"); --(emp-002, wed 12/04, 9am-3pm)
insert into workPeriod values("2017-04-13 12:00:00","2017-04-13 18:00:00","002"); --(emp-002, thur 13/04, 12pm-6pm)
insert into workPeriod values("2017-04-14 09:00:00","2017-04-14 18:00:00","001"); --(emp-001, fri 14/04, 9am-6pm)
insert into workPeriod values("2017-04-14 11:00:00","2017-04-14 15:00:00","002"); --(emp-002, fri 14/04, 11am-3pm)
insert into workPeriod values("2017-04-14 11:00:00","2017-04-14 18:00:00","003"); --(emp-003, fri 14/04, 11am-6pm)

insert into workPeriod values("2017-04-17 09:00:00","2017-04-17 18:00:00","001"); --(emp-001, mon 17/04, 9am-6pm)
insert into workPeriod values("2017-04-18 09:00:00","2017-04-18 18:00:00","001"); --(emp-001, tue 18/04, 9am-6pm)
insert into workPeriod values("2017-04-19 09:00:00","2017-04-19 15:00:00","002"); --(emp-002, wed 19/04, 9am-3pm)
insert into workPeriod values("2017-04-20 12:00:00","2017-04-20 18:00:00","002"); --(emp-002, thur 20/04, 12pm-6pm)
insert into workPeriod values("2017-04-21 09:00:00","2017-04-21 18:00:00","001"); --(emp-001, fri 21/04, 9am-6pm)
insert into workPeriod values("2017-04-21 11:00:00","2017-04-21 15:00:00","002"); --(emp-002, fri 21/04, 11am-3pm)
insert into workPeriod values("2017-04-21 11:00:00","2017-04-21 18:00:00","003"); --(emp-003, fri 14/04, 11am-6pm)

insert into workPeriod values("2017-04-24 09:00:00","2017-04-24 18:00:00","001"); --(emp-001, mon 24/04, 9am-6pm)
insert into workPeriod values("2017-04-25 09:00:00","2017-04-25 18:00:00","001"); --(emp-001, tue 25/04, 9am-6pm)
insert into workPeriod values("2017-04-26 09:00:00","2017-04-26 15:00:00","002"); --(emp-002, wed 26/04, 9am-3pm)
insert into workPeriod values("2017-04-27 12:00:00","2017-04-27 18:00:00","002"); --(emp-002, thur 27/04, 12pm-6pm)
insert into workPeriod values("2017-04-28 09:00:00","2017-04-28 18:00:00","001"); --(emp-001, fri 28/04, 9am-6pm)
insert into workPeriod values("2017-04-28 11:00:00","2017-04-28 15:00:00","002"); --(emp-002, fri 28/04, 11am-3pm)
insert into workPeriod values("2017-04-28 11:00:00","2017-04-28 18:00:00","003"); --(emp-003, fri 28/04, 11am-6pm)

--Insert record into user: (username, full-name, address, ph-num, password)
--Business Owner
insert into user values("admin","Chloe Jane Smith","98 Maine St, Victora 3000","0398765432",SHA("admin"));

--Customer: (username, full-name, address, ph-number, password)
--DELETE FROM customer WHERE username like lower('dummy%');

insert into user values("customer","Alica Michaels","2 Portia St, VIC 3652","0398765431",SHA("customer"));
insert into user values("customer2","Bernard Campbell","14 Wattson Rd, VIC 3190","0398765432",SHA("customer2"));
insert into user values("customer3","Chris Hunter","8 Harrison Crt, VIC 3061","0398765433",SHA("customer3"));
insert into user values("customer4","Gary Peterson","11 Bosley St, VIC 3231","0398765433",SHA("customer4"));
insert into user values("customer5","Horton Andersen","16 Leeroy Rd, VIC 3458","0398765433",SHA("customer5"));
insert into user values("customer6","Isabelle Barkley","12 Jones Crt, VIC 3902","0398765433",SHA("customer6"));

--Insert record into userBusiness: (username, business-abn)
insert into userBusiness values("admin","56497978719");

