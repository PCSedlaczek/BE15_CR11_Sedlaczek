DROP TABLE adoptions;
DROP TABLE animals;
DROP TABLE users;

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR (35),
  lname VARCHAR (35),
  email VARCHAR (255),
  phone VARCHAR(26),
  address VARCHAR (95),
  city VARCHAR (45),
  zip VARCHAR (10),
  country VARCHAR (53) DEFAULT "Austria",
  img VARCHAR(50),
  pwd VARCHAR(255),
  status VARCHAR(5) NOT NULL DEFAULT "user"
);

CREATE TABLE animals (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR (35),
  image VARCHAR (50),
  location VARCHAR (95),
  description TEXT,
  species VARCHAR (10),
  breed VARCHAR (30),
  gender VARCHAR (6),
  size VARCHAR (6),
  age INT,
  hobbies VARCHAR (255),
  registered DATE,
  status ENUM('Available','Adopted','Reserved','Weaning','Recovering','Withdrawn','Deceased')
);

CREATE TABLE adoptions (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  fk_user INT,
  fk_animal INT,
  date DATE,
  FOREIGN KEY (fk_user) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (fk_animal) REFERENCES animals(id) ON DELETE SET NULL
);

INSERT INTO animals 
  (species, breed, name, size, age, gender, location, registered, status, image)
VALUES
  ("Hedgehog", "", "Spike", "small", 4, "male", "Wildtierhilfe Wien", "2018-02-02", "Available", "hedgehogs/arif-hidayat-mGQ5-MTqRbQ-unsplash.jpg"), 
  ("Bunny", "", "Nero", "medium", 3, "male", "TierQuarTier Wien", "2019-06-30", "Available", "rabbits/aneta-voborilova-HxfVwDszy2Q-unsplash.jpg"), 
  ("Bunny", "", "Cookie", "medium", 1, "female", "TierQuarTier Wien", "2021-06-20", "Available", "rabbits/erik-jan-leusink-SDX4KWIbA-unsplash.jpg"),
  ("Guinea pig", "", "Coco", "medium", 2, "female", "TierQuarTier Wien", "2020-06-22", "Available", "rodents/nils-schirmer-cKYM8KMwaUQ-unsplash.jpg"),
  ("Dog", "Samoyed", "Jack Frost", "large", 9, "male", "TierQuarTier Wien", "2017-09-05", "Available", "dogs/lui-peng-ybHtKz5He9Y-unsplash.jpg"),
  ("Dog", "Australian Shepherd", "Sushi", "large", 2, "female", "TierQuarTier Wien", "2021-05-10", "Available", "dogs/flouffy-g2FtlFrc164-unsplash.jpg"),
  ("Dog", "Terrier", "Toto", "medium", 5, "male", "TierQuarTier Wien", "2019-04-05", "Available", "dogs/victor-grabarczyk-N04FIfHhv_k-unsplash.jpg"),
  ("Dog", "Schnauzer", "Rambo", "medium", 11, "male", "TierQuarTier Wien", "2019-04-05", "Available", "dogs/flouffy-qEO5MpLyOks-unsplash.jpg"),
  ("Cat", "British Longhair", "Stella", "large", 10, "female", "TierQuarTier Wien", "2015-06-25", "Available", "cats/fabrice-audio-ZDLYDbIeYpw-unsplash.jpg"),
  ("Snake", "Beauty rat snake", "Sandy", "medium", 5, "male", "Wildtierhilfe Wien", "2019-03-14", "Available", "reptiles/stijn-swinnen-DXoWetDELis-unsplash.jpg"),
  ("Tortoise", "Greek tortoise", "Cassiopeia", "medium", 12, "female", "Wildtierhilfe Wien", "2015-07-02", "Available", "reptiles/marcus-dietachmair-4JUscQ_9UrA-unsplash.jpg");