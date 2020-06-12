<?php
require_once 'db.php';

class Country
{
    public function getAllCountries()
    {
        global $pdo;
        $countryStmt = $pdo->prepare("SELECT `id`, `name` FROM `countries`");
        $countryStmt->execute();
        $countries = $countryStmt->fetchAll(PDO::FETCH_OBJ);
        return $countries;
    }
}
