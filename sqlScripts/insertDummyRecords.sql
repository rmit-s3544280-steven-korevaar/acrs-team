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
insert into user values("groomer","Mr Groomer","1 DogGrooming st Victora","0398765432",SHA("password"));

--Customer
insert into user values("dummy","Dummy User","2 DogGrooming st Victora","0398765431",SHA("password"));

--Insert record into booking
insert into booking values(null,"dummy","2017-03-21",660,840,
"00000000001","Some other details to fill in.");

--Insert record into userBusiness
insert into userBusiness values("groomer","00000000001");