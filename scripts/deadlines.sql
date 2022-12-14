create table deadlines
(
    id      INT  not null
        constraint deadlines_pk
            primary key,
    user_id INT  not null,
    name    TEXT not null,
    date    TEXT not null
);
