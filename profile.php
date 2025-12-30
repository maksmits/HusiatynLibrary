<?php
require_once 'db.php';
require_once 'functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT r.*, b.title, b.author 
    FROM reservations r 
    JOIN books b ON r.book_id = b.id 
    WHERE r.user_id = ? 
    ORDER BY r.reservation_date DESC
");
$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll();

require_once 'header.php';
?>

<div class="container" style="padding-top: 2rem; padding-bottom: 2rem;">
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <h1 style="font-size: 2rem; margin: 0; color: var(--secondary);">Мій профіль</h1>
    </div>

    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <!-- User Info Card -->
        <div
            style="background: white; padding: 1.5rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-card); border: 1px solid #e2e8f0;">
            <div
                style="font-size: 0.875rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem;">
                Користувач</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-dark);">
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </div>
        </div>

        <!-- Total Reservations Card -->
        <div
            style="background: white; padding: 1.5rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-card); border: 1px solid #e2e8f0;">
            <div
                style="font-size: 0.875rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem;">
                Всього бронювань</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-main);">
                <?php echo count($reservations); ?>
            </div>
        </div>
    </div>

    <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem; color: var(--secondary);">Історія бронювань</h2>

    <?php if (empty($reservations)): ?>
        <div
            style="background: white; padding: 3rem; text-align: center; border-radius: var(--radius-lg); border: 1px dashed #cbd5e1;">
            <p style="color: var(--text-muted); font-size: 1.1rem;">У вас поки немає активних бронювань.</p>
            <a href="index.php" class="btn btn-primary" style="margin-top: 1rem;">Перейти до каталогу</a>
        </div>
    <?php else: ?>
        <div
            style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-card); overflow: hidden; border: 1px solid #e2e8f0;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th
                            style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">
                            Книга</th>
                        <th
                            style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">
                            Автор</th>
                        <th
                            style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">
                            Дата</th>
                        <th
                            style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">
                            Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $res): ?>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 1rem 1.5rem; font-weight: 600; color: var(--primary-dark);">
                                <?php echo htmlspecialchars($res['title']); ?>
                            </td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">
                                <?php echo htmlspecialchars($res['author']); ?>
                            </td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-main);">
                                <?php echo date('d.m.Y', strtotime($res['reservation_date'])); ?>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <?php
                                $status_bg = [
                                    'pending' => '#fef3c7',
                                    'approved' => '#dcfce7',
                                    'returned' => '#f1f5f9',
                                    'rejected' => '#fee2e2'
                                ];
                                $status_color = [
                                    'pending' => '#92400e',
                                    'approved' => '#166534',
                                    'returned' => '#475569',
                                    'rejected' => '#991b1b'
                                ];
                                $bg = $status_bg[$res['status']] ?? '#f1f5f9';
                                $col = $status_color[$res['status']] ?? '#475569';
                                ?>
                                <span
                                    style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; background: <?php echo $bg; ?>; color: <?php echo $col; ?>;">
                                    <?php echo ucfirst($res['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>

</html>