<img src="https://drive.google.com/file/d/1__xAJ7zmferRlNfzMyt9r2He2xLw3l3M/view?usp=sharing" />

# E-SKOLAR

#### DEPENDENCIES
- php
- composer
- local database (mysql || xampp || lamp || postgresql || any)
- nodejs

#### SETUP
- ##### Tailwindcss
  - run ``` npm install ```
- ##### Laravel
  - run ``` composer update ```
  - rename ``` .env.example ``` file to ``` .env ```
  - configure ``` .env ``` file
  - run ``` php artisan migrate ```
  - run ``` php artisan key:generate ```
  - run ``` php artisan serve ```
        
- ##### Currently Working
    - Users Resource
        - [x] Viewing Users
        - [x] Adding Users
        - [x] Delete User
        - [x] Update User
        - [x] Adding List of Permission per User 
    
    - Permissions Resource
        - [x] Viewing Permissions
        - [x] Adding Permissions
        - [x] Delete Permission
        - [x] Update Permission
        - [x] Adding List of Users per Permission 
        - [x] Adding List of Roles per Permission 
    
    - Roles Resource
        - [x] Viewing Roles
        - [x] Adding Roles
        - [x] Delete Role
        - [x] Update Role
        - [x] Adding List of Users per Role 
        - [x] Adding List of Permission per Role 

    - Sponsors Resource
        - [ ] Viewing Sponsors
        - [ ] Adding Sponsors
        - [ ] Delete Sponsor
        - [ ] Update Sponsor
        - [ ] Adding List of Scholar per Sponsor 
        