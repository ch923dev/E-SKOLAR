
# 1. E-Scholar

## Description

    E-Skolar is a Scholar Monitoring System to be used by USTP Admission and Scholarship Office (ASO)

## Table of Contents

- [1. E-Scholar](#1-e-scholar)
  - [Description](#description)
  - [Table of Contents](#table-of-contents)
- [2. DEPENDENCIES](#2-dependencies)
- [3. SETUP](#3-setup)
  - [3.1 **Laravel**](#31-laravel)
- [4. Models and Database](#4-models-and-database)
  - [4.1 **Module Model**](#41-module-model)
    - [4.1.1 **Attributes**](#411-attributes)
    - [4.1.2 **Model**](#412-model)
      - [4.1.2.1 **Relationships**](#4121-relationships)
    - [4.1.3 **Seeder**](#413-seeder)
    - [4.1.4 **Factory**](#414-factory)
    - [4.1.5 **Policy**](#415-policy)
  - [4.2 **Role Model**](#42-role-model)
    - [4.2.1 **Attributes**](#421-attributes)
    - [4.2.2 **Model**](#422-model)
      - [4.2.2.1 **Relationships**](#4221-relationships)
    - [4.2.3 **Seeder**](#423-seeder)
    - [4.2.4 **Factory**](#424-factory)
- [5. Resources](#5-resources)
  - [5.1 **Role Resource**](#51-role-resource)
  - [5.2 **Module Resource**](#52-module-resource)

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

## 4.1 **Module Model**

### 4.1.1 **Attributes**

| Attribute      | Key (Type) | Description |
| :--- | :--- | :--- |
| **id**      | Primary (Integer) | Primary key of the model
| module   | Attribute(Text) | Name of the model

### 4.1.2 **Model**

#### 4.1.2.1 **Relationships**

| Relationship Name      | Relationship Type | Model | Pivot |
| :--- | :--- | :--- | :--- |
| roles      | belongsToMany | [Roles](#42-role-model) | level

### 4.1.3 **Seeder**

> **Default Modules Inserted**
>
> 1. Role
> 2. Module
> 3. Scholar
> 4. User

### 4.1.4 **Factory**

> No Model factory was produced.

### 4.1.5 **Policy**

## 4.2 **Role Model**
  
### 4.2.1 **Attributes**

| Attribute      | Key (Type) | Description |
| :--- | :--- | :--- |
| **id**      | Primary (Integer) | Primary key of the model
| role   | Attribute(Text) | Name of the model

### 4.2.2 **Model**

#### 4.2.2.1 **Relationships**

| Relationship Name      | Relationship Type | Model | Pivot |
| :--- | :--- | :--- | :--- |
| modules      | belongsToMany | [Module](#41-module-model) | level
| users   | hasMany | User

### 4.2.3 **Seeder**

> **Default Role Inserted**
>
>  1. Admin
>  2. Staff
>  3. Scholar
>  4. Organization
  
### 4.2.4 **Factory**

> No Model factory was produced.

# 5. Resources

## 5.1 **Role Resource**

- [x] Viewing Model
  - [x] List Viewing
    - [x] Searchable Role
    - [x] Sortable User Count
  - [x] Individual Viewing
    - [x] Relation Manager
      - [x] Users
      - Description: User with **Role** Model
        - [x] Adding New User
        - [x] Searching User
        - [x] Changing Role
      - [x] Modules
      - Description: Modules and Access Level with **Role** Model
        - [x] Searchable Module
        - [x] Change Access Level
- [x] Adding Role
  - [x] Form Wizard
    - [x]  Role Name
      - [x] Attribute: Unique Name
    - [x]  Module Access Level
      - [x]  Access Levels:
        - [x]  Manage
        - [x]  View
        - [x]  Not Applicable
    - [x]  Adding Users (Optional)
- [x] Delete Role
  - [x] Users within that **Role** will have null ***role_id***
  - [x] Default **Roles** will not be deleted
- [x] Update Role
  - [x] Default **Roles** will not be updated

## 5.2 **Module Resource**

- [x] Viewing Model
  - [x] List Viewing
    - [x] Searchable Role
    - [x] Sortable User Count
  - [x] Individual Viewing
    - [x] Relation Manager
      - [x] Users
      - Description: User with **Role** Model
        - [x] Adding New User
        - [x] Searching User
        - [x] Changing Role
      - [x] Modules
      - Description: Modules and Access Level with **Role** Model
        - [x] Searchable Module
        - [x] Change Access Level
- [x] Adding Role
  - [x] Form Wizard
    - [x]  Role Name
      - [x] Attribute: Unique Name
    - [x]  Module Access Level
      - [x]  Access Levels:
        - [x]  Manage
        - [x]  View
        - [x]  Not Applicable
    - [x]  Adding Users (Optional)
- [x] Delete Role
  - [x] Users within that **Role** will have null ***role_id***
  - [x] Default **Roles** will not be deleted
- [x] Update Role
  - [x] Default **Roles** will not be updated
