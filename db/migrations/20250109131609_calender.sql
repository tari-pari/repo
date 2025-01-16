-- migrate:up


create table calender
(
    id           int unsigned not null auto_increment,
    `name`       varchar(150) not null,
    beschreibung text         null default null,
    group_id     int unsigned not null,

    primary key (id),

    unique index `ux.calender.name` (`name`),

    constraint foreign key `fk.cal.group_id__groups.id` (group_id) references `groups` (id)
        on delete cascade
);




-- migrate:down
drop table calender;