/* Script used to insert dummy records for testing purposes.
 */
--Insert record into business
insert into business values("Dog Grooming","The Groomer","1 DogGrooming st Victora","0398765432","00000000001");

--Insert record into employee
insert into employee values("Mr Groomer","Groomer","00000000001","001");
insert into employee values("Ms CatGroomer","Groomer","00000000001","002");
insert into employee values("Mr DogGroomer","Groomer","00000000001","003");

--Insert record into workPeriod
insert into workPeriod values("2017-03-21 12:00:00","2017-03-21 13:00:00","001");
insert into workPeriod values("2017-03-22 12:00:00","2017-03-21 13:00:00","002");
insert into workPeriod values("2017-03-23 12:00:00","2017-03-21 13:00:00","003");

--Insert record into user
--Business Owner
insert into user values("owner","Mr Groomer","1 DogGrooming st Victora","0398765432",SHA("owner"));

--Customer
insert into user values("customer","Dummy User","2 DogGrooming st Victora","0398765431",SHA("customer"));
insert into user values("customer2","Dummy User 2","3 DogGrooming st Victora","0398765432",SHA("customer2"));
insert into user values("customer3","Dummy User 3","4 DogGrooming st Victora","0398765433",SHA("customer3"));

--Insert record into booking
insert into booking values(null,"customer","2017-03-21 12:00:00","2017-03-21 13:00:00",
"00000000001","Some other details to fill in.");
insert into booking values(null,"customer2","2017-03-22 13:15:00","2017-03-21 14:15:00",
"00000000001","Some other details to fill in.");
insert into booking values(null,"customer3","2017-03-23 14:30:00","2017-03-21 15:30:00",
"00000000001","Some other details to fill in.");


--Insert record into userBusiness
insert into userBusiness values("owner","00000000001");