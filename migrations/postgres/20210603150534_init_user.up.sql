
create table users (
    id serial not null unique,
    username varchar(64) not null unique,
    full_name varchar(256) not null,
    password_hash varchar(256) not null
);

alter table posts
add constraint author_id_fk
    foreign key (author_id)
    references users(id);