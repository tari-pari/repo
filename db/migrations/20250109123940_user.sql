-- migrate:up

-- noinspection SpellCheckingInspectionForFile


create table `user`
(
    id       int unsigned not null auto_increment,
    anrede   varchar(50)  not null,
    vorname  varchar(100) not null,
    nachname varchar(100) not null,
    username varchar(100) not null,
    passwort varchar(200) not null,
    email    varchar(200) not null,

    primary key (id),

    unique index `ux.user.email.username` (email, username)
);




-- migrate:down

drop table user;