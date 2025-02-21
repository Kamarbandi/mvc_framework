<?php

namespace Kamarbandi;

/**
 * Kamarbandi class
 */
class Kamarbandi
{
    private $version = '1.0.0';

    /**
     * @param $argv
     * @return void
     */
    public function db($argv)
    {
        if (empty($argv[1])) {
            die("\n\rError: No command provided. Please specify a valid database command.\n\r");
        }

        $command = $argv[1];
        $param = $argv[2] ?? null;

        if (empty($param)) {
            die("\n\rError: Missing required parameter (database or table name).\n\r");
        }

        $db = new Database;

        switch ($command) {
            case 'db:create':
                $this->createDatabase($db, $param);
                break;

            case 'db:table':
                $this->describeTable($db, $param);
                break;

            case 'db:drop':
                $this->dropDatabase($db, $param);
                break;

            case 'db:seed':
                $this->seedDatabase($db);
                break;

            default:
                die("\n\rError: Unknown command '$command'. Please use a valid command such as 'db:create', 'db:table', 'db:drop', or 'db:seed'.\n\r");
        }

    }

    /**
     * @param Database $db
     * @param string $DB_NAME
     * @return void
     */
    private function createDatabase(Database $db, string $DB_NAME): void
    {
        $query = "CREATE DATABASE IF NOT EXISTS " . $DB_NAME;
        $db->query($query);
        echo("\n\rSuccess: Database '$DB_NAME' created successfully.\n\r");
    }

    /**
     * @param Database $db
     * @param string $tableName
     * @return void
     */
    private function describeTable(Database $db, string $tableName): void
    {
        $query = "DESCRIBE " . $tableName;
        $result = $db->query($query);

        if ($result) {
            echo "\n\rTable structure for '$tableName':\n\r";
            print_r($result);
        } else {
            echo "\n\rError: Could not find data for table '$tableName'.\n\r";
        }
    }

    /**
     * @param Database $db
     * @param string $DB_NAME
     * @return void
     */
    private function dropDatabase(Database $db, string $DB_NAME): void
    {
        $query = "DROP DATABASE " . $DB_NAME;
        $db->query($query);
        echo("\n\rSuccess: Database '$DB_NAME' deleted successfully.\n\r");
    }

    /**
     * @param Database $db
     * @return void
     */
    private function seedDatabase(Database $db): void
    {
        // Placeholder for seeding functionality
        echo "\n\rSeeding database...\n\r";
    }


    /**
     * @param $argv
     * @return void
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function list($argv)
    {
        $command = $argv[1] ?? null;

        switch ($command) {
            case 'list:migrations':

                $folder = 'app' . DIRSEP . 'migrations' . DIRSEP;
                if (!file_exists($folder)) {
                    die("\n\rNo migration files were found\n\r");
                }

                $files = glob($folder . "*.php");
                echo "\n\rMigration files:\n\r";

                foreach ($files as $file) {
                    echo basename($file) . "\n\r";
                }
                break;

            default:
                // code...
                break;
        }
    }


    /**
     * @param $argv
     * @return void
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function make($argv)
    {
        if (empty($argv[1])) {
            die("\n\rError: No command provided. Please specify a valid command.\n\r");
        }

        $mode = $argv[1];
        $classname = $argv[2] ?? null;

        if (empty($classname)) {
            die("\n\rError: Please provide a class name.\n\r");
        }

        $classname = preg_replace("/[^a-zA-Z0-9_]+/", "", $classname);
        if (preg_match("/^[^a-zA-Z_]+/", $classname)) {
            die("\n\rError: Class names cannot start with a number.\n\r");
        }

        switch ($mode) {
            case 'make:controller':
                $this->createController($classname);
                break;

            case 'make:model':
                $this->createModel($classname);
                break;

            case 'make:migration':
                $this->createMigration($classname);
                break;

            case 'make:seeder':
                // here you can add some of code to generate seed file
                break;

            default:
                die("\n\rError: Unknown command '$mode'. Please use a valid command.\n\r");
        }

    }

    /**
     * @param string $classname
     * @return void
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    private function createController(string $classname)
    {
        $fileName = 'app' .DIRSEP. 'Http' . DIRSEP . 'Controllers' . DIRSEP . ucfirst($classname) . ".php";

        if (file_exists($fileName)) {
            die("Controller '$classname' already exists.");
        }

        $patternFile = file_get_contents('app' . DIRSEP . 'azad' . DIRSEP . 'samples' . DIRSEP . 'controller-pattern.php');
        $patternFile = str_replace(['{CLASSNAME}', '{classname}'], [ucfirst($classname), strtolower($classname)], $patternFile);

        if (file_put_contents($fileName, $patternFile)) {
            die("\n\rSuccess: Controller '$classname' created successfully.\n\r");
        } else {
            die("Failed to create Controller due to an error.");
        }
    }

    /**
     * @param string $classname
     * @return void
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    private function createModel(string $classname)
    {
        $fileName = 'app' . DIRSEP . 'Models' . DIRSEP . ucfirst($classname) . ".php";

        if (file_exists($fileName)) {
            die("Model '$classname' already exists.");
        }

        $patternFile = file_get_contents('app' . DIRSEP . 'azad' . DIRSEP . 'samples' . DIRSEP . 'model-pattern.php');
        $patternFile = str_replace('{CLASSNAME}', ucfirst($classname), $patternFile);

        $tableName = preg_match("/s$/", $classname) ? strtolower($classname) : strtolower($classname) . 's';
        $patternFile = str_replace('{table}', $tableName, $patternFile);

        if (file_put_contents($fileName, $patternFile)) {
            die("\n\rSuccess: Model '$classname' created successfully.\n\r");
        } else {
            die("Failed to create Model due to an error.");
        }
    }

    /**
     * @param string $classname
     * @return void
     */
    private function createMigration(string $classname)
    {
        $folder = 'app' . DIRSEP . 'migrations' . DIRSEP;

        if (!file_exists($folder)) {
            if (!mkdir($folder, 0777, true)) {
                die("Failed to create migrations folder.");
            }
        }

        $fileName = $folder . date("jS_M_Y_H_i_s_") . ucfirst($classname) . ".php";

        if (file_exists($fileName)) {
            die("Migration file '$fileName' already exists.");
        }

        $patternFile = file_get_contents('app' . DIRSEP . 'azad' . DIRSEP . 'samples' . DIRSEP . 'migration-pattern.php');
        $patternFile = str_replace(['{CLASSNAME}', '{classname}'], [ucfirst($classname), strtolower($classname)], $patternFile);

        if (file_put_contents($fileName, $patternFile)) {
            die("\n\rSuccess: Migration file created: " . basename($fileName) . "\n\r");
        } else {
            die("Failed to create Migration file due to an error.");
        }
    }


    /**
     * @param $argv
     * @return void
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function migrate($argv)
    {
        $command = $argv[1] ?? null;
        $fileName = $argv[2] ?? null;

        $fileName = "app" . DIRSEP . "migrations" . DIRSEP . $fileName;
        if (file_exists($fileName)) {
            require $fileName;

            preg_match("/[a-zA-Z]+\.php$/", $fileName, $match);
            $classname = str_replace(".php", "", $match[0]);

            $myclass = new ("\Kamarbandi\\$classname")();

            switch ($command) {
                case 'migrate':
                    $myclass->up();
                    echo("\n\rTables created successfully\n\r");
                    break;
                case 'migrate:rollback':
                    $myclass->down();
                    echo("\n\rTables removed successfully\n\r");
                    break;
                case 'migrate:refresh':
                    $myclass->down();
                    $myclass->up();
                    echo("\n\rTables refreshed successfully\n\r");
                    break;
                default:
                    $myclass->up();
                    break;
            }
        } else {
            die("\n\rMigration file could not be found\n\r");
        }

        echo "\n\rMigration file run successfully: " . basename($fileName) . " \n\r";
    }

    public function help()
    {
        echo "

    Apo.com Group v$this->version Command Line Tool
    
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
            
        ";
    }
}