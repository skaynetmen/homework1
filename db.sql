CREATE TABLE IF NOT EXISTS works
(
  id          INT PRIMARY KEY      NOT NULL AUTO_INCREMENT,
  title       VARCHAR(255)         NOT NULL,
  description TEXT                 NOT NULL,
  link        VARCHAR(255)         NOT NULL,
  image       VARCHAR(255)         NOT NULL,
  created_at  INT                  NOT NULL,
  updated_at  INT                  NOT NULL,
  active      BOOLEAN DEFAULT TRUE NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# INSERT INTO works (title, description, link, image, created_at, updated_at) VALUES ('a-industry.ru', 'Корпоративный и в тоже время продающий сайт строительной компании a-industry.', '#', '/img/works/work-1.jpg', 1450117170, 1450117170);

CREATE TABLE users
(
  id         INT                  NOT NULL AUTO_INCREMENT,
  name       VARCHAR(255)         NOT NULL,
  lastname   VARCHAR(255)         NOT NULL,
  email      VARCHAR(255)         NOT NULL,
  password   VARCHAR(255)         NOT NULL,
  created_at INT                  NOT NULL,
  updated_at INT                  NOT NULL,
  active     BOOLEAN DEFAULT TRUE NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
CREATE UNIQUE INDEX users_email_uindex ON users (email);