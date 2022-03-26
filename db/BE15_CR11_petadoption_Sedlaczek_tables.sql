DROP TABLE adoption;
DROP TABLE animal;
DROP TABLE `user`;

CREATE TABLE `user` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR (35),
  lname VARCHAR (35),
  email VARCHAR (255),
  phone VARCHAR(15),
  mobile VARCHAR (26),
  address VARCHAR (95),
  city VARCHAR (45),
  zip VARCHAR (10),
  image VARCHAR(50),
  password VARCHAR(255)
);

CREATE TABLE animal (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR (35),
  image VARCHAR (50),
  location VARCHAR (95),
  description TEXT,
  size VARCHAR (6),
  age INT,
  hobbies VARCHAR (255),
  breed VARCHAR (30),
  registered DATE,
  status ENUM('Available','Adopted','Reserved','Weaning','Recovering','Withdrawn','Deceased')
);

CREATE TABLE adoption (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  fk_user INT,
  fk_animal INT,
  date DATE,
  FOREIGN KEY (fk_user) REFERENCES `user`(id) ON DELETE SET NULL,
  FOREIGN KEY (fk_animal) REFERENCES animal(id) ON DELETE SET NULL
)