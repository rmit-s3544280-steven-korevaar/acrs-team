/* Script used to insert dummy records for testing purposes.
 */
--Insert record into business
insert into business values("Dog Grooming","The Groomer","1 DogGrooming st Victora","0398765432","00000000001");

--Insert record into employee
insert into employee values("Mr Groomer","Groomer","00000000001","001");

--Insert record into workPeriod
insert into workPeriod values("2017-03-21",720,840,"001");

--Insert record into user
--Business Owner
insert into user values("owner","Mr Groomer","1 DogGrooming st Victora","0398765432",SHA("owner"));

--Customer
insert into user values("customer","Dummy User","2 DogGrooming st Victora","0398765431",SHA("customer"));

--Insert record into booking
insert into booking values(null,"customer","2017-03-21 12:00:00","2017-03-21 13:00:00",
"00000000001","Some other details to fill in.");


--Insert record into userBusiness
insert into userBusiness values("owner","00000000001");