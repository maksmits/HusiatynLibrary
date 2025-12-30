<?php
require_once 'db.php';
require_once 'functions.php';

if (!isLoggedIn() || !isLibrarian()) {
    redirect('index.php');
}

// Handle Status Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'], $_POST['status'])) {
    $res_id = $_POST['reservation_id'];
    $status = $_POST['status'];

    // Start transaction
    $pdo->beginTransaction();

    try {
        $stmt = $pdo->prepare("UPDATE reservations SET status = ? WHERE id = ?");
        $stmt->execute([$status, $res_id]);

        // If approved, decrease stock? Logic implies stock management
        // Simple logic: if approved, treat as 'out'. If returned, treat as 'back in'.
        // However, 'approved' usually means user can pick it up. Let's simplify:
        // 'approved' -> book is reserved for user.
        // 'returned' -> book is back.

        // Retrieve book_id
        $stmt = $pdo->prepare("SELECT book_id FROM reservations WHERE id = ?");
        $stmt->execute([$res_id]);
        $book_id = $stmt->fetchColumn();

        if ($status === 'approved') {
            $pdo->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ?")->execute([$book_id]);
        } elseif ($status === 'returned') {
            $pdo->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ?")->execute([$book_id]);
            // Also set return date
            $pdo->prepare("UPDATE reservations SET return_date = NOW() WHERE id = ?")->execute([$res_id]);
        }

        $pdo->commit();
        flash('msg', "Статус оновлено: $status");

    } catch (Exception $e) {
        $pdo->rollBack();
        flash('msg', "Помилка оновлення статусу", "error");
    }

    // Refresh to avoid form resubmission styling issues
    redirect('admin_dashboard.php');
}

// Fetch reservations
$stmt = $pdo->query("
    SELECT r.*, b.title as book_title, u.username, u.email 
    FROM reservations r 
    JOIN books b ON r.book_id = b.id 
    JOIN users u ON r.user_id = u.id 
    ORDER BY r.reservation_date DESC
");
$reservations = $stmt->fetchAll();

require_once 'header.php';
?>

<div class="container" style="padding: 2rem 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Панель керування бібліотекаря</h1>
        <a href="add_book.php" class="btn btn-primary">➕ Додати нову книгу</a>
    </div>

    <?php flash('msg'); ?>

    <div
        style="background: var(--surface); border-radius: 0.5rem; box-shadow: var(--shadow); overflow: hidden; border: 1px solid var(--border);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f1f5f9; text-align: left;">
                    <th style="padding: 1rem; border-bottom: 1px solid var(--border);">ID</th>
                    <th style="padding: 1rem; border-bottom: 1px solid var(--border);">Користувач</th>
                    <th style="padding: 1rem; border-bottom: 1px solid var(--border);">Книга</th>
                    <th style="padding: 1rem; border-bottom: 1px solid var(--border);">Дата запиту</th>
                    <th style="padding: 1rem; border-bottom: 1px solid var(--border);">Статус</th>
                    <th style="padding: 1rem; border-bottom: 1px solid var(--border);">Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $res): ?>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 1rem;">#<?php echo $res['id']; ?></td>
                        <td style="padding: 1rem;">
                            <?php echo htmlspecialchars($res['username']); ?><br>
                            <span
                                style="font-size: 0.8rem; color: var(--text-light);"><?php echo htmlspecialchars($res['email']); ?></span>
                        </td>
                        <td style="padding: 1rem;"><?php echo htmlspecialchars($res['book_title']); ?></td>
                        <td style="padding: 1rem;"><?php echo $res['reservation_date']; ?></td>
                        <td style="padding: 1rem;">
                            <?php
                            $status_colors = [
                                'pending' => 'background: #fef08a; color: #854d0e;',
                                'approved' => 'background: #dcfce7; color: #166534;',
                                'returned' => 'background: #e2e8f0; color: #475569;',
                                'rejected' => 'background: #fee2e2; color: #991b1b;'
                            ];
                            $style = $status_colors[$res['status']] ?? '';
                            ?>
                            <span
                                style="padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.875rem; font-weight: 500; <?php echo $style; ?>">
                                <?php echo ucfirst($res['status']); ?>
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <?php if ($res['status'] === 'pending'): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="reservation_id" value="<?php echo $res['id']; ?>">
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-primary"
                                        style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Підтвердити</button>
                                </form>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="reservation_id" value="<?php echo $res['id']; ?>">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-outline"
                                        style="padding: 0.25rem 0.5rem; font-size: 0.8rem; border: 1px solid #fee2e2; color: #991b1b;">Відхилити</button>
                                </form>
                            <?php elseif ($res['status'] === 'approved'): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="reservation_id" value="<?php echo $res['id']; ?>">
                                    <input type="hidden" name="status" value="returned">
                                    <button type="submit" class="btn btn-outline"
                                        style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Повернути</button>
                                </form>
                            <?php else: ?>
                                <span style="color: var(--text-light);">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>

</html>