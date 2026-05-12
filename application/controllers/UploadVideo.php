<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UploadVideo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->setCorsHeaders();
    }

    public function index()
    {
        if (!$this->authorizeRequest()) {
            return;
        }

        if (empty($_FILES['video']['name'])) {
            echo json_encode(['success' => false, 'message' => 'No video file uploaded']);
            return;
        }

        $relativeDirectory = 'uploads/requests/repair-request-video/';
        $absoluteDirectory = FCPATH . trim($relativeDirectory, '/\\') . DIRECTORY_SEPARATOR;
        if (!is_dir($absoluteDirectory)) {
            mkdir($absoluteDirectory, 0755, true);
        }

        $extension = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ['mp4', 'mov', 'avi', 'mkv', 'webm'], true)) {
            echo json_encode(['success' => false, 'message' => 'Invalid video format']);
            return;
        }

        $fileName = bin2hex(random_bytes(16)) . '.' . $extension;
        $absolutePath = $absoluteDirectory . $fileName;

        if (move_uploaded_file($_FILES['video']['tmp_name'], $absolutePath)) {
            echo json_encode([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'file_path' => base_url(trim($relativeDirectory, '/\\') . '/' . $fileName)
            ]);
            return;
        }

        echo json_encode(['success' => false, 'message' => 'File upload failed']);
    }

    public function delete()
    {
        if (!$this->authorizeRequest()) {
            return;
        }

        $payload = json_decode(file_get_contents('php://input'), true);
        $filePath = $payload['file_path'] ?? $this->input->post('file_path') ?? $this->input->get('file_path');
        if (!$filePath) {
            log_message('error', 'Delete video API Error: No file path received.');
            echo json_encode(['success' => false, 'message' => 'No file path received.']);
            return;
        }

        $relativeDirectory = 'uploads/requests/repair-request-video/';
        $baseUploadUrl = rtrim(base_url(trim($relativeDirectory, '/\\') . '/'), '/');
        if (strpos($filePath, $baseUploadUrl) !== 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid file path.']);
            return;
        }

        $fileName = basename(parse_url($filePath, PHP_URL_PATH));
        if ($fileName === '' || !preg_match('/^[A-Za-z0-9._-]+$/', $fileName)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file path.']);
            return;
        }

        $directory = realpath(FCPATH . trim($relativeDirectory, '/\\'));
        $targetPath = $directory ? realpath($directory . DIRECTORY_SEPARATOR . $fileName) : false;

        if ($directory && $targetPath && strpos($targetPath, $directory . DIRECTORY_SEPARATOR) === 0 && is_file($targetPath)) {
            if (unlink($targetPath)) {
                log_message('info', 'Video deleted successfully: ' . $targetPath);
                echo json_encode(['success' => true, 'message' => 'Video deleted successfully.']);
                return;
            }
            log_message('error', 'Failed to delete video: ' . $targetPath);
            echo json_encode(['success' => false, 'message' => 'Failed to delete video.']);
            return;
        }

        log_message('error', 'Video file not found: ' . ($targetPath ?: $fileName));
        echo json_encode(['success' => false, 'message' => 'File not found.']);
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
            echo json_encode(['success' => false, 'message' => 'External API key is not configured.']);
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
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            http_response_code(401);
            return false;
        }

        return true;
    }
}
