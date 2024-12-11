<?php
if (isset($_POST['submit'])) {
    // Đường dẫn đến thư mục lưu trữ tệp tải lên
    $targetDir = __DIR__ . "/uploads/";  // Sử dụng __DIR__ để chỉ thư mục hiện tại

    // Kiểm tra và tạo thư mục nếu chưa tồn tại
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Đường dẫn đầy đủ của tệp tải lên
    $targetFile = $targetDir . basename($_FILES["fileUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Kiểm tra loại tệp (ví dụ: chấp nhận JPG, PNG, PDF)
    $allowedTypes = ["jpg", "png", "pdf"];
    if (!in_array($fileType, $allowedTypes)) {
        echo "Chỉ cho phép các định dạng JPG, PNG, PDF.";
        $uploadOk = 0;
    }

    // Kiểm tra nếu tệp đã tồn tại
    if (file_exists($targetFile)) {
        echo "Tệp đã tồn tại.";
        $uploadOk = 0;
    }

    // Giới hạn kích thước tệp (tối đa 500MB)
    if ($_FILES["fileUpload"]["size"] > 500000000) {
        echo "Dung lượng tệp vượt quá giới hạn cho phép (500MB).";
        $uploadOk = 0;
    }

    // Tiến hành tải lên nếu không có lỗi
    if ($uploadOk) {
        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $targetFile)) {
            echo "Đã tải xong";
        } else {
            echo "Có lỗi xảy ra khi tải lên tệp.";
        }
    } else {
        echo "Tệp không thể tải lên.";
    }
}
?>
