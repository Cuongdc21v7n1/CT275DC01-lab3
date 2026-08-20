<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\Contact;

$contact = new Contact($PDO);

// Lấy ID từ thanh địa chỉ URL
$id = isset($_REQUEST['id']) ? filter_var($_REQUEST['id'], FILTER_VALIDATE_INT) : false;

// Nếu không có ID hoặc không tìm thấy liên hệ thì quay về trang chủ
if (!$id || !($contact->find($id))) {
    redirect('/');
}

// Nếu người dùng bấm nút "Xác nhận xóa" (gửi form dạng POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact->delete();
    redirect('/');
}

include_once __DIR__ . '/../src/partials/header.php';
?>

<!-- Giao diện trang xác nhận xóa -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <strong>Cảnh báo xóa liên hệ</strong>
                </div>
                <div class="card-body">
                    <p>Bạn có chắc chắn muốn xóa liên hệ <strong><?= html_escape($contact->name) ?></strong> không?</p>
                    
                    <form method="POST" action="<?= 'delete.php?id=' . $contact->id ?>">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Xác nhận xóa
                        </button>
                        <a href="/" class="btn btn-secondary">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../src/partials/footer.php'; ?>