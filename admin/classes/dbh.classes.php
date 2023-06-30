<?php
class Dbh {
    protected function connect() {
        try {
            // hosted
            $db_host = getenv('DB_HOST');
            $db_name = getenv('DB_NAME');
            $db_user = getenv('DB_USER');
            $db_pass = getenv('DB_PASS');

            // connect
            $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            return $dbh;
        }
        catch(PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br>";
            die();
        }
    }
}