CREATE TABLE comment (id INT AUTO_INCREMENT, post_id INT, user_id INT, comment text, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), INDEX post_id_idx (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE post (id INT AUTO_INCREMENT, title VARCHAR(255), content text, user_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE user (id INT AUTO_INCREMENT, username VARCHAR(255), password VARCHAR(255), first_name VARCHAR(255), last_name VARCHAR(255), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
ALTER TABLE comment ADD CONSTRAINT comment_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id);
ALTER TABLE comment ADD CONSTRAINT comment_post_id_post_id FOREIGN KEY (post_id) REFERENCES post(id);
ALTER TABLE post ADD CONSTRAINT post_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id);
