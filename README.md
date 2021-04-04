## Code Challenge (PHP) - Hobbii

* Requirements 
    - [x] Bob must not be able to create projects with the same name twice 
    - [x] Bob must be able to remove projects 
    - [x] Bob must be able to start and stop working on projects 
    - [x] Bob must be able to see an overview of projects and the total time spent on a project in hours 

* Nice to have (Bonus tasks) 
    - [x] Bob would like to invoice customers while working on projects, thus creating an invoice with his base price of 500 DKK per hour spent. Creating subsequent invoice for the same project should only contain the hours worked since the last invoice 
    - [x] Bob would like to mark projects as completed, thus removing them from the overview, they should however always be visible from a project archive view

* Observations:
    - To create a project, you must have at least one client created;
    - When removing projects, all interactions will be removed;
    - When creating a project, an interaction is created automatically and is already visible on the dashboard, but is not initiated;
    - "Finish Project" or "Generate Invoice" are only available on the dashboard when the project status is set to "stopped".

* Used Stack:
    - Ubuntu 20.04
    - PHP 8.0.2
    - MySQL
    - Laravel 8.12
    - PHPUnit with SQLite3

* New paths for the structure
    - app
        - Contracts: Interfaces
        - Helpers: Auxiliary classes
        - Providers
            - ContractServiceProvider.php: Interfaces Bind
        - Services: Layer between Controller and Model (Business)

* Instalation:
    - Create .env file;
    - Run: composer install
    - Run: php artisan migrate

* Get Routes:
    - Welcome:
        - /
    - Actions:
        - Dashboard: /dashboard
        - Start Task: /dashboard/run/{id}
        - Stop Task: /dashboard/stop/{id}
        - Generate Invoice: /dashboard/invoice/{id}
    - Clients:
        - List: /clients
        - Create: /clients/create
        - Edit: /clients/edit/{id}
    - Projects:
        - List: /projects
        - Create: /projects/create
        - Edit: /projects/edit/{id}
        - Finish: /projects/finish/{id}

* Post Routes:
    - Clients:
        - Store: /clients/store
    - Projects:
        - Store: /projects/store

* Patch Routes:
    - Clients:
        - Update: /clients/edit/{id}
    - Projects:
        - Update: /projects/edit/{id}

* Delete Routes:
    - Clients:
        - Delete: /clients/remove/{id}
    - Projects:
        - Delete: /projects/remove/{id}


### Thank You!
#### Fernando Maio