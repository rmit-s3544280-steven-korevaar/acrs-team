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
openingTime time,
closingTime time,
ABN varchar(11) primary key
);

create table businessActivity(
activityID integer not null auto_increment,
businessID varchar(11) not null,
activityName text not null,
duration time not null,
CONSTRAINT pk_businessActivity primary key (activityID),
CONSTRAINT fk_businessActivity_business
	foreign key (businessID) REFERENCES business (ABN)
	ON DELETE CASCADE
	ON UPDATE RESTRICT
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
workPeriodID integer not null auto_increment,
startDateTime datetime not null,
endDateTime datetime not null,
employeeID varchar(3) not null,
CONSTRAINT pk_workPeriod PRIMARY KEY (workPeriodID),
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

create table bookingActivity(
activityID integer not null,
bookingID integer not null,
CONSTRAINT bookingActivity PRIMARY KEY (activityID,bookingID)
);

create table bookingEmployee(
bookingID integer not null,
employeeID varchar(3) not null,
CONSTRAINT bookingEmployee PRIMARY KEY (bookingID,employeeID)
);

/* *********************************************************************
 * 
 * Insert dummy data into database;
 *
 ******************************************************************** */
/* Script used to insert dummy records for testing purposes.
 */
--Insert record into business: business-name, owner-name, address, ph-num, openingTime, closingTime, business-abn
insert into business values("The Dog Groomer","Chloe Jane Smith","98 Maine St VIC 3000","0398765432","09:00:00","18:00:00","56497978719");

--Insert record into businessActivity: activityID, businessID, activityName, duration
insert into businessActivity values(null,"56497978719","Clip","00:19:00");
insert into businessActivity values(null,"56497978719","Wash & Dry","00:29:00");
insert into businessActivity values(null,"56497978719","Style","00:09:00");

--Insert record into employee: (employee-name, job-title, business-abn, employee-id)
insert into employee values("Daniel Carter","Clipper, Washer & Stylist","56497978719","001");
insert into employee values("Esther King","Clipper, Washer & Stylist","56497978719","002");
insert into employee values("Fiona Woodley","Clipper & Washer","56497978719","003");

--Insert record into workPeriod: (null,start-time, end-time, employee-id)
insert into workPeriod values(null,"2017-04-24 09:00:00","2017-04-24 18:00:00","001"); --(emp-001, mon 24/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-25 09:00:00","2017-04-25 18:00:00","001"); --(emp-001, tue 25/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-26 09:00:00","2017-04-26 15:00:00","002"); --(emp-002, wed 26/04, 9am-3pm)
insert into workPeriod values(null,"2017-04-27 12:00:00","2017-04-27 18:00:00","002"); --(emp-002, thur 27/04, 12pm-6pm)
insert into workPeriod values(null,"2017-04-28 09:00:00","2017-04-28 18:00:00","001"); --(emp-001, fri 28/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-28 11:00:00","2017-04-28 15:00:00","002"); --(emp-002, fri 28/04, 11am-3pm)
insert into workPeriod values(null,"2017-04-28 11:00:00","2017-04-28 18:00:00","003"); --(emp-003, fri 28/04, 11am-6pm)

insert into workPeriod values(null,"2017-05-01 09:00:00","2017-05-01 18:00:00","001"); --(emp-001, mon 01/05, 9am-6pm)
insert into workPeriod values(null,"2017-05-02 09:00:00","2017-05-02 18:00:00","001"); --(emp-001, tue 02/05, 9am-6pm)
insert into workPeriod values(null,"2017-05-03 09:00:00","2017-05-03 18:00:00","002"); --(emp-002, wed 03/05, 9am-3pm)
insert into workPeriod values(null,"2017-05-04 09:00:00","2017-05-04 18:00:00","002"); --(emp-002, thur 04/05, 12pm-6pm)
insert into workPeriod values(null,"2017-05-05 09:00:00","2017-05-05 18:00:00","001"); --(emp-001, fri 05/05, 9am-6pm)
insert into workPeriod values(null,"2017-05-05 11:00:00","2017-05-05 15:00:00","002"); --(emp-002, fri 05/05, 11am-3pm)
insert into workPeriod values(null,"2017-05-05 11:00:00","2017-05-05 18:00:00","003"); --(emp-003, fri 05/05, 11am-6pm)

insert into workPeriod values(null,"2017-05-08 09:00:00","2017-05-08 18:00:00","001"); --(emp-001, mon 08/05, 9am-6pm)
insert into workPeriod values(null,"2017-05-09 09:00:00","2017-05-09 18:00:00","001"); --(emp-001, tue 09/05, 9am-6pm)
insert into workPeriod values(null,"2017-05-10 09:00:00","2017-05-10 18:00:00","002"); --(emp-002, wed 10/05, 9am-3pm)
insert into workPeriod values(null,"2017-05-11 09:00:00","2017-05-11 18:00:00","002"); --(emp-002, thur 11/05, 12pm-6pm)
insert into workPeriod values(null,"2017-05-12 09:00:00","2017-05-12 18:00:00","001"); --(emp-001, fri 12/05, 9am-6pm)
insert into workPeriod values(null,"2017-05-12 11:00:00","2017-05-12 15:00:00","002"); --(emp-002, fri 12/05, 11am-3pm)
insert into workPeriod values(null,"2017-05-12 11:00:00","2017-05-12 18:00:00","003"); --(emp-003, fri 12/05, 11am-6pm)

insert into workPeriod values(null,"2017-05-15 09:00:00","2017-05-15 18:00:00","001"); --(emp-001, mon 15/05, 9am-6pm)
insert into workPeriod values(null,"2017-05-16 09:00:00","2017-05-16 18:00:00","001"); --(emp-001, tue 16/05, 9am-6pm)
insert into workPeriod values(null,"2017-05-17 09:00:00","2017-05-17 18:00:00","002"); --(emp-002, wed 17/05, 9am-3pm)
insert into workPeriod values(null,"2017-05-18 09:00:00","2017-05-18 18:00:00","002"); --(emp-002, thur 18/05, 12pm-6pm)
insert into workPeriod values(null,"2017-05-19 09:00:00","2017-05-19 18:00:00","001"); --(emp-001, fri 19/05, 9am-6pm)
insert into workPeriod values(null,"2017-05-19 11:00:00","2017-05-19 15:00:00","002"); --(emp-002, fri 19/05, 11am-3pm)
insert into workPeriod values(null,"2017-05-19 11:00:00","2017-05-19 18:00:00","003"); --(emp-003, fri 19/05, 11am-6pm)

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

--Insert record into booking: (booking-id, username, start-time, end-time, business-id, details)

--Insert record into userBusiness: (username, business-abn)
insert into userBusiness values("admin","56497978719");

--Insert record into bookingActivity: (activityID, bookingID)

