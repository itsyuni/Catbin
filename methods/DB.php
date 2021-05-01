<?php
class DB {

        private static function connect() {
                $pdo = new PDO('mysql:host=localhost;dbname=mohooks_catbin;charset=utf8', 'mohooks_user', 'mohookscatbin');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
        }

        public static function query($query, $params = array()) {
                $statement = self::connect()->prepare($query);
                $statement->execute($params);

                if (explode(' ', $query)[0] == 'SELECT') {
                $data = $statement->fetchAll();
                return $data;
                }
        }

}
