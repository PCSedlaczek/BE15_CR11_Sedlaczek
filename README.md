# BE15_CR11_Sedlaczek
Pet Adoption Platform

## Prepare
- [x] Create private GitHub repo (BE15-CR10-Sedlaczek)
- [x] Create Task List from project requirements
- [x] Organize project files into folders according to type
- [x] Create CRUD Login file & folder structure
- [x] Copy over animal images from Pet Shop CodeReview
- [x] Research animal rescues / adoption centers

## MySQL Database 
- [x] Create database BE15_CR11_petadoption_sedlaczek
- [x] Create 2 tables
  - [x] users
    - [x] first_name
    - [x] last_name
    - [x] email
    - [x] phone_number
    - [x] address
    - [x] picture
    - [x] password
  - [x] animals
    - [x] name
    - [x] photo
    - [x] location
    - [x] description
    - [x] size
    - [x] age
    - [x] gender
    - [x] hobbies
    - [x] species
    - [x] breed
    - [x] date_registered
    - [x] status/availability
- [x] Add sufficient test data to animals table (at least 10 records in total between small and large animals)
- [x] Add at least 4 senior animals (older than 8 years)

## PHP CRUD
- [x] Display all animals on a single web page (home.php)
- [x] Present a nice GUI (Bootstrap/HTML/CSS/JavaScript)
- [x] Display all senior animals (filter or new page)
- [x] Show more button to show animal details on new page

## CRUD Login
- [x] Create Registration & Login System
- [x] Create seperate sessions for normal users and admins
  - [x] Users only able to see/read and access all data, no action buttons available
  - [x] Create Admin Dashboard to be able to create, update and delete data about animals (not users) 
- [x] Insert form for inserting animals into database
- [x] Update form for updating animals in database
- [x] Delete button for deleting animals from database

## Bonus
- [ ] Implement Pet Adoption
  - [x] Create table pet_adoption
    - [x] fk_userID
    - [x] fk_petID
    - [x] adoptionID
    - [x] adoption_date
  - [ ] Button "Take me home" on each Pet information/card
  - [ ] Create new record in pet_adoption table
    - [ ] POST method: create a form
    - [ ] GET method: no form needed

## Extend
- [ ] 

## Finalize
- [x] Format documents in Visual Studio Code
- [x] Push files to GitHub repository
- [x] Send repository link through LMS
- [x] Invite codefactorygit as collaborator

Work time: 27:00 hrs