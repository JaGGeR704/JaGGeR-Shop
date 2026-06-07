<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="ru" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина | JaGGeR Shop</title>
    <link rel="icon" type="image/png" href="images/icons/logo.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen flex flex-col bg-background text-foreground">

    <!-- НАВИГАЦИОННАЯ ШАПКА -->
    <header class="header-sticky-wrapper">
        <div class="header-container">
            <a href="index.php" class="header-logo">
                <img src="images/icons/logo.png" alt="JaGGeR Shop" class="icon-logo">
                <span class="logo-text">JaGGeR Shop</span>
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
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="welcome-text">
                        <strong>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <!-- Прямой и безопасный переход на защищенную страницу -->
                                <a href="admin.php" class="admin-username-clickable"><?php echo htmlspecialchars($_SESSION['user']); ?></a>
                            <?php else: ?>
                                <?php echo htmlspecialchars($_SESSION['user']); ?>
                            <?php endif; ?>
                        </strong>
                    </span>
                    <button class="btn-logout" onclick="logout()">Выйти</button>
                <?php else: ?>
                    <button class="btn-login" onclick="openAuthModal()">Войти</button>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="flex-grow container py-12">
        <h1 class="title-accent">Корзина</h1>
        <div class="cart-page-wrapper">
            <div id="cartPageList" class="cart-page-list"></div>
            <div class="cart-page-summary">
                <div class="summary-left">
                    <span>Итого: <strong id="cartPageTotal">0 ₽</strong></span>
                </div>
                <div class="summary-right">
                    <button class="btn btn-primary checkout-action-btn" onclick="openCheckoutModal()">Оформить заказ</button>
                </div>
            </div>
        </div>
    </main>

    <!-- УЛУЧШЕННОЕ МОДАЛЬНОЕ ОКНО ОФОРМЛЕНИЯ ЗАКАЗА -->
    <div class="modal" id="checkoutModal">
        <div class="modal-content checkout-card">
            <!-- Векторный белый крестик для закрытия -->
            <span class="close-btn" onclick="closeCheckoutModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#a1a1aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </span>
            
            <h2 class="checkout-title">Оформление заказа</h2>
            <form onsubmit="confirmCheckout(event)">
                <div class="form-group">
                    <label class="checkout-label">Ближайший пункт СДЭК</label>
                    <input type="text" id="checkoutAddress" class="input-dark checkout-input" required placeholder="г. Омск, ул. Ленина, д. 24...">
                </div>
                
                <div class="form-group">
                    <label class="checkout-label">Способ оплаты</label>
                    <div class="select-wrapper">
                        <select id="checkoutPayment" class="input-dark checkout-select">
                            <option value="card">Банковский картой</option>
                            <option value="cash">СБП</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-full checkout-submit-btn">Подтвердить заказ</button>
            </form>
        </div>
    </div>

    <!-- МОДАЛЬНОЕ ОКНО АВТОРИЗАЦИИ С РАЗДЕЛЕННЫМИ ПОЛЯМИ -->
    <div class="modal" id="authModal">
        <div class="modal-content auth-card">
            <span class="close-btn" onclick="closeAuthModal()">&times;</span>
            <div class="auth-pill-container">
                <button class="auth-tab active" id="tabLogin" onclick="switchAuthMode('login')">Вход</button>
                <button class="auth-tab" id="tabRegister" onclick="switchAuthMode('register')">Регистрация</button>
            </div>
            <form id="authForm" onsubmit="handleAuth(event)">
                <input type="hidden" id="authAction" value="login">
                
                <!-- Поле Идентификатора (Логин/Почта/Телефон для входа, Логин для регистрации) -->
                <div class="form-group" id="loginIdentifierGroup">
                    <label id="identifierLabel">Логин, Телефон или E-mail</label>
                    <input type="text" id="authIdentifier" class="input-dark" required placeholder="Введите логин, телефон или email">
                </div>

                <!-- Поле Контакта (Показывается только для регистрации) -->
                <div class="form-group" id="registerContactGroup" style="display: none;">
                    <label>Телефон или E-mail</label>
                    <input type="text" id="authContact" class="input-dark" placeholder="Введите ваш телефон или email">
                </div>

                <!-- Поле пароля -->
                <div class="form-group" style="position: relative;">
                    <label>Пароль</label>
                    <div style="position: relative; display: flex; align-items: center;">
                        <input type="password" id="authPassword" class="input-dark" required style="padding-right: 45px !important; margin-bottom: 0 !important;" placeholder="••••••••">
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#a1a1aa" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="icon-eye-svg" id="eyeIcon">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-full auth-submit-btn" id="authBtn">Войти</button>
            </form>
        </div>
    </div>

    <!-- ПОДВАЛ -->
    <footer class="footer-dark" id="footer">
        <div class="container footer-grid">
            <div class="footer-col brand-col">
                <!-- Обернуто в ссылку для быстрого перехода на главную -->
                <a href="index.php" class="footer-brand-logo">
                    <img src="images/icons/logo.png" alt="JaGGeR Shop" class="icon-logo size-8">
                    <span class="logo-brand-text">JaGGeR Shop</span>
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
                    <li><a href="#" class="copy-email-btn" onclick="copySupportEmail(event, 'support@jagger-shop')">support@jagger-shop</a></li>
                </ul>
                
                <!-- Аккуратный блок подписки на рассылку -->
                <div class="footer-subscribe-area">
                    <p class="subscribe-text">Подпишитесь на рассылку:</p>
                    <form class="footer-newsletter-form" onsubmit="event.preventDefault(); showToastNotification('Вы успешно подписались на рассылку');">
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