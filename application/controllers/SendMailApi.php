<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SendMailApi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->setCorsHeaders();

        $this->load->helper('sendmail_helper');
        $this->load->helper('request_helper');
        $this->load->library('user_agent');
        $this->ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
        $this->datetime = date("Y-m-d H:i:s");
    }

    public function test_email() {
        if (ENVIRONMENT !== 'development') {
            show_404();
        }

        $receiver = defined('DISPUTE_TO_EMAIL') && DISPUTE_TO_EMAIL !== '' ? DISPUTE_TO_EMAIL : null;
        if (!$receiver) {
            echo json_encode([
                'success' => false,
                'message' => 'Test receiver email is not configured.',
            ]);
            return;
        }

        $testData = [
            'email' => $receiver,
            'request_type' => 'ClinicalVisitRequest'
        ];

        $response = send_booking_confirmation_mail($testData);
        echo json_encode($response);
    }

    public function send_confirmation_email() {
        if (!$this->authorizeRequest()) {
            return;
        }

        header('Content-Type: application/json');

        $postData = json_decode(file_get_contents('php://input'), true);
        log_message('info', 'Received API request: ' . json_encode($postData));

        if (!isset($postData['email']) || !isset($postData['request_type'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid request data']);
            return;
        }

        $response = send_booking_confirmation_mail($postData);
        log_message('info', 'Email function response: ' . json_encode($response));
        echo json_encode($response);
    }

    private function setCorsHeaders()
    {
        $allowedOrigin = defined('EXTERNAL_API_ALLOWED_ORIGIN') ? trim((string) EXTERNAL_API_ALLOWED_ORIGIN) : '';
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        if ($allowedOrigin !== '' && $origin !== '' && rtrim($origin, '/') === rtrim($allowedOrigin, '/')) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Vary: Origin');
        }

        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-API-KEY");

        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            exit;
        }
    }

    private function authorizeRequest()
    {
        $configuredKey = defined('EXTERNAL_API_KEY') ? (string) EXTERNAL_API_KEY : '';
        if ($configuredKey === '') {
            echo json_encode([
                'success' => false,
                'message' => 'External API key is not configured.',
            ]);
            http_response_code(503);
            return false;
        }

        $headers = function_exists('getallheaders') ? getallheaders() : [];
        $receivedKey = $headers['X-API-KEY']
            ?? $headers['x-api-key']
            ?? $headers['X-Api-Key']
            ?? $headers['x-Api-Key']
            ?? '';

        if (!hash_equals($configuredKey, $receivedKey)) {
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized',
            ]);
            http_response_code(401);
            return false;
        }

        return true;
    }
}
