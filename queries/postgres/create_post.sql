insert into posts (author_id, reply_to_id, text)
values (:author, :reply_to, :text)
returning id;