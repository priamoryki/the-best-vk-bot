create table deadlines
(
    id      INTEGER not null
        constraint deadlines_pk
            primary key autoincrement,
    user_id INTEGER not null,
    name    TEXT    not null,
    date    TEXT    not null
);
