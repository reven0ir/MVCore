CREATE TABLE gallery (
    id SERIAL PRIMARY KEY,
    post_id INTEGER,
    image VARCHAR(255),
    CONSTRAINT fk_post
                     FOREIGN KEY (post_id)
                     REFERENCES  posts(id)
                     ON DELETE CASCADE
);