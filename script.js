// Инициализация корзины
let cart = JSON.parse(localStorage.getItem('cart_v2')) || JSON.parse(localStorage.getItem('cart')) || [];

// Настройка размера по умолчанию
let activeSize = (typeof currentProductData !== 'undefined' && currentProductData.sizes_stock) ? Object.keys(currentProductData.sizes_stock)[0] : 'L';

let currentSlideIndex = 1; 
let isTransitioning = false;

// Обновление счетчика товаров в шапке
function updateHeaderCartCount() {
    const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    const badge = document.getElementById('cartCount');
    if (badge) badge.innerText = totalCount;
}

// Переключение размеров и обновление статуса в наличии
function selectSize(element) {
    const buttons = document.querySelectorAll('.btn-size');
    buttons.forEach(btn => btn.classList.remove('active'));
    element.classList.add('active');
    activeSize = element.innerText;

    // Считываем остаток для выбранного размера
    const stock = parseInt(element.getAttribute('data-stock'));
    updateStockStatusUI(stock);
    syncProductPageCartState(); // Синхронизируем кнопки
}

// Обновление UI-статуса остатков на странице товара
function updateStockStatusUI(stock) {
    const statusVal = document.getElementById('statusVal');
    const addToCartBtn = document.getElementById('addToCartPageBtn');
    if (!statusVal) return;

    if (stock > 5) {
        statusVal.className = 'status-val text-green';
        statusVal.innerText = 'много';
        if (addToCartBtn) addToCartBtn.style.display = 'inline-flex';
    } else if (stock > 0 && stock <= 5) {
        statusVal.className = 'status-val text-orange';
        statusVal.innerText = 'мало';
        if (addToCartBtn) addToCartBtn.style.display = 'inline-flex';
    } else {
        statusVal.className = 'status-val text-white';
        statusVal.innerText = 'Нет в наличии';
        if (addToCartBtn) addToCartBtn.style.display = 'none';
    }
}

// Добавление со страницы товара
function handlePageAddToCart() {
    if (typeof currentProductData === 'undefined') return;

    const productIdAndSize = `${currentProductData.id}_${activeSize}`;
    const existing = cart.find(item => item.cartId === productIdAndSize);

    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({
            cartId: productIdAndSize,
            id: currentProductData.id,
            name: currentProductData.name,
            size: activeSize,
            price: currentProductData.price,
            image: currentProductData.images[0],
            quantity: 1
        });
    }

    localStorage.setItem('cart_v2', JSON.stringify(cart));
    updateHeaderCartCount();
    syncProductPageCartState(); // Мгновенное обновление кнопок на текущей странице
    showToastNotification('Добавлено в корзину'); // Красивое всплывающее уведомление
}

// Бесшовный бесконечный слайдер на странице товара
function initInfiniteSlider() {
    const tape = document.getElementById('sliderTape');
    if (!tape || typeof currentProductData === 'undefined') return;

    const images = Array.from(tape.querySelectorAll('img:not(.clone)'));
    const totalOriginals = images.length;
    if (totalOriginals <= 1) return;

    tape.innerHTML = '';

    const firstClone = images[0].cloneNode(true);
    firstClone.classList.add('clone');
    
    const lastClone = images[totalOriginals - 1].cloneNode(true);
    lastClone.classList.add('clone');

    tape.appendChild(lastClone);
    images.forEach(img => tape.appendChild(img));
    tape.appendChild(firstClone);

    currentSlideIndex = 1;
    tape.style.transition = 'none';
    tape.style.transform = `translate3d(0, -100%, 0)`;

    setTimeout(() => {
        tape.style.transition = 'transform 0.6s cubic-bezier(0.25, 1, 0.5, 1)';
    }, 50);

    tape.addEventListener('transitionend', () => {
        isTransitioning = false;

        if (currentSlideIndex === totalOriginals + 1) {
            tape.style.transition = 'none';
            currentSlideIndex = 1;
            tape.style.transform = `translate3d(0, -100%, 0)`;
            setTimeout(() => {
                tape.style.transition = 'transform 0.6s cubic-bezier(0.25, 1, 0.5, 1)';
            }, 20);
        }

        if (currentSlideIndex === 0) {
            tape.style.transition = 'none';
            currentSlideIndex = totalOriginals;
            tape.style.transform = `translate3d(0, -${totalOriginals * 100}%, 0)`;
            setTimeout(() => {
                tape.style.transition = 'transform 0.6s cubic-bezier(0.25, 1, 0.5, 1)';
            }, 20);
        }
    });
}

function scrollVerticalSlider(direction) {
    if (isTransitioning) return;
    const tape = document.getElementById('sliderTape');
    if (!tape || typeof currentProductData === 'undefined') return;

    isTransitioning = true;
    currentSlideIndex += direction;
    tape.style.transform = `translate3d(0, -${currentSlideIndex * 100}%, 0)`;
}

// Рендер страницы корзины (cart.php)
function renderCartPage() {
    const container = document.getElementById('cartPageList');
    if (!container) return;

    container.innerHTML = '';
    let totalSum = 0;

    if (cart.length === 0) {
        container.innerHTML = `<p style="padding: 20px 0; color: var(--muted-foreground);">Ваша корзина пуста.</p>`;
        document.getElementById('cartPageTotal').innerText = '0 ₽';
        return;
    }

    cart.forEach(item => {
        totalSum += item.price * item.quantity;
        container.innerHTML += `
            <div class="cart-page-item">
                <div class="cart-item-info">
                    <img src="${item.image}" class="cart-item-thumbnail" alt="Фото">
                    <div class="cart-item-meta">
                        <h3>${item.name}</h3>
                        <p>Размер: <strong>${item.size}</strong></p>
                        <p style="font-weight: 700; margin-top: 5px;">${item.price.toLocaleString()} ₽</p>
                    </div>
                </div>
                <div class="cart-item-actions">
                    <div class="quantity-selector">
                        <button class="qty-btn" onclick="adjustQty('${item.cartId}', -1)">-</button>
                        <span class="qty-val">${item.quantity}</span>
                        <button class="qty-btn" onclick="adjustQty('${item.cartId}', 1)">+</button>
                    </div>
                    <button class="btn-remove-item" onclick="removeCartItem('${item.cartId}')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    });

    document.getElementById('cartPageTotal').innerText = totalSum.toLocaleString() + ' ₽';
}

function removeCartItem(cartId) {
    cart = cart.filter(i => i.cartId !== cartId);
    localStorage.setItem('cart_v2', JSON.stringify(cart));
    updateHeaderCartCount();
    renderCartPage();
}

function openCheckoutModal() {
    if (cart.length === 0) {
        showToastNotification('Добавьте товары перед оформлением.');
        return;
    }
    
    // ПРОВЕРКА АВТОРИЗАЦИИ: Если переменная isUserAuthorized равна false
    if (typeof isUserAuthorized === 'undefined' || !isUserAuthorized) {
        showToastNotification('Для оформления заказа необходимо авторизоваться');
        setTimeout(() => openAuthModal(), 1000); // Автоматически открываем форму входа с задержкой
        return;
    }
    
    document.getElementById('checkoutModal').style.display = 'flex';
}

function closeCheckoutModal() {
    document.getElementById('checkoutModal').style.display = 'none';
}

function confirmCheckout(e) {
    e.preventDefault();
    showToastNotification('Заказ принят на обработку');
    cart = [];
    localStorage.setItem('cart_v2', JSON.stringify([]));
    updateHeaderCartCount();
    closeCheckoutModal();
    renderCartPage();
}

function filterProducts() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.product-card');
    cards.forEach(card => {
        const name = card.getAttribute('data-name');
        if (name) {
            card.style.display = name.includes(query) ? 'block' : 'none';
        }
    });
}

function openAuthModal() { document.getElementById('authModal').style.display = 'flex'; }
function closeAuthModal() { document.getElementById('authModal').style.display = 'none'; }

// Переключение режимов авторизации/регистрации и настройка обязательных полей
function switchAuthMode(mode) {
    const btn = document.getElementById('authBtn');
    const act = document.getElementById('authAction');
    const regContactGroup = document.getElementById('registerContactGroup');
    const idLabel = document.getElementById('identifierLabel');
    const idInput = document.getElementById('authIdentifier');
    const contactInput = document.getElementById('authContact');

    document.getElementById('tabLogin').classList.toggle('active', mode === 'login');
    document.getElementById('tabRegister').classList.toggle('active', mode === 'register');

    if (mode === 'login') {
        act.value = 'login';
        btn.innerText = 'Войти';
        
        // Поля для входа
        idLabel.innerText = 'Логин, Телефон или E-mail';
        idInput.placeholder = 'Введите логин, телефон или email';
        regContactGroup.style.display = 'none';
        contactInput.removeAttribute('required');
    } else {
        act.value = 'register';
        btn.innerText = 'Зарегистрироваться';
        
        // Поля для регистрации
        idLabel.innerText = 'Логин (никнейм)';
        idInput.placeholder = 'Придумайте никнейм';
        regContactGroup.style.display = 'block';
        contactInput.setAttribute('required', 'required');
    }
}

// Отправка формы входа/регистрации на сервер
function handleAuth(e) {
    e.preventDefault();
    const action = document.getElementById('authAction').value;
    const password = document.getElementById('authPassword').value;
    
    const fd = new FormData();
    fd.append('action', action);
    fd.append('password', password);

    if (action === 'login') {
        const identifier = document.getElementById('authIdentifier').value;
        fd.append('identifier', identifier);
    } else {
        const login = document.getElementById('authIdentifier').value;
        const contact = document.getElementById('authContact').value;
        fd.append('login', login);
        fd.append('contact', contact);
    }

    fetch('db.php', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showToastNotification(data.message);
            }
        });
}

function logout() {
    const fd = new FormData();
    fd.append('action', 'logout');
    fetch('db.php', { method: 'POST', body: fd }).then(() => location.reload());
}

function toggleChat() {
    const panel = document.getElementById('chatPanel');
    panel.style.display = (panel.style.display === 'flex') ? 'none' : 'flex';
}
function handleChatKey(e) {
    if (e.key === 'Enter') sendChatMessage();
}
// Интеллектуальный высокопроизводительный Чат-бот поддержки JaGGeR Store
function sendChatMessage() {
    const input = document.getElementById('chatInput');
    const txt = input.value.trim();
    if (!txt) return;

    const chatBody = document.getElementById('chatMessages');
    
    // 1. Выводим сообщение пользователя в чат
    chatBody.innerHTML += `<div class="msg-user">${txt}</div>`;
    input.value = '';
    chatBody.scrollTop = chatBody.scrollHeight;

    // 2. Нормализация текста для гибкого поиска ключевых слов
    const messageLower = txt.toLowerCase();
    let botResponse = '';

    // База знаний чат-бота (ключевые слова и точные ответы)
    if (messageLower.includes('привет') || messageLower.includes('здравствуй') || messageLower.includes('начать') || messageLower.includes('помоги') || messageLower.includes('меню')) {
        botResponse = 'Здравствуйте! Я автоматизированный консультант JaGGeR Store. Я могу моментально проконсультировать вас по следующим вопросам:<br><br>' +
                      '<strong>Доставка</strong> — тарифы, сроки, СДЭК и Почта России.<br>' +
                      '<strong>Размеры</strong> — подбор размера под рост и вес.<br>' +
                      '<strong>Оплата</strong> — ошибки оплаты, СБП и заблокированные заказы.<br>' +
                      '<strong>Трек</strong> — где найти трек-номер отправления.<br>' +
                      '<strong>Возврат</strong> — обмен вещей и возврат при обнаружении брака.<br><br>' +
                      'Просто напишите интересующее слово!';
    } 
    else if (messageLower.includes('доставк') || messageLower.includes('отправ') || messageLower.includes('сдэк') || messageLower.includes('почт') || messageLower.includes('стран')) {
        botResponse = '<strong>Информация о доставке:</strong><br><br>' +
                      '• Доставляем по всей России и странам ЕАЭС через ТК СДЭК и Почту России.<br>' +
                      '• Сроки сборки и отправки заказа: в течение 7 рабочих дней.<br>' +
                      '• <strong>Бесплатная доставка курьером</strong> предоставляется при сумме покупки от 10 000 ₽.';
    } 
    else if (messageLower.includes('размер') || messageLower.includes('рост') || messageLower.includes('вес') || messageLower.includes('таблиц') || messageLower.includes('размерн')) {
        botResponse = '<strong>Подбор размера одежды:</strong><br><br>' +
                      '• Наши футболки и худи имеют свободный крой <strong>Оверсайз</strong>.<br>' +
                      '• При росте 160-175 см (и весе до 75 кг) идеально сядут размеры <strong>S или M</strong>.<br>' +
                      '• При росте 175-190 см рекомендуем выбирать размеры <strong>L или XL</strong>.<br>' +
                      '• Точная таблица параметров доступна по ссылке «Размерная сетка» в самом низу страницы.';
    } 
    else if (messageLower.includes('оплат') || messageLower.includes('неоплач') || messageLower.includes('заказ') || messageLower.includes('сбп') || messageLower.includes('банк')) {
        botResponse = '<strong>Оплата и заказы:</strong><br><br>' +
                      '• Оплатить покупку можно картой любого банка РФ или через СБП прямо при оформлении.<br>' +
                      '• Если система пишет, что у вас есть «один неоплаченный заказ» — это временный лимит. Повторное оформление на этот же номер телефона разблокируется автоматически через <strong>15 минут</strong>.';
    } 
    else if (messageLower.includes('трек') || messageLower.includes('номер') || messageLower.includes('отслед') || messageLower.includes('посылк')) {
        botResponse = '<strong>Где искать трек-номер посылки:</strong><br><br>' +
                      '• Трек-номер высылается в автоматическом письме на вашу электронную почту сразу после того, как курьер передаст посылку в СДЭК или Почту России.<br>' +
                      '• Если письмо не пришло в течение 3-5 дней с момента оплаты, проверьте папку «Спам» или напишите нам.';
    } 
    else if (messageLower.includes('брак') || messageLower.includes('возврат') || messageLower.includes('обмен') || messageLower.includes('качество')) {
        botResponse = '<strong>Политика возврата и обмена:</strong><br><br>' +
                      '• Если вы обнаружили производственный брак — мы обменяем вещь или вернем деньги в полном объеме, включая расходы на доставку.<br>' +
                      '• Напишите нам на почту <strong>support@jaggerstore.ru</strong> и прикрепите фото дефекта. Мы решим проблему в кратчайшие сроки.';
    } 
    else {
        // Ответ при отсутствии совпадений
        botResponse = 'К сожалению, я не смог распознать ваш запрос в базе знаний.<br><br>' +
                      'Пожалуйста, напишите одно из ключевых слов: <strong>Доставка</strong>, <strong>Размеры</strong>, <strong>Оплата</strong>, <strong>Трек</strong> или <strong>Брак</strong>, чтобы я смог дать точный ответ.';
    }

    // 3. Симуляция набора текста ботом (плавная задержка 800мс)
    setTimeout(() => {
        chatBody.innerHTML += `<div class="msg-bot">${botResponse}</div>`;
        chatBody.scrollTop = chatBody.scrollHeight;
    }, 800);
}

// Функция принудительного восстановления раскрытого состояния каталога (через LocalStorage)
function restoreCatalogExpandedState() {
    const navEntries = performance.getEntriesByType('navigation');
    if (navEntries.length > 0 && navEntries[0].type === 'reload') {
        localStorage.removeItem('catalog_expanded');
    }

    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const isExpanded = localStorage.getItem('catalog_expanded') === 'true';
    
    if (isExpanded) {
        const hiddenCards = document.querySelectorAll('#productGrid .product-card.hidden-card');
        hiddenCards.forEach(card => card.classList.remove('hidden-card'));
        
        if (loadMoreBtn) {
            const parentContainer = loadMoreBtn.closest('.center-btn');
            if (parentContainer) {
                parentContainer.style.setProperty('display', 'none', 'important');
            }
        }
    }
}

// Функция синхронизации состояния кнопок на странице товара
function syncProductPageCartState() {
    if (typeof currentProductData === 'undefined') return;

    const productIdAndSize = `${currentProductData.id}_${activeSize}`;
    const existing = cart.find(item => item.cartId === productIdAndSize);

    const addBtn = document.getElementById('addToCartPageBtn');
    const addedContainer = document.getElementById('addedStateContainer');
    const qtyVal = document.getElementById('productPageQtyVal');

    if (existing) {
        if (addBtn) addBtn.style.setProperty('display', 'none', 'important');
        if (addedContainer) addedContainer.style.setProperty('display', 'flex', 'important');
        if (qtyVal) qtyVal.innerText = existing.quantity;
    } else {
        if (addedContainer) addedContainer.style.setProperty('display', 'none', 'important');
        
        const activeBtn = document.querySelector('.btn-size.active');
        const stock = activeBtn ? parseInt(activeBtn.getAttribute('data-stock')) : 0;
        
        if (addBtn) {
            if (stock > 0) {
                addBtn.style.setProperty('display', 'inline-flex', 'important');
            } else {
                addBtn.style.setProperty('display', 'none', 'important');
            }
        }
    }
}

// Удаление товара прямо со страницы товара при клике на "Убрать"
function handlePageRemoveFromCart() {
    if (typeof currentProductData === 'undefined') return;
    const productIdAndSize = `${currentProductData.id}_${activeSize}`;
    cart = cart.filter(item => item.cartId !== productIdAndSize);
    localStorage.setItem('cart_v2', JSON.stringify(cart));
    updateHeaderCartCount();
    syncProductPageCartState();
}

// Регулировка количества кнопками +- прямо со страницы товара
function adjustProductPageQty(delta) {
    if (typeof currentProductData === 'undefined') return;
    const productIdAndSize = `${currentProductData.id}_${activeSize}`;
    const item = cart.find(i => i.cartId === productIdAndSize);
    if (item) {
        const newQty = item.quantity + delta;
        if (newQty >= 1) {
            item.quantity = newQty;
            localStorage.setItem('cart_v2', JSON.stringify(cart));
            updateHeaderCartCount();
            syncProductPageCartState();
        }
    }
}

// Функция регулировки количества в корзине
function adjustQty(cartId, delta) {
    const item = cart.find(i => i.cartId === cartId);
    if (item) {
        const newQty = item.quantity + delta;
        if (newQty >= 1) {
            item.quantity = newQty;
            localStorage.setItem('cart_v2', JSON.stringify(cart));
            updateHeaderCartCount();
            renderCartPage();
        }
    }
}

// Универсальная функция вывода красивых тост-уведомлений на экран
function showToastNotification(message) {
    let toast = document.querySelector('.toast-notification');
    if (!toast) {
        toast = document.createElement('div');
        toast.className = 'toast-notification';
        document.body.appendChild(toast);
    }
    toast.innerText = message;
    
    if (window.toastTimeout) clearTimeout(window.toastTimeout);
    
    setTimeout(() => toast.classList.add('show'), 50);
    
    window.toastTimeout = setTimeout(() => {
        toast.classList.remove('show');
    }, 2000);
}

// Копирование почты поддержки с выводом всплывающего тост-уведомления
function copySupportEmail(event, email) {
    event.preventDefault();
    navigator.clipboard.writeText(email).then(() => {
        showToastNotification('Почта скопирована');
    }).catch(err => {
        console.error('Ошибка копирования: ', err);
    });
}

// Логика плавного раскрытия аккордеона FAQ
function toggleFaq(element) {
    const currentItem = element.parentElement;
    const currentContent = currentItem.querySelector('.faq-content');
    const isActive = currentItem.classList.contains('active');
    
    const allItems = document.querySelectorAll('.faq-item');
    allItems.forEach(item => {
        if (item !== currentItem) {
            item.classList.remove('active');
            const content = item.querySelector('.faq-content');
            content.style.maxHeight = '0px';
            content.style.paddingTop = '0px';
            content.style.paddingBottom = '0px';
        }
    });
    
    if (isActive) {
        currentItem.classList.remove('active');
        currentContent.style.maxHeight = '0px';
        currentContent.style.paddingTop = '0px';
        currentContent.style.paddingBottom = '0px';
    } else {
        currentItem.classList.add('active');
        currentContent.style.paddingTop = '10px';
        currentContent.style.paddingBottom = '24px';
        currentContent.style.maxHeight = (currentContent.scrollHeight + 34) + 'px';
    }
}

// Динамическое добавление нового поля выбора файла в админ-панели
function addNewImageField() {
    const container = document.getElementById('imagesUploadContainer');
    if (!container) return;
    
    const newInputDiv = document.createElement('div');
    newInputDiv.className = 'image-input-item';
    newInputDiv.style.animation = 'fadeIn 0.2s ease-out';
    
    const count = container.querySelectorAll('.image-input-item').length + 1;
    
    newInputDiv.innerHTML = `
        <input type="file" name="product_images[]" class="input-dark" accept="image/*" style="padding: 8px 12px !important; margin-bottom: 5px !important;">
        <p style="font-size: 11px; color: var(--muted-foreground);">* Изображение ${count}</p>
    `;
    
    container.appendChild(newInputDiv);
}

// Отправка формы добавления товара через FormData (с поддержкой загрузки файлов)
function addProduct(e) {
    e.preventDefault();
    const form = e.target;
    const fd = new FormData(form); 
    fd.append('action', 'add_product');

    fetch('db.php', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToastNotification('Товар добавлен');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToastNotification(data.message);
            }
        });
}

// Блокировка пользователя в админке
function blockUser() {
    const username = document.getElementById('blockUsername').value;
    const fd = new FormData();
    fd.append('action', 'block_user');
    fd.append('username', username);

    fetch('db.php', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToastNotification(`Пользователь ${username} заблокирован`);
            } else {
                showToastNotification(data.message);
            }
        });
}

// Перенаправление на главную страницу с GET-параметром поиска при нажатии Enter
function handleSearchKeyPress(event, value) {
    if (event.key === 'Enter') {
        const query = value.trim();
        if (query) {
            window.location.href = `index.php?search=${encodeURIComponent(query)}#catalog`;
        } else {
            window.location.href = 'index.php#catalog';
        }
    }
}

// Запуск инициализации при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
    updateHeaderCartCount();
    renderCartPage();
    initInfiniteSlider();

    // Первичный расчет статуса остатков для активного по умолчанию размера (на странице товара)
    const activeSizeBtn = document.querySelector('.btn-size.active');
    if (activeSizeBtn) {
        const initialStock = parseInt(activeSizeBtn.getAttribute('data-stock'));
        updateStockStatusUI(initialStock);
    }

    // Восстанавливаем состояние каталога и кнопок
    restoreCatalogExpandedState();
    syncProductPageCartState();

    // Логика кнопки «Показать больше товаров»
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', (e) => {
            e.preventDefault();
            
            const hiddenCards = document.querySelectorAll('#productGrid .product-card.hidden-card');
            const batchSize = 8;
            
            for (let i = 0; i < Math.min(batchSize, hiddenCards.length); i++) {
                hiddenCards[i].classList.remove('hidden-card');
            }
            
            localStorage.setItem('catalog_expanded', 'true');
            
            const remainingHidden = document.querySelectorAll('#productGrid .product-card.hidden-card');
            if (remainingHidden.length === 0) {
                const parentContainer = loadMoreBtn.closest('.center-btn');
                if (parentContainer) {
                    parentContainer.style.setProperty('display', 'none', 'important');
                }
            }
        });
    }
});

// Запуск при возврате назад (bfcache) — срабатывает всегда
window.addEventListener('pageshow', () => {
    restoreCatalogExpandedState();
    syncProductPageCartState();
});
// Интерактивное переключение видимости пароля (смена типа инпута и сглаженной иконки)
function togglePasswordVisibility() {
    const passInput = document.getElementById('authPassword');
    const eyeIcon = document.getElementById('eyeIcon');
    if (!passInput || !eyeIcon) return;

    if (passInput.type === 'password') {
        passInput.type = 'text';
        // Перечёркнутый сглаженный глаз
        eyeIcon.innerHTML = `
            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
            <path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
            <line x1="2" y1="2" x2="22" y2="22"></line>
        `;
    } else {
        passInput.type = 'password';
        // Обычный сглаженный глаз
        eyeIcon.innerHTML = `
            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        `;
    }
}