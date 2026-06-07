<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="ru" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная | JaGGeR Shop</title>
    <link rel="icon" type="image/png" href="images/icons/logo.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        #productGrid .product-card.hidden-card {
            display: none !important;
        }
        .center-btn {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important;
            margin-top: 40px !important;
        }
    </style>
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
                <a href="index.php#home">Главная</a>
                <a href="index.php#catalog">Каталог</a>
                <a href="index.php#promo">Акции</a>
                <a href="#footer">О нас</a>
            </nav>

            <div class="header-actions">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Поиск по сайту..." onkeypress="handleSearchKeyPress(event, this.value)">
                </div>
                
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

    <main class="flex-grow">
        <!-- ГЛАВНЫЙ ИНТЕРАКТИВНЫЙ БАННЕР В СТИЛЕ KAPUSTA SHOP -->
        <?php if (!empty($data['products'])): 
            $featuredProduct = $data['products'][0]; // Получаем первый товар для баннера
        ?>
        <section id="home">
            <a href="product.php?id=<?php echo $featuredProduct['id']; ?>" class="hero-link-banner">
                <!-- Картинка товара -->
                <img src="<?php echo htmlspecialchars($featuredProduct['images'][0]); ?>" alt="<?php echo htmlspecialchars($featuredProduct['name']); ?>" class="hero-bg-img">
                
                <!-- Плавное затемнение и проявление текста при наведении -->
                <div class="hero-gradient-overlay">
                    <div class="hero-banner-info">
                        <h2 class="hero-banner-title"><?php echo htmlspecialchars($featuredProduct['name']); ?></h2>
                        <p class="hero-banner-price"><?php echo number_format($featuredProduct['price'], 0, '', ' '); ?>&nbsp;₽</p>
                    </div>
                </div>
            </a>
        </section>
        <?php endif; ?>

        <!-- РАЗДЕЛ АКЦИЙ С ВЕКТОРНЫМИ SVG ИКОНКАМИ -->
        <section class="container py-12" id="promo">
            <h2 class="title-accent">Акции и новости</h2>
            <div class="promo-grid">
                <!-- Карточка 1: Скидки -->
                <div class="promo-card">
                    <div class="promo-card-top">
                        <span class="badge badge-red">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;">
                                <path d="M12.586 2.586C12.211 2.2109 11.7024 2.00011 11.172 2H4C3.46957 2 2.96086 2.21071 2.58579 2.58579C2.21071 2.96086 2 3.46957 2 4V11.172C2.00011 11.7024 2.2109 12.211 2.586 12.586L11.29 21.29C11.7445 21.7416 12.3592 21.9951 13 21.9951C13.6408 21.9951 14.2555 21.7416 14.71 21.29L21.29 14.71C21.7416 14.2555 21.9951 13.6408 21.9951 13C21.9951 12.3592 21.7416 11.7445 21.29 11.29L12.586 2.586Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.5 8C7.77614 8 8 7.77614 8 7.5C8 7.22386 7.77614 7 7.5 7C7.22386 7 7 7.22386 7 7.5C7 7.77614 7.22386 8 7.5 8Z" fill="#ffffff" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Скидки до 55%
                        </span>
                        <span class="date-text">До 1 июля 2026</span>
                    </div>
                    <h3>На старые туровые футболки</h3>
                    <p>Специальное предложение последних туровых футболок 2025 года.</p>
                </div>

                <!-- Карточка 2: Доставка -->
                <div class="promo-card">
                    <div class="promo-card-top">
                        <span class="badge badge-gray">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;">
                                <path d="M22 7L13.5 15.5L8.5 10.5L2 17" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16 7H22V13" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Доставка
                        </span>
                        <span class="date-text">Постоянно</span>
                    </div>
                    <h3>Бесплатная курьером</h3>
                    <p>При оформлении заказа на сумму от 10 000 рублей доставка бесплатно.</p>
                </div>

                <!-- Карточка 3: Новинки -->
                <div class="promo-card">
                    <div class="promo-card-top">
                        <span class="badge badge-gray">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;">
                                <path d="M8 2V6" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16 2V6" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 10H21" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Новинки
                        </span>
                        <span class="date-text">1 мая 2026</span>
                    </div>
                    <h3>Новое поступление</h3>
                    <p>Большое обновление ассортимента футболок и худи.</p>
                </div>
            </div>
        </section>

        <!-- ВИТРИНА КАТАЛОГА С УМНЫМ ПОИСКОМ PHP -->
        <section class="container py-12" id="catalog">
            <?php 
            $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
            
            // Фильтруем массив товаров на стороне сервера
            $filteredProducts = $data['products'];
            if ($searchQuery !== '') {
                $filteredProducts = array_filter($data['products'], function($p) use ($searchQuery) {
                    return mb_strpos(mb_strtolower($p['name']), mb_strtolower($searchQuery)) !== false;
                });
            }
            ?>

            <?php if ($searchQuery !== ''): ?>
                <h2 class="title-accent" style="text-align: left; margin-bottom: 20px;">
                    Результаты поиска по запросу: «<?php echo htmlspecialchars($searchQuery); ?>»
                </h2>
                <a href="index.php#catalog" class="reset-search-btn">Сбросить поиск</a>
            <?php else: ?>
                <h2 class="title-accent">Наш ассортимент</h2>
            <?php endif; ?>

            <div class="products-grid" id="productGrid">
                <?php 
                $counter = 0;
                if (empty($filteredProducts)): ?>
                    <p style="grid-column: 1/-1; text-align: center; color: var(--muted-foreground); padding: 40px 0;">Товары по вашему запросу не найдены.</p>
                <?php else:
                    foreach ($filteredProducts as $product): 
                        $counter++;
                        $hiddenClass = ($counter > 8) ? 'hidden-card' : '';

                        $totalStock = 0;
                        if (isset($product['sizes_stock'])) {
                            foreach ($product['sizes_stock'] as $qty) {
                                $totalStock += $qty;
                            }
                        }
                        $isSoldOut = ($totalStock === 0);
                    ?>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="product-card <?php echo $hiddenClass; ?>" data-name="<?php echo strtolower($product['name']); ?>">
                            <div class="img-wrapper">
                                <img src="<?php echo htmlspecialchars($product['images'][0]); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <?php if ($product['tag']): ?>
                                    <span class="card-tag tag-new"><?php echo htmlspecialchars($product['tag']); ?></span>
                                <?php endif; ?>
                                <?php if ($product['discount']): ?>
                                    <span class="card-tag tag-discount">-<?php echo $product['discount']; ?>%</span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <div class="price-row">
                                    <?php if ($product['old_price']): ?>
                                        <span class="price-old"><?php echo number_format($product['old_price'], 0, '', ' '); ?> ₽</span>
                                    <?php endif; ?>
                                    <span class="price-current"><?php echo number_format($product['price'], 0, '', ' '); ?> ₽</span>
                                    <?php if ($isSoldOut): ?>
                                        <span class="sold-out-label">Sold out</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php 
                    endforeach; 
                endif; 
                ?>
            </div>

            <!-- Кнопка «Показать больше товаров» (показывается только если скрытых товаров > 0) -->
            <?php if (count($filteredProducts) > 8): ?>
                <div class="center-btn">
                    <button class="btn btn-outline" id="loadMoreBtn">Показать больше товаров</button>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- ОНЛАЙН КОНСУЛЬТАНТ С ВЕКТОРНЫМИ SVG -->
    <div class="chat-wrapper" id="chatWidget">
        <button class="chat-toggle-btn" onclick="toggleChat()">
            <!-- Векторная иконка чата (диалоговое облако) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#09090b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon-chat-svg">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
        </button>
        <div class="chat-panel" id="chatPanel">
            <div class="chat-header">Онлайн-консультант</div>
            <div class="chat-body" id="chatMessages">
                <div class="msg-bot">Здравствуйте! Если у вас возникли вопросы по подбору размеров или доставке — пишите нам сюда.</div>
            </div>
            <div class="chat-footer">
                <input type="text" id="chatInput" placeholder="Ваше сообщение..." onkeypress="handleChatKey(event)">
                <button onclick="sendChatMessage()">
                    <!-- Векторная иконка отправки (бумажный самолетик) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon-send-svg">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>
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