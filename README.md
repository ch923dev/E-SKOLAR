
# 1. E-Scholar

## Description

    E-Skolar is a Scholar Monitoring System to be used by USTP Admission and Scholarship Office (ASO)

- [1. E-Scholar](#1-e-scholar)
  - [Description](#description)
- [2. DEPENDENCIES](#2-dependencies)
- [3. SETUP](#3-setup)
  - [3.1 **Laravel**](#31-laravel)
- [4. Models and Database](#4-models-and-database)
  - [4.1 **Role Model**](#41-role-model)
    - [4.1.1 **Attributes**](#411-attributes)
    - [4.1.2 **Model**](#412-model)
    - [4.1.3 **Seeder**](#413-seeder)
    - [4.1.4 **Factory**](#414-factory)
- [5. Resources](#5-resources)
  - [5.1 **Role Resource**](#51-role-resource)

# 2. DEPENDENCIES

- php
- composer
- local database (mysql || xampp || lamp || postgresql || any)
- nodejs

# 3. SETUP

## 3.1 **Laravel**

- run ``` composer update ```
- copy ``` .env.example ``` file to ``` .env ```
- configure ``` .env ``` file
- run ``` php artisan migrate:fresh --seed ```
- run ``` php artisan key:generate ```
- run ``` php artisan serve ```

# 4. Models and Database

## 4.1 **Role Model**
  
### 4.1.1 **Attributes**

>| Attribute      | Key (Type) | Description |
>| :--- | :--- | :--- |
>| **id**      | Primary (Integer) | Primary key of the model
>| role   | Attribute(Text) | Name of the model

### 4.1.2 **Model**

> **Relationships**
>
>| Relationship Name      | Relationship Type | Model | Pivot |
>| :--- | :--- | :--- | :--- |
>| modules      | belongsToMany | Module | level
>| users   | hasMany | User

### 4.1.3 **Seeder**

> **Default Role Inserted**
>
>  1. Admin
>  2. Staff
>  3. Scholar
>  4. Organization
  
### 4.1.4 **Factory**

> No Model factory was produced.

# 5. Resources

## 5.1 **Role Resource**

- [ ] Admin Access
  - [x] Viewing Role
    - [x] List Role
      - [x] Searchable Role
      - [x] Sortable User Count
    - [x] Relation Manager
      - [x] Users
      - [x] Modules
  - [x] Adding Role
  - [x] Delete Role
  - [x] Update Role
- [x] Adding List of Permission per User
