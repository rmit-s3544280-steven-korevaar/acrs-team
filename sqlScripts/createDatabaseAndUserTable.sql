create database if not exists SEPT_Assignment_Part_1;

use SEPT_Assignment_Part_1;

create table userTable(
username varchar(20) primary key,
password char(40) not null
);



insert into userTable values('Firstuser',SHA('password'));

