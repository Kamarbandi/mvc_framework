# My PHP Framework

This is my custom PHP framework, built to demonstrate my coding skills and understanding of software development principles. Although it's still a work in progress, it is a fully functional framework based on the MVC (Model-View-Controller) architecture.

## Features
- **MVC Architecture**: Separate layers for Models, Views, and Controllers to ensure a clean and organized code structure.
- **Database Integration**: Easy-to-use methods for interacting with a database using prepared statements to ensure security.
- **Autoloading**: Automatically loads classes when they are needed, reducing the need for manual imports.
- **Routing**: Simplified request routing to easily map URLs to controllers and methods.

## Current Status
- This framework is **still being improved** but **fully functional** and can be used for small to medium projects.
- It is primarily created for personal use and as a showcase of my coding skills.
- While it's still being enhanced, you can use it for your projects as it provides essential functionality for building web applications.

## Usage
1. Clone or download this repository.
2. Set up your database and configure the connection in the `config.php` file.
3. Start creating your models, controllers, and views in the respective directories.
4. Follow the MVC pattern to build your application.

## Command Line Tool

    Database
      db:create          Initializes a new database schema.
      db:seed            Executes the specified seeder to populate the database with known data.
      db:table           Fetches details about the selected table.
      db:drop            Drop/Delete a database.
      migrate            Identifies and runs a migration file.
      migrate:refresh    Executes the 'down' method followed by the 'up' method for a migration file.
      migrate:rollback   Executes the 'down' method for a migration file

    Generators
      make:controller    Creates a new controller file.
      make:model         Creates a new model file.
      make:migration     Creates a new migration file.
      make:seeder        Creates a new seeder file.
    
    Other
      list:migrations    Lists all available migration files.


## example
php azad make:controller Post