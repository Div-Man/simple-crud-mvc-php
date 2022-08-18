create type user_role as enum ('admin', 'user');

CREATE TABLE users (
    id SERIAL,
    nickname character varying(128) NOT NULL UNIQUE,
    email character varying(255) NOT NULL UNIQUE,
    is_confirmed smallint NOT NULL DEFAULT '0',
    role user_role NOT NULL,
    password_hash varchar(255) NOT NULL,
    auth_token varchar(255) NOT NULL,
    created_at date NOT NULL DEFAULT CURRENT_TIMESTAMP

);

INSERT INTO users (nickname, email, is_confirmed, role, password_hash, auth_token, created_at) 
VALUES ('admin', 'admin@gmail.com', '1', 'admin', '$2y$10$2WWSm3nuS/MebW1EnD7T1eLXCRCLxjbEFxJSSFOPgcuMdxlYqcHba', 'token1', CURRENT_TIMESTAMP);

CREATE TABLE articles (
    id SERIAL,
    author_id INT NOT NULL,
    name character varying(255) NOT NULL,
    text text NOT NULL,
    created_at date NOT NULL DEFAULT CURRENT_TIMESTAMP
)


CREATE TABLE users_activation_codes (
  id SERIAL,
  user_id int NOT NULL,
  code character varying(255) NOT NULL
);

