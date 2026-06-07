<?php 
include 'db.php'; 

// ЗАЩИТА СТРАНИЦЫ: Если не админ — мгновенно перенаправляем на главную
if (!isset($_SESSION['user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления — JaGGeR Store</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="images/icons/logo.png">
</head>
<body class="min-h-screen flex flex-col bg-background text-foreground">

    <!-- НАВИГАЦИОННАЯ ШАПКА -->
    <header class="header-sticky-wrapper">
        <div class="header-container">
            <a href="index.php" class="header-logo">
                <img src="images/icons/logo.png" alt="JaGGeR Store" class="icon-logo">
                <span class="logo-text">JaGGeR Store</span>
            </a>
            <nav class="header-menu">
                <a href="index.php">Главная</a>
                <a href="index.php#catalog">Каталог</a>
                <a href="index.php#promo">Акции</a>
                <a href="#footer">О нас</a>
            </nav>
            <div class="header-actions">
                <a href="cart.php" class="cart-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon-cart-svg">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                        <path d="M3 6h18"></path>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <span id="cartCount" class="cart-badge">0</span>
                </a>
                <span class="welcome-text">
                    <strong>
                        <a href="admin.php" class="admin-username-clickable"><?php echo htmlspecialchars($_SESSION['user']); ?></a>
                    </strong>
                </span>
                <button class="btn-logout" onclick="logout()">Выйти</button>
            </div>
        </div>
    </header>

    <!-- СЕКЦИЯ АДМИНИСТРИРОВАНИЯ -->
    <main class="flex-grow container py-12" style="max-width: 900px;">
        <h1 class="title-accent" style="text-align: left; margin-bottom: 40px;">Панель управления</h1>
        
        <div class="admin-grid-layout" style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 40px; align-items: start;">
            
            <!-- Блок 1: Добавление товара -->
            <div class="admin-panel-card" style="background-color: var(--card); border: 1px solid var(--border); padding: 35px; border-radius: 1.5rem;">
                <h3 class="text-xl font-bold text-white" style="margin-bottom: 20px;">Добавить новый товар</h3>
                <form onsubmit="addProduct(event)" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="checkout-label">Название товара</label>
                        <input type="text" name="name" class="input-dark" placeholder="Например: Футболка 'Когда? Завтра'" required>
                    </div>
                    
                    <!-- Описание с переносами строк -->
                    <div class="form-group">
                        <label class="checkout-label">Описание товара</label>
                        <textarea name="description" class="input-dark" rows="5" placeholder="Материал: 2х нитка пенье...&#10;Состав: 95% хлопок...&#10;Печать: Шелкография..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="checkout-label">Цена (в рублях)</label>
                        <input type="number" name="price" class="input-dark" placeholder="Цена без знака рубля" required>
                    </div>
                    <div class="form-group">
                        <label class="checkout-label">Старая цена (необязательно)</label>
                        <input type="number" name="old_price" class="input-dark" placeholder="Для отображения скидки">
                    </div>
                    <div class="form-group">
                        <label class="checkout-label">Скидка в % (необязательно)</label>
                        <input type="number" name="discount" class="input-dark" placeholder="Например: 55">
                    </div>
                    <div class="form-group">
                        <label class="checkout-label">Ярлык (необязательно)</label>
                        <input type="text" name="tag" class="input-dark" placeholder="Например: Новинка">
                    </div>

                    <!-- Выбор размеров и количества -->
                    <div class="form-group">
                        <label class="checkout-label">Размеры и остатки на складе</label>
                        <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 10px;">
                            <!-- Размер S -->
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <input type="checkbox" name="sizes[]" value="S" id="size_s" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <label for="size_s" style="width: 30px; font-weight: bold; color: #fff; cursor: pointer; font-size: 14px;">S</label>
                                <input type="number" name="stock_S" class="input-dark" style="margin-bottom:0 !important; max-width: 120px; padding: 8px 12px !important;" placeholder="Кол-во" value="10">
                            </div>
                            <!-- Размер M -->
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <input type="checkbox" name="sizes[]" value="M" id="size_m" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <label for="size_m" style="width: 30px; font-weight: bold; color: #fff; cursor: pointer; font-size: 14px;">M</label>
                                <input type="number" name="stock_M" class="input-dark" style="margin-bottom:0 !important; max-width: 120px; padding: 8px 12px !important;" placeholder="Кол-во" value="10">
                            </div>
                            <!-- Размер L -->
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <input type="checkbox" name="sizes[]" value="L" id="size_l" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <label for="size_l" style="width: 30px; font-weight: bold; color: #fff; cursor: pointer; font-size: 14px;">L</label>
                                <input type="number" name="stock_L" class="input-dark" style="margin-bottom:0 !important; max-width: 120px; padding: 8px 12px !important;" placeholder="Кол-во" value="10">
                            </div>
                            <!-- Размер XL -->
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <input type="checkbox" name="sizes[]" value="XL" id="size_xl" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <label for="size_xl" style="width: 30px; font-weight: bold; color: #fff; cursor: pointer; font-size: 14px;">XL</label>
                                <input type="number" name="stock_XL" class="input-dark" style="margin-bottom:0 !important; max-width: 120px; padding: 8px 12px !important;" placeholder="Кол-во" value="10">
                            </div>
                        </div>
                    </div>

                    <!-- Динамический блок загрузки любого количества изображений -->
                    <div class="form-group">
                        <label class="checkout-label">Изображения товара (в порядке показа)</label>
                        
                        <!-- Сюда JS будет добавлять новые поля выбора файлов -->
                        <div id="imagesUploadContainer" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 15px;">
                            <div class="image-input-item">
                                <input type="file" name="product_images[]" class="input-dark" accept="image/*" required style="padding: 8px 12px !important; margin-bottom: 5px !important;">
                                <p style="font-size: 11px; color: var(--muted-foreground);">* Основное фото (обложка на витрине каталога)</p>
                            </div>
                        </div>
                        
                        <!-- Кнопка динамического добавления новых инпутов -->
                        <button type="button" class="btn btn-secondary" onclick="addNewImageField()" style="height: 38px; border-radius: 8px; font-size: 13px; font-weight: 600; padding: 0 20px;">Добавить фото</button>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full checkout-submit-btn" style="margin-top: 15px;">Создать карточку товара</button>
                </form>
            </div>

            <!-- Блок 2: Блокировка -->
            <div class="admin-panel-card" style="background-color: var(--card); border: 1px solid var(--border); padding: 35px; border-radius: 1.5rem;">
                <h3 class="text-xl font-bold text-white" style="margin-bottom: 20px;">Ограничение доступа</h3>
                <p style="font-size: 14px; color: var(--muted-foreground); margin-bottom: 20px; line-height: 1.6;">Введите логин, почту или номер телефона пользователя, чтобы заблокировать его профиль в базе данных. Заблокированный пользователь больше не сможет авторизоваться в системе.</p>
                
                <div class="form-group">
                    <label class="checkout-label">Логин/почта/номер пользователя</label>
                    <input type="text" id="blockUsername" class="input-dark" placeholder="Введите логин/почту/номер пользователя" required>
                </div>
                <button class="btn btn-danger w-full" onclick="blockUser()" style="height: 46px; border-radius: 12px; font-weight: 700; margin-top: 15px;">Заблокировать доступ</button>
            </div>
        </div>
    </main>

    <!-- ПОДВАЛ -->
    <footer class="footer-dark" id="footer">
        <div class="container footer-grid">
            <div class="footer-col brand-col">
                <a href="index.php" class="footer-brand-logo">
                    <img src="images/icons/logo.png" alt="JaGGeR Store" class="icon-logo size-8">
                    <span class="logo-brand-text">JaGGeR Store</span>
                </a>
                <div class="footer-social-icons">
                    <a href="https://t.me/joper5" target="_blank" class="social-svg-btn">
                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_25_286)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M34 17C34 26.3888 26.3888 34 17 34C7.61116 34 0 26.3888 0 17C0 7.61116 7.61116 0 17 0C26.3888 0 34 7.61116 34 17ZM17.6092 12.5501C15.9557 13.2379 12.651 14.6614 7.69518 16.8205C6.89043 17.1406 6.46886 17.4536 6.43049 17.7598C6.36563 18.2771 7.01351 18.4808 7.89575 18.7583C8.01576 18.796 8.1401 18.8351 8.26758 18.8765C9.13557 19.1587 10.3032 19.4888 10.9102 19.5019C11.4608 19.5138 12.0753 19.2868 12.7537 18.8209C17.3841 15.6953 19.7744 14.1154 19.9244 14.0813C20.0303 14.0573 20.177 14.0271 20.2764 14.1154C20.3758 14.2038 20.366 14.3711 20.3555 14.416C20.2913 14.6896 17.7482 17.054 16.4321 18.2775C16.0218 18.659 15.7308 18.9295 15.6713 18.9913C15.538 19.1297 15.4022 19.2607 15.2716 19.3865C14.4653 20.1639 13.8605 20.7468 15.3051 21.6988C15.9993 22.1563 16.5548 22.5346 17.109 22.912C17.7143 23.3241 18.3179 23.7352 19.099 24.2472C19.2979 24.3776 19.488 24.5131 19.6731 24.6451C20.3774 25.1472 21.0102 25.5983 21.792 25.5264C22.2463 25.4846 22.7155 25.0574 22.9538 23.7835C23.517 20.7728 24.624 14.2495 24.8798 11.5614C24.9022 11.3259 24.874 11.0245 24.8514 10.8921C24.8287 10.7598 24.7814 10.5713 24.6094 10.4318C24.4058 10.2665 24.0913 10.2316 23.9507 10.2341C23.3113 10.2454 22.3303 10.5865 17.6092 12.5501Z" fill="white"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_25_286">
                                    <rect width="34" height="34" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                    <a href="https://vk.com/5opka" target="_blank" class="social-svg-btn">
                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.39001 2.39001C0 4.78002 0 8.62665 0 16.32V17.68C0 25.3734 0 29.22 2.39001 31.61C4.78002 34 8.62665 34 16.32 34H17.68C25.3734 34 29.22 34 31.61 31.61C34 29.22 34 25.3734 34 17.68V16.32C34 8.62665 34 4.78002 31.61 2.39001C29.22 0 25.3734 0 17.68 0H16.32C8.62665 0 4.78002 0 2.39001 2.39001ZM5.73759 10.3417C5.92175 19.1817 10.3417 24.4942 18.0909 24.4942H18.5301V19.4367C21.3776 19.7201 23.5308 21.8026 24.395 24.4942H28.4184C27.3134 20.4709 24.4091 18.2467 22.5958 17.3967C24.4091 16.3484 26.9591 13.7984 27.5683 10.3417H23.9132C23.1199 13.1467 20.7685 15.6967 18.5301 15.9376V10.3417H14.875V20.1451C12.6083 19.5784 9.74674 16.8301 9.61924 10.3417H5.73759Z" fill="white"/>
                        </svg>
                    </a>
                </div>
                <div class="footer-copyright">Copyright &copy; 2026</div>
            </div>

            <!-- Средняя колонка: Документы (с левой разделительной линией) -->
            <div class="footer-col docs-col border-left-col">
                <h4 class="footer-col-title">Документы</h4>
                <ul class="footer-col-links">
                    <li><a href="dogovor.php">Договор-оферта</a></li>
                    <li><a href="privacy.php">Политика в отношении обработки персональных данных</a></li>
                    <li><a href="returns.php">Политика возвратов, условия доставки</a></li>
                </ul>
            </div>

            <!-- Правая колонка: Поддержка и Рассылка (с левой разделительной линией) -->
            <div class="footer-col support-col border-left-col">
                <h4 class="footer-col-title">Поддержка</h4>
                <ul class="footer-col-links">
                    <li><a href="faq.php">Ответы на вопросы</a></li>
                    <li><a href="#" onclick="copySupportEmail(event, 'support@jaggerstore.ru')">support@jaggerstore.ru</a></li>
                </ul>
                <div class="footer-subscribe-area">
                    <p class="subscribe-text">Подпишитесь на рассылку:</p>
                    <form class="footer-newsletter-form" onsubmit="event.preventDefault(); showToastNotification('Вы успешно подписались на рассылку!');">
                        <input type="email" placeholder="Ваш email" required class="input-dark">
                        <button type="submit" class="btn btn-primary">Ok</button>
                    </form>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Передаем статус авторизации сессии в JS
        const isUserAuthorized = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
        // Если это страница товара, тут также остаётся строчка: const currentProductData = ...
    </script>
    <script src="script.js?v=<?php echo time(); ?>"></script>
</body>
</html>