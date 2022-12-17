create table deadlines
(
    id        INTEGER not null
        constraint deadlines_pk
            primary key autoincrement,
    user_id   INTEGER not null,
    name      TEXT    not null,
    timestamp INTEGER not null
);

create table timezones
(
    user_id  INTEGER not null
        constraint timezones_pk
            primary key,
    timezone INTEGER not null
);
