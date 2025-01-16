-- migrate:up

create table entries
(
    id              int unsigned not null auto_increment,
    cal_id          int unsigned not null,
    title           varchar(200) null default null,
    beschreibung    text         null default null,
    datum           date         null default null,
    start_time       time        null default null,
    end_time         time        null default null,
    date_created_at datetime          default now(),


    primary key (id),

    constraint foreign key `fk.entries.cal_id__cal.id` (cal_id) references calender (id)
        on delete cascade
);


-- migrate:down

drop table entries;