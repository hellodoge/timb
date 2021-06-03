create table posts (
    id serial not null unique,
    author_id int not null,
    reply_to_id int references posts (id) on delete set null,
    text varchar(512),
    created_at timestamp with time zone not null default now()
);