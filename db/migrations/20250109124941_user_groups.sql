-- migrate:up

create table user_groups
(
    user_id  int unsigned not null,
    group_id int unsigned not null,

    primary key (user_id, group_id),

    constraint foreign key `fk.ug.user_id__users.id` (user_id) references user (id)
        on delete cascade on update cascade,

    constraint foreign key `fk.ug.group_id__groups.id` (group_id) references `groups` (id)
        on delete restrict on update cascade

);

-- migrate:down

drop table user_groups;