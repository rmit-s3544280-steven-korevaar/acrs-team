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
insert into workPeriod values(null,"2017-03-20 09:00:00","2017-03-20 18:00:00","001"); --(emp-001, mon 20/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-21 09:00:00","2017-03-21 18:00:00","001"); --(emp-001, tue 21/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-22 09:00:00","2017-03-22 18:00:00","002"); --(emp-002, wed 22/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-23 09:00:00","2017-03-23 18:00:00","002"); --(emp-002, thur 23/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-24 09:00:00","2017-03-24 18:00:00","001"); --(emp-001, fri 24/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-24 09:00:00","2017-03-24 18:00:00","002"); --(emp-002, fri 24/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-25 09:00:00","2017-03-25 18:00:00","001"); --(emp-001, sat 20/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-25 09:00:00","2017-03-25 18:00:00","002"); --(emp-002, sat 25/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-25 09:00:00","2017-03-25 18:00:00","003"); --(emp-003, sat 25/03 9am-6pm)
insert into workPeriod values(null,"2017-03-26 09:00:00","2017-03-26 18:00:00","001"); --(emp-001, sun 26/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-26 09:00:00","2017-03-26 18:00:00","002"); --(emp-002, sun 26/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-26 09:00:00","2017-03-26 18:00:00","003"); --(emp-003, sun 26/03, 9am-6pm)
--
insert into workPeriod values(null,"2017-03-27 09:00:00","2017-03-27 18:00:00","001"); --(emp-001, mon 27/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-28 09:00:00","2017-03-28 18:00:00","001"); --(emp-001, tue 28/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-29 09:00:00","2017-03-29 18:00:00","002"); --(emp-002, wed 29/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-30 09:00:00","2017-03-30 18:00:00","002"); --(emp-002, thur 30/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-31 09:00:00","2017-03-31 18:00:00","001"); --(emp-001, fri 31/03, 9am-6pm)
insert into workPeriod values(null,"2017-03-31 09:00:00","2017-03-31 18:00:00","002"); --(emp-002, fri 31/03, 9am-6pm)
insert into workPeriod values(null,"2017-04-01 09:00:00","2017-04-01 18:00:00","001"); --(emp-001, sat 01/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-01 09:00:00","2017-04-01 18:00:00","002"); --(emp-002, sat 01/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-01 09:00:00","2017-04-01 18:00:00","003"); --(emp-003, sat 01/04 9am-6pm)
insert into workPeriod values(null,"2017-04-02 09:00:00","2017-04-02 18:00:00","001"); --(emp-001, sun 02/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-02 09:00:00","2017-04-02 18:00:00","002"); --(emp-002, sun 02/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-02 09:00:00","2017-04-02 18:00:00","003"); --(emp-003, sun 02/04, 9am-6pm)
--
insert into workPeriod values(null,"2017-04-03 09:00:00","2017-04-03 18:00:00","001"); --(emp-001, mon 03/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-04 09:00:00","2017-04-04 18:00:00","001"); --(emp-001, tue 04/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-05 09:00:00","2017-04-05 18:00:00","002"); --(emp-002, wed 05/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-06 09:00:00","2017-04-06 18:00:00","002"); --(emp-002, thur 06/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-07 09:00:00","2017-04-07 18:00:00","001"); --(emp-001, fri 07/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-07 09:00:00","2017-04-07 18:00:00","002"); --(emp-002, fri 07/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-08 09:00:00","2017-04-08 18:00:00","001"); --(emp-001, sat 08/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-08 09:00:00","2017-04-08 18:00:00","002"); --(emp-002, sat 08/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-08 09:00:00","2017-04-08 18:00:00","003"); --(emp-003, sat 08/04 9am-6pm)
insert into workPeriod values(null,"2017-04-09 09:00:00","2017-04-09 18:00:00","001"); --(emp-001, sun 09/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-09 09:00:00","2017-04-09 18:00:00","002"); --(emp-002, sun 09/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-09 09:00:00","2017-04-09 18:00:00","003"); --(emp-003, sun 09/04, 9am-6pm)

insert into workPeriod values(null,"2017-04-10 09:00:00","2017-04-10 18:00:00","001"); --(emp-001, mon 10/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-11 09:00:00","2017-04-11 18:00:00","001"); --(emp-001, tue 11/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-12 09:00:00","2017-04-12 15:00:00","002"); --(emp-002, wed 12/04, 9am-3pm)
insert into workPeriod values(null,"2017-04-13 12:00:00","2017-04-13 18:00:00","002"); --(emp-002, thur 13/04, 12pm-6pm)
insert into workPeriod values(null,"2017-04-14 09:00:00","2017-04-14 18:00:00","001"); --(emp-001, fri 14/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-14 11:00:00","2017-04-14 15:00:00","002"); --(emp-002, fri 14/04, 11am-3pm)
insert into workPeriod values(null,"2017-04-14 11:00:00","2017-04-14 18:00:00","003"); --(emp-003, fri 14/04, 11am-6pm)

insert into workPeriod values(null,"2017-04-17 09:00:00","2017-04-17 18:00:00","001"); --(emp-001, mon 17/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-18 09:00:00","2017-04-18 18:00:00","001"); --(emp-001, tue 18/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-19 09:00:00","2017-04-19 15:00:00","002"); --(emp-002, wed 19/04, 9am-3pm)
insert into workPeriod values(null,"2017-04-20 12:00:00","2017-04-20 18:00:00","002"); --(emp-002, thur 20/04, 12pm-6pm)
insert into workPeriod values(null,"2017-04-21 09:00:00","2017-04-21 18:00:00","001"); --(emp-001, fri 21/04, 9am-6pm)
insert into workPeriod values(null,"2017-04-21 11:00:00","2017-04-21 15:00:00","002"); --(emp-002, fri 21/04, 11am-3pm)
insert into workPeriod values(null,"2017-04-21 11:00:00","2017-04-21 18:00:00","003"); --(emp-003, fri 14/04, 11am-6pm)

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
insert into booking values(null,"customer2","2017-03-20 09:30:00","2017-03-20 10:00:00","56497978719","Clip"); --(cust2, mon 03/20)
insert into booking values(null,"customer","2017-03-20 12:30:00","2017-03-20 13:30:00","56497978719","Clip, Wash & Dry"); --(cust, mon 03/20)
insert into booking values(null,"customer4","2017-03-20 16:45:00","2017-03-20 17:30:00","56497978719","Wash & Dry"); --(cust4, mon 03/20)

insert into booking values(null,"customer5","2017-03-21 10:30:00","2017-03-21 11:45:00","56497978719","Clip & Style"); --(cust5, tue 03/21)
insert into booking values(null,"customer6","2017-03-21 13:00:00","2017-03-21 13:45:00","56497978719","Wash & Dry"); --(cust2, tue 03/21)
insert into booking values(null,"customer3","2017-03-21 14:15:00","2017-03-21 16:00:00","56497978719","Clip, Wash & Dry"); --(cust3, tue 03/21)

insert into booking values(null,"customer6","2017-03-22 11:30:00","2017-03-22 14:15:00","56497978719","Wash & Dry"); --(cust6, wed 03/22)
insert into booking values(null,"customer3","2017-03-22 15:30:00","2017-03-22 16:15:00","56497978719","Wash & Dry"); --(cust3, wed 03/22)
insert into booking values(null,"customer5","2017-03-22 15:00:00","2017-03-22 15:45:00","56497978719","Clip & Style"); --(cust5, wed 03/22)
insert into booking values(null,"customer","2017-03-22 15:45:00","2017-03-22 17:00:00","56497978719","Clip, Wash, Dry & Style"); --(cust, wed 03/22)

insert into booking values(null,"customer6","2017-03-23 10:00:00","2017-03-23 10:45:00","56497978719","Wash & Dry"); --(cust6, thur 03/23)
insert into booking values(null,"customer3","2017-03-23 11:00:00","2017-03-23 12:30:00","56497978719","Clip & Wash"); --(cust3, thur 03/23)
insert into booking values(null,"customer","2017-03-23 12:30:00","2017-03-23 14:30:00","56497978719","Clip & Wash"); --(cust, thur 03/23)
insert into booking values(null,"customer5","2017-03-23 14:30:00","2017-03-23 15:15:00","56497978719","Clip & Style"); --(cust5, thur 03/23)
insert into booking values(null,"customer4","2017-03-23 16:15:00","2017-03-23 16:45:00","56497978719","Wash & Dry"); --(cust4, thur 03/23)

insert into booking values(null,"customer","2017-03-24 09:00:00","2017-03-24 10:15:00","56497978719","Clip, Wash & Dry"); --(cust, fri 03/24)
insert into booking values(null,"customer2","2017-03-24 10:30:00","2017-03-24 11:15:00","56497978719","Clip & Style"); --(cust2, fri 03/24)
insert into booking values(null,"customer5","2017-03-24 11:30:00","2017-03-24 12:45:00","56497978719","Clip, Wash, Dry & Style"); --(cust5, fri 03/24)
insert into booking values(null,"customer4","2017-03-24 13:45:00","2017-03-24 14:15:00","56497978719","Clip"); --(cust4, fri 03/24)
insert into booking values(null,"customer2","2017-03-24 14:15:00","2017-03-24 15:00:00","56497978719","Wash & Dry"); --(cust2, fri 03/24)

insert into booking values(null,"customer2","2017-03-25 09:00:00","2017-03-25 09:45:00","56497978719","Wash & Dry"); --(cust2, sat 03/25)
insert into booking values(null,"customer4","2017-03-25 10:00:00","2017-03-25 10:30:00","56497978719","Clip"); --(cust4, sat 03/25)
insert into booking values(null,"customer","2017-03-25 11:30:00","2017-03-25 13:30:00","56497978719","Clip, Wash & Dry"); --(cust, sat 03/25)
insert into booking values(null,"customer6","2017-03-25 13:30:00","2017-03-25 14:15:00","56497978719","Clip & Style"); --(cust6, sat 03/25)
insert into booking values(null,"customer5","2017-03-25 14:45:00","2017-03-25 15:30:00","56497978719","Wash & Dry"); --(cust5, sat 03/25)
insert into booking values(null,"customer3","2017-03-25 15:30:00","2017-03-25 16:30:00","56497978719","Clip, Wash & Dry"); --(cust3, sat 03/25)
insert into booking values(null,"customer2","2017-03-25 16:30:00","2017-03-25 17:15:00","56497978719","Clip & Style"); --(cust2, sat 03/25)

insert into booking values(null,"customer4","2017-03-26 09:00:00","2017-03-26 09:45:00","56497978719","Wash & Dry"); --(cust4, sun 03/26)
insert into booking values(null,"customer5","2017-03-26 10:00:00","2017-03-26 11:00:00","56497978719","Clip, Wash & Dry"); --(cust5, sun 03/26)
insert into booking values(null,"customer3","2017-03-26 11:30:00","2017-03-26 12:15:00","56497978719","Clip & Style"); --(cust3, sun 03/26)
insert into booking values(null,"customer","2017-03-26 13:00:00","2017-03-26 13:45:00","56497978719","Clip, Wash & Dry"); --(cust, sun 03/26)
insert into booking values(null,"customer2","2017-03-26 14:45:00","2017-03-26 15:30:00","56497978719","Wash & Dry"); --(cust2, sun 03/26)
insert into booking values(null,"customer6","2017-03-26 16:30:00","2017-03-26 17:00:00","56497978719","Clip"); --(cust6, sun 03/26)
--
insert into booking values(null,"customer4","2017-03-27 10:30:00","2017-03-27 11:45:00","56497978719","Clip & Style"); --(cust4, mon 03/27)
insert into booking values(null,"customer3","2017-03-27 13:00:00","2017-03-27 13:45:00","56497978719","Wash & Dry"); --(cust3, mon 03/27)
insert into booking values(null,"customer2","2017-03-27 14:15:00","2017-03-27 16:00:00","56497978719","Clip, Wash & Dry"); --(cust2, mon 03/27)

insert into booking values(null,"customer6","2017-03-28 09:30:00","2017-03-28 10:00:00","56497978719","Clip"); --(cust6, tue 03/28)
insert into booking values(null,"customer5","2017-03-28 12:30:00","2017-03-28 13:30:00","56497978719","Clip, Wash & Dry"); --(cust5, tue 03/28)
insert into booking values(null,"customer","2017-03-28 16:45:00","2017-03-28 17:30:00","56497978719","Wash & Dry"); --(cust, tue 03/28)

insert into booking values(null,"customer","2017-03-29 10:00:00","2017-03-29 10:45:00","56497978719","Wash & Dry"); --(cust, wed 03/29)
insert into booking values(null,"customer2","2017-03-29 11:00:00","2017-03-29 12:30:00","56497978719","Clip & Wash"); --(cust2, wed 03/29)
insert into booking values(null,"customer3","2017-03-29 12:30:00","2017-03-29 14:30:00","56497978719","Clip & Wash"); --(cust3, wed 03/29)
insert into booking values(null,"customer4","2017-03-29 14:30:00","2017-03-29 15:15:00","56497978719","Clip & Style"); --(cust4, wed 03/29)
insert into booking values(null,"customer6","2017-03-29 16:15:00","2017-03-29 16:45:00","56497978719","Wash & Dry"); --(cust6, wed 03/39)

insert into booking values(null,"customer3","2017-03-30 11:30:00","2017-03-30 14:15:00","56497978719","Wash & Dry"); --(cust3, thur 03/30)
insert into booking values(null,"customer4","2017-03-30 15:30:00","2017-03-30 16:15:00","56497978719","Wash & Dry"); --(cust4, thur 03/30)
insert into booking values(null,"customer","2017-03-30 15:00:00","2017-03-30 15:45:00","56497978719","Clip & Style"); --(cust, thur 03/30)
insert into booking values(null,"customer5","2017-03-30 15:45:00","2017-03-30 17:00:00","56497978719","Clip, Wash, Dry & Style"); --(cust5, thur 03/30)

insert into booking values(null,"customer6","2017-03-31 09:00:00","2017-03-31 10:15:00","56497978719","Clip, Wash & Dry"); --(cust6, fri 03/31)
insert into booking values(null,"customer4","2017-03-31 10:30:00","2017-03-31 11:15:00","56497978719","Clip & Style"); --(cust4, fri 03/31)
insert into booking values(null,"customer2","2017-03-31 11:30:00","2017-03-31 12:45:00","56497978719","Clip, Wash, Dry & Style"); --(cust2, fri 03/31)
insert into booking values(null,"customer3","2017-03-31 13:45:00","2017-03-31 14:15:00","56497978719","Clip"); --(cust3, fri 03/31)
insert into booking values(null,"customer","2017-03-31 14:15:00","2017-03-31 15:00:00","56497978719","Wash & Dry"); --(cust, fri 03/31)

insert into booking values(null,"customer3","2017-04-01 09:00:00","2017-04-01 09:45:00","56497978719","Wash & Dry"); --(cust3, sat 04/01)
insert into booking values(null,"customer","2017-04-01 10:00:00","2017-04-01 11:00:00","56497978719","Clip, Wash & Dry"); --(cust, sat 04/01)
insert into booking values(null,"customer2","2017-04-01 11:30:00","2017-04-01 12:15:00","56497978719","Clip & Style"); --(cust2, sat 04/01)
insert into booking values(null,"customer6","2017-04-01 13:00:00","2017-04-01 13:45:00","56497978719","Clip, Wash & Dry"); --(cust6, sat 04/01)
insert into booking values(null,"customer4","2017-04-01 14:45:00","2017-04-01 15:30:00","56497978719","Wash & Dry"); --(cust4, sat 04/01)
insert into booking values(null,"customer5","2017-04-01 16:30:00","2017-04-01 17:00:00","56497978719","Clip"); --(cust5, sat 04/01)

insert into booking values(null,"customer5","2017-04-02 09:00:00","2017-04-02 09:45:00","56497978719","Wash & Dry"); --(cust5, sun 04/02)
insert into booking values(null,"customer3","2017-04-02 10:00:00","2017-04-02 10:30:00","56497978719","Clip"); --(cust3, sun 04/02)
insert into booking values(null,"customer2","2017-04-02 11:30:00","2017-04-02 13:30:00","56497978719","Clip, Wash & Dry"); --(cust2, sun 04/02)
insert into booking values(null,"customer6","2017-04-02 13:30:00","2017-04-02 14:15:00","56497978719","Clip & Style"); --(cust6, sun 04/02)
insert into booking values(null,"customer4","2017-04-02 14:45:00","2017-04-02 15:30:00","56497978719","Wash & Dry"); --(cust4, sun 04/02)
insert into booking values(null,"customer","2017-04-02 15:30:00","2017-04-02 16:30:00","56497978719","Clip, Wash & Dry"); --(cust, sun 04/02)
insert into booking values(null,"customer2","2017-04-02 16:30:00","2017-04-02 17:15:00","56497978719","Clip & Style"); --(cust2, sun 04/02)
--
insert into booking values(null,"customer4","2017-04-03 09:30:00","2017-04-03 10:00:00","56497978719","Clip"); --(cust4, mon 04/03)
insert into booking values(null,"customer2","2017-04-03 12:30:00","2017-04-03 13:30:00","56497978719","Clip, Wash & Dry"); --(cust2, mon 04/03)
insert into booking values(null,"customer5","2017-04-03 16:45:00","2017-04-03 17:30:00","56497978719","Wash & Dry"); --(cust5, mon 04/03)

insert into booking values(null,"customer","2017-04-04 10:30:00","2017-04-04 11:45:00","56497978719","Clip & Style"); --(cust, tue 04/04)
insert into booking values(null,"customer3","2017-04-04 13:00:00","2017-04-04 13:45:00","56497978719","Wash & Dry"); --(cust3, tue 04/04)
insert into booking values(null,"customer5","2017-04-04 14:15:00","2017-04-04 16:00:00","56497978719","Clip, Wash & Dry"); --(cust5, tue 04/04)

insert into booking values(null,"customer6","2017-04-05 11:30:00","2017-04-05 14:15:00","56497978719","Wash & Dry"); --(cust6, wed 04/05)
insert into booking values(null,"customer","2017-04-05 15:30:00","2017-04-05 16:15:00","56497978719","Wash & Dry"); --(cust, wed 04/05)
insert into booking values(null,"customer3","2017-04-05 15:00:00","2017-04-05 15:45:00","56497978719","Clip & Style"); --(cust3, wed 04/05)
insert into booking values(null,"customer4","2017-04-05 15:45:00","2017-04-05 17:00:00","56497978719","Clip, Wash, Dry & Style"); --(cust4, wed 04/05)

insert into booking values(null,"customer","2017-04-06 10:00:00","2017-04-06 10:45:00","56497978719","Wash & Dry"); --(cust, thur 04/06)
insert into booking values(null,"customer5","2017-04-06 11:00:00","2017-04-06 12:30:00","56497978719","Clip & Wash"); --(cust5, thur 04/06)
insert into booking values(null,"customer6","2017-04-06 12:30:00","2017-04-06 14:30:00","56497978719","Clip & Wash"); --(cust6, thur 04/06)
insert into booking values(null,"customer3","2017-04-06 14:30:00","2017-04-06 15:15:00","56497978719","Clip & Style"); --(cust3, thur 04/06)
insert into booking values(null,"customer2","2017-04-06 16:15:00","2017-04-06 16:45:00","56497978719","Wash & Dry"); --(cust2, thur 04/06)

insert into booking values(null,"customer5","2017-04-07 09:00:00","2017-04-07 10:15:00","56497978719","Clip, Wash & Dry"); --(cust5, fri 04/07)
insert into booking values(null,"customer","2017-04-07 10:30:00","2017-04-07 11:15:00","56497978719","Clip & Style"); --(cust, fri 04/07)
insert into booking values(null,"customer3","2017-04-07 11:30:00","2017-04-07 12:45:00","56497978719","Clip, Wash, Dry & Style"); --(cust3, fri 04/07)
insert into booking values(null,"customer2","2017-04-07 13:45:00","2017-04-07 14:15:00","56497978719","Clip"); --(cust2, fri 04/07)
insert into booking values(null,"customer4","2017-04-07 14:15:00","2017-04-07 15:00:00","56497978719","Wash & Dry"); --(cust4, fri 04/07)

insert into booking values(null,"customer4","2017-04-08 09:00:00","2017-04-08 09:45:00","56497978719","Wash & Dry"); --(cust4, sat 04/08)
insert into booking values(null,"customer2","2017-04-08 10:00:00","2017-04-08 10:30:00","56497978719","Clip"); --(cust2, sat 04/08)
insert into booking values(null,"customer3","2017-04-08 11:30:00","2017-04-08 13:30:00","56497978719","Clip, Wash & Dry"); --(cust3, sat 04/08)
insert into booking values(null,"customer","2017-04-08 13:30:00","2017-04-08 14:15:00","56497978719","Clip & Style"); --(cust, sat 04/08)
insert into booking values(null,"customer6","2017-04-08 14:45:00","2017-04-08 15:30:00","56497978719","Wash & Dry"); --(cust6, sat 04/08)
insert into booking values(null,"customer5","2017-04-08 15:30:00","2017-04-08 16:30:00","56497978719","Clip, Wash & Dry"); --(cust5, sat 04/08)

insert into booking values(null,"customer3","2017-04-09 09:00:00","2017-04-09 09:45:00","56497978719","Wash & Dry"); --(cust3, sun 04/09)
insert into booking values(null,"customer4","2017-04-09 10:00:00","2017-04-09 11:00:00","56497978719","Clip, Wash & Dry"); --(cust4, sun 04/09)
insert into booking values(null,"customer5","2017-04-09 11:30:00","2017-04-09 12:15:00","56497978719","Clip & Style"); --(cust5, sun 04/09)
insert into booking values(null,"customer2","2017-04-09 13:00:00","2017-04-09 13:45:00","56497978719","Clip, Wash & Dry"); --(cust2, sun 04/09)
insert into booking values(null,"customer6","2017-04-09 14:45:00","2017-04-09 15:30:00","56497978719","Wash & Dry"); --(cust6, sun 04/09)
insert into booking values(null,"customer","2017-04-09 16:30:00","2017-04-09 17:00:00","56497978719","Clip"); --(cust, sun 04/09)

insert into booking values(null,"customer3","2017-04-10 09:00:00","2017-04-10 10:00:00","56497978719","Wash & Dry"); --(cust3, mon 04/10)
insert into booking values(null,"customer4","2017-04-10 11:00:00","2017-04-10 12:00:00","56497978719","Clip, Wash & Dry"); --(cust4, mon 04/10)
insert into booking values(null,"customer5","2017-04-11 11:30:00","2017-04-11 12:30:00","56497978719","Clip & Style"); --(cust5, tue 04/11)
insert into booking values(null,"customer2","2017-04-12 13:00:00","2017-04-12 14:00:00","56497978719","Clip, Wash & Dry"); --(cust2, wed 04/12)
insert into booking values(null,"customer6","2017-04-14 10:45:00","2017-04-14 11:45:00","56497978719","Wash & Dry"); --(cust6, fri 04/14)
insert into booking values(null,"customer","2017-04-14 13:30:00","2017-04-14 14:30:00","56497978719","Clip"); --(cust, fri 04/14)

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

