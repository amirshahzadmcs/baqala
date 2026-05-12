<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UploadImage extends CI_Controller {

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

        $this->uploadImageToDirectory('uploads/requests/repair-request-image/');
    }

    public function delete()
    {
        if (!$this->authorizeRequest()) {
            return;
        }

        $this->deleteImageFromDirectory('uploads/requests/repair-request-image/');
    }

    public function upload()
    {
        if (!$this->authorizeRequest()) {
            return;
        }

        $requestType = $this->getValidatedRequestType();
        if ($requestType === null) {
            return;
        }

        $this->uploadImageToDirectory($this->resolveUploadDirectory($requestType));
    }

    public function delete_image()
    {
        if (!$this->authorizeRequest()) {
            return;
        }

        $requestType = $this->getValidatedRequestType();
        if ($requestType === null) {
            return;
        }

        $this->deleteImageFromDirectory($this->resolveUploadDirectory($requestType));
    }

    private function uploadImageToDirectory($relativeDirectory)
    {
        if (empty($_FILES['image']['name'])) {
            echo json_encode(['success' => false, 'message' => 'No image uploaded']);
            return;
        }

        $absoluteDirectory = FCPATH . trim($relativeDirectory, '/\\') . DIRECTORY_SEPARATOR;
        if (!is_dir($absoluteDirectory)) {
            mkdir($absoluteDirectory, 0755, true);
        }

        $originalName = $_FILES['image']['name'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'pdf'], true)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type']);
            return;
        }

        $safeName = bin2hex(random_bytes(16)) . '.' . $extension;
        $absolutePath = $absoluteDirectory . $safeName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $absolutePath)) {
            $relativePath = trim($relativeDirectory, '/\\') . '/' . $safeName;
            echo json_encode([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'file_path' => base_url($relativePath),
            ]);
            return;
        }

        echo json_encode(['success' => false, 'message' => 'File upload failed']);
    }

    private function deleteImageFromDirectory($relativeDirectory)
    {
        $payload = json_decode(file_get_contents('php://input'), true);
        $filePath = $payload['file_path'] ?? $this->input->post('file_path') ?? $this->input->get('file_path');

        if (!$filePath) {
            log_message('error', 'Delete API Error: No file path received.');
            echo json_encode(['success' => false, 'message' => 'No file path received.']);
            return;
        }

        $baseUploadUrl = rtrim(base_url(trim($relativeDirectory, '/\\') . '/'), '/');
        if (strpos($filePath, $baseUploadUrl) !== 0) {
            log_message('error', 'Delete API Error: File path outside allowed upload directory.');
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
                log_message('info', 'File deleted successfully: ' . $targetPath);
                echo json_encode(['success' => true, 'message' => 'Image deleted successfully.']);
                return;
            }

            log_message('error', 'Failed to delete file: ' . $targetPath);
            echo json_encode(['success' => false, 'message' => 'Failed to delete image.']);
            return;
        }

        log_message('error', 'File not found: ' . ($targetPath ?: $fileName));
        echo json_encode(['success' => false, 'message' => 'File not found.']);
    }

    private function resolveUploadDirectory($requestType)
    {
        switch ($requestType) {
            case 'clinical':
                return 'uploads/requests/clinical-request-image/';
            case 'housing':
                return 'uploads/requests/housing-request-image/';
            default:
                return 'uploads/requests/request-image/';
        }
    }

    private function getValidatedRequestType()
    {
        $requestType = $_POST['requestType'] ?? '';
        if (!in_array($requestType, ['clinical', 'repair', 'housing'], true)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid request type']);
            return null;
        }

        return $requestType;
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
