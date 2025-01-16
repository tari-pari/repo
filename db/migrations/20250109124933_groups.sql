-- migrate:up


create table `groups`
(
    id         int unsigned not null auto_increment,
    group_name varchar(200) not null,


    primary key (id)
);


-- migrate:down
drop table `groups`;