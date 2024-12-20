<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileUpload'])) {
    $file = $_FILES['fileUpload'];
    $filename = basename($file['name']);
    $filepath = $file['tmp_name'];
    $filedata = file_get_contents($filepath);
    $base64data = base64_encode($filedata);

    // GitHub API thông tin
    $owner = 'shin0pro'; // Thay thế bằng tên đăng nhập GitHub của bạn
    $repo = 'uptodown'; // Thay thế bằng tên repository của bạn
    $path = 'uploads/' . $filename; // Đường dẫn nơi lưu tệp trong repository
    $message = 'Upload image ' . $filename;
    $token = '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'; // Thay thế bằng token truy cập cá nhân của bạn

    // Tạo dữ liệu yêu cầu
    $data = json_encode([
        'message' => $message,
        'committer' => [
            'name' => 'Your Name',
            'email' => 'your-email@example.com'
        ],
        'content' => $base64data
    ]);

    // Gửi yêu cầu tới GitHub API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/$owner/$repo/contents/$path");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $token,
        'User-Agent: PHP'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Kiểm tra mã phản hồi HTTP từ GitHub API
    if ($http_code == 201) {
        echo "Tệp " . htmlspecialchars($filename) . " đã được tải lên thành công.";
    } else {
        echo "Đã xảy ra lỗi khi tải lên tệp.";
        echo "<pre>$response</pre>";
    }
}
?>
