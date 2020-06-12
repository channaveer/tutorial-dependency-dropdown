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
        /** Code to fetch list of states by state_id */
        $stateId = isset($_POST['state_id']) ? $_POST['state_id'] : '';
        if (empty($stateId)) {
            throw new Exception('State field required');
        }
        $stateStmt = $pdo->prepare("SELECT `id`, `name` FROM `states` WHERE `id` = :state_id");
        $stateStmt->execute([':state_id' => $stateId]);
        $state = $stateStmt->fetchObject();
        if (!$state) {
            throw new Exception('State not found');
        }
        $cityStmt = $pdo->prepare("SELECT `id`, `name` FROM `cities` WHERE `state_id` = :state_id");
        $cityStmt->execute([':state_id' => $stateId]);
        $cities = $cityStmt->fetchAll(PDO::FETCH_OBJ);

        http_response_code(200);
        echo json_encode([
            'status'    => 'success',
            'message'   => 'Successfully fetch details',
            'data'      => [
                'state'     => $state,
                'cities'    => $cities
            ]
        ]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'status'    => 'error',
            'message'   => 'Error in fetching state details',
            'error'    => $e->getMessage()
        ]);
    }
}
/** If GET request to the API then return 405 (Method Not Supported) status code */
http_response_code(405);
echo json_encode([
    'status'    => 'error',
    'message'   => 'Method not supported',
]);
exit;
