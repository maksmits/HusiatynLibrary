<?php
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php';
?>

<div class="hero">
    <h1>Новини та Події</h1>
    <p>
        Дізнавайтеся про культурне життя Гусятина та нові події у нашій бібліотеці.
    </p>
</div>

<div class="container">

    <div style="margin-bottom: 4rem;">
        <h2
            style="font-size: 1.75rem; color: var(--secondary); margin-bottom: 2rem; border-bottom: 2px solid var(--primary-light); padding-bottom: 0.5rem;">
            📰 Про Гусятин
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <!-- News Card 1 -->
            <div class="book-card" style="height: 100%;">
                <div
                    style="height: 200px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%); display: flex; align-items: center; justify-content: center; color: white; padding: 2rem; text-align: center;">
                    <div>
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">🏰</div>
                        <div style="font-weight: 700;">Історична Спадщина</div>
                    </div>
                </div>
                <div class="book-info">
                    <h3 class="book-title" style="margin-bottom: 1rem;">Замок та Синагога</h3>
                    <p style="color: var(--text-main); line-height: 1.6; margin-bottom: 1rem;">
                        Гусятин багатий на історичні пам'ятки. Оборонна синагога в готично-мавританському стилі,
                        збудована на початку XVII століття, та руїни замку є свідками бурхливої історії нашого краю над
                        річкою Збруч.
                    </p>
                    <div
                        style="margin-top: auto; padding-top: 1rem; border-top: 1px solid #f1f5f9; font-size: 0.85rem; color: var(--text-muted);">
                        Історична довідка
                    </div>
                </div>
            </div>

            <!-- News Card 2 -->
            <div class="book-card" style="height: 100%;">
                <div
                    style="height: 200px; background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); display: flex; align-items: center; justify-content: center; color: white; padding: 2rem; text-align: center;">
                    <div>
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">🏺</div>
                        <div style="font-weight: 700;">Краєзнавчий Музей</div>
                    </div>
                </div>
                <div class="book-info">
                    <h3 class="book-title" style="margin-bottom: 1rem;">Скарби минулого</h3>
                    <p style="color: var(--text-main); line-height: 1.6; margin-bottom: 1rem;">
                        Гусятинський краєзнавчий музей зберігає понад 16,000 експонатів. Тут ви можете побачити копію
                        знаменитого Збручанського ідола, стародавні знаряддя праці та унікальні документи, що
                        розповідають про життя наших предків.
                    </p>
                    <div
                        style="margin-top: auto; padding-top: 1rem; border-top: 1px solid #f1f5f9; font-size: 0.85rem; color: var(--text-muted);">
                        Культура
                    </div>
                </div>
            </div>

            <!-- News Card 3 -->
            <div class="book-card" style="height: 100%;">
                <div
                    style="height: 200px; background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%); display: flex; align-items: center; justify-content: center; color: white; padding: 2rem; text-align: center;">
                    <div>
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">💧</div>
                        <div style="font-weight: 700;">Курортне Місто</div>
                    </div>
                </div>
                <div class="book-info">
                    <h3 class="book-title" style="margin-bottom: 1rem;">Цілюща Вода</h3>
                    <p style="color: var(--text-main); line-height: 1.6; margin-bottom: 1rem;">
                        Чи знали ви, що Гусятин має статус курортного містечка? Наша "Новозбручанська" мінеральна вода
                        за своїми властивостями подібна до "Нафтусі" і приваблює сюди людей для оздоровлення та
                        відпочинку.
                    </p>
                    <div
                        style="margin-top: auto; padding-top: 1rem; border-top: 1px solid #f1f5f9; font-size: 0.85rem; color: var(--text-muted);">
                        Туризм
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 4rem;">
        <h2
            style="font-size: 1.75rem; color: var(--secondary); margin-bottom: 2rem; border-bottom: 2px solid var(--primary-light); padding-bottom: 0.5rem;">
            📅 Події у Бібліотеці
        </h2>

        <div
            style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-card); overflow: hidden; border: 1px solid #e2e8f0;">
            <!-- Event 1 -->
            <div
                style="display: flex; gap: 1.5rem; padding: 1.5rem; border-bottom: 1px solid #f1f5f9; align-items: center;">
                <div
                    style="background: var(--primary-light); color: var(--primary-dark); padding: 1rem; border-radius: var(--radius-md); text-align: center; min-width: 80px;">
                    <div style="font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">Грудень</div>
                    <div style="font-size: 1.75rem; font-weight: 800;">22</div>
                </div>
                <div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem; color: var(--secondary);">Літературний вечір
                        "Поезія Зими"</h3>
                    <p style="color: var(--text-muted); margin-bottom: 0;">Запрошуємо всіх шанувальників поезії на
                        затишний вечір читання віршів українських класиків та сучасників. Вхід вільний.</p>
                </div>
                <div style="margin-left: auto;">
                    <span class="badge badge-available">17:00</span>
                </div>
            </div>

            <!-- Event 2 -->
            <div
                style="display: flex; gap: 1.5rem; padding: 1.5rem; border-bottom: 1px solid #f1f5f9; align-items: center;">
                <div
                    style="background: #f1f5f9; color: var(--secondary); padding: 1rem; border-radius: var(--radius-md); text-align: center; min-width: 80px;">
                    <div style="font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">Щотижня</div>
                    <div style="font-size: 1.75rem; font-weight: 800;">СБ</div>
                </div>
                <div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem; color: var(--secondary);">Дитячий клуб
                        "Вундеркінд"</h3>
                    <p style="color: var(--text-muted); margin-bottom: 0;">Розвиваючі ігри, читання казок та
                        майстер-класи для дітей віком від 6 до 10 років. Попередній запис обов'язковий.</p>
                </div>
                <div style="margin-left: auto;">
                    <span class="badge" style="background: #e0f2fe; color: #0284c7;">11:00</span>
                </div>
            </div>

            <!-- Event 3 -->
            <div style="display: flex; gap: 1.5rem; padding: 1.5rem; align-items: center;">
                <div
                    style="background: var(--primary-light); color: var(--primary-dark); padding: 1rem; border-radius: var(--radius-md); text-align: center; min-width: 80px;">
                    <div style="font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">Січень</div>
                    <div style="font-size: 1.75rem; font-weight: 800;">05</div>
                </div>
                <div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem; color: var(--secondary);">Виставка нових
                        надходжень</h3>
                    <p style="color: var(--text-muted); margin-bottom: 0;">Презентація нових книг, закуплених для
                        бібліотеки у цьому році. Можливість першими забронювати новинки.</p>
                </div>
                <div style="margin-left: auto;">
                    <span class="badge badge-available">10:00</span>
                </div>
            </div>
        </div>
    </div>

</div>

</body>

</html>