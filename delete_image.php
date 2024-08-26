<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image_path_1 = isset($_POST['image1']) ? $_POST['image1'] : '';
    $image_path_2 = isset($_POST['image2']) ? $_POST['image2'] : '';

    $result = ['status' => 'error', 'message' => ''];

    if (!empty($image_path_1) && file_exists($image_path_1)) {
        if (unlink($image_path_1)) {
            $result['message'] .= "Successfully deleted: $image_path_1\n";
        } else {
            $result['message'] .= "Failed to delete: $image_path_1\n";
        }
    } else {
        $result['message'] .= "File not found or path is empty: $image_path_1\n";
    }

    if (!empty($image_path_2) && file_exists($image_path_2)) {
        if (unlink($image_path_2)) {
            $result['message'] .= "Successfully deleted: $image_path_2\n";
        } else {
            $result['message'] .= "Failed to delete: $image_path_2\n";
        }
    } else {
        $result['message'] .= "File not found or path is empty: $image_path_2\n";
    }

    if (strpos($result['message'], 'Failed') === false) {
        $result['status'] = 'success';
    }

    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests are allowed.']);
}
?>
