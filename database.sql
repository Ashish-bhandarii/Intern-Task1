create database my_db;

create table users (
    id int primary key auto_increment,
    username varchar(100) not null unique,
    email varchar(100) not null unique,
    phone varchar(15) not null unique,
    subject varchar(200) not null,
    message text not null,
    created_at timestamp default current_timestamp
);

