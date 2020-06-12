<?php
require_once '../db.php';

/** Required if not added then you may get CORS error in AJAX  */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

/** Necessary to let the other applications and software to know that your returning JSON data */
header('Content-Type: application/json; charset=UTF-8');

/** Only allow if POST request */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /** If you have any TOKEN or user validation you can do it here */
    try {
        /** Country validation */
        $countryId = isset($_POST['country_id']) ? $_POST['country_id'] : '';
        if (empty($countryId)) {
            throw new Exception('Country field required');
        }

        /** Validate if country exists */
        $countryStmt = $pdo->prepare("SELECT `id`, `name` FROM `countries` WHERE `id` = :country_id");
        $countryStmt->execute([':country_id' => $countryId]);
        $country = $countryStmt->fetchObject();
        if (!$country) {
            throw new Exception('Country not found');
        }

        /** Code to fetch list of states by country_id */
        $stateStmt = $pdo->prepare("SELECT `id`, `name` FROM `states` WHERE `country_id` = :country_id");
        $stateStmt->execute([':country_id' => $countryId]);
        $states = $stateStmt->fetchAll(PDO::FETCH_OBJ);

        /** Return 200 status code with other json data */
        http_response_code(200);
        echo json_encode([
            'status'    => 'success',
            'message'   => 'Successfully fetch details',
            'data'      => [
                'country'   => $country,
                'states'     => $states
            ]
        ]);
        exit;
    } catch (Exception $e) {
        /** Return 400 status code if any error thrown */
        http_response_code(400);
        echo json_encode([
            'status'    => 'error',
            'message'   => 'Error in fetching state details',
            'error'    => $e->getMessage()
        ]);
        exit;
    }
}

/** If GET request to the API then return 405 (Method Not Supported) status code */
http_response_code(405);
echo json_encode([
    'status'    => 'error',
    'message'   => 'Method not supported',
]);
exit;
