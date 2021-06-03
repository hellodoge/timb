insert into users
(username, full_name, password_hash)
values
(:username, :full_name, :password_hash)
returning id;