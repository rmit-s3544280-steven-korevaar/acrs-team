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


/* *********************************************************************
 * 
 * Insert dummy data into database;
 *
 ******************************************************************** */
/* Script used to insert dummy records for testing purposes.
 */
--Insert record into business: business-name, owner-name, address, ph-num, openingTime, closingTime, business-abn
insert into business values("The Dog Groomer","Chloe Jane Smith","98 Maine St VIC 3000","0398765432","09:00:00","18:00:00","56497978719");

--Insert record into businessActivity: business-name, owner-name, address, ph-num, openingTime, closingTime, business-abn
insert into businessActivity values(null,"56497978719","Cut","00:20:00");
insert into businessActivity values(null,"56497978719","Wash","00:10:00");

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
insert into booking values(null,"customer3","2017-04-17 09:00:00","2017-04-17 10:00:00","56497978719","Wash & Dry"); --(cust3, mon 04/17)
insert into booking values(null,"customer4","2017-04-17 11:00:00","2017-04-17 12:00:00","56497978719","Clip, Wash & Dry"); --(cust4, mon 04/17)
insert into booking values(null,"customer5","2017-04-18 11:30:00","2017-04-18 12:30:00","56497978719","Clip & Style"); --(cust5, tue 04/18)
insert into booking values(null,"customer2","2017-04-19 13:00:00","2017-04-19 14:00:00","56497978719","Clip, Wash & Dry"); --(cust2, wed 04/19)
insert into booking values(null,"customer6","2017-04-21 10:45:00","2017-04-21 11:45:00","56497978719","Wash & Dry"); --(cust6, fri 04/21)
insert into booking values(null,"customer","2017-04-21 13:30:00","2017-04-21 14:30:00","56497978719","Clip"); --(cust, fri 04/21)

insert into booking values(null,"customer3","2017-04-24 09:00:00","2017-04-24 10:00:00","56497978719","Wash & Dry"); --(cust3, mon 04/24)
insert into booking values(null,"customer4","2017-04-24 11:00:00","2017-04-24 12:00:00","56497978719","Clip, Wash & Dry"); --(cust4, mon 04/24)
insert into booking values(null,"customer5","2017-04-25 11:30:00","2017-04-25 12:30:00","56497978719","Clip & Style"); --(cust5, tue 04/25)
insert into booking values(null,"customer2","2017-04-26 13:00:00","2017-04-26 14:00:00","56497978719","Clip, Wash & Dry"); --(cust2, wed 04/26)
insert into booking values(null,"customer6","2017-04-28 10:45:00","2017-04-28 11:45:00","56497978719","Wash & Dry"); --(cust6, fri 04/28)
insert into booking values(null,"customer","2017-04-28 13:30:00","2017-04-28 14:30:00","56497978719","Clip"); --(cust, fri 04/28)

--Insert record into userBusiness: (username, business-abn)
insert into userBusiness values("admin","56497978719");

