<?php
session_start();
define('DB_FILE', __DIR__ . '/database.json');

if (!file_exists(DB_FILE)) {
    $defaultData = [
        'users' => [
            ['login' => 'admin', 'password' => 'admin', 'role' => 'admin', 'blocked' => false]
        ],
        'products' => [
            [
                'id' => 1,
                'name' => 'Футболка "Когда? Завтра"',
                'price' => 3500,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nПечать: Шелкография\nКрой: Оверсайз\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 12, 'M' => 3, 'L' => 0, 'XL' => 15],
                'images' => [
                    'images/products/kogda-zavtra/kogda-zavtra-1.webp',
                    'images/products/kogda-zavtra/kogda-zavtra-2.webp',
                    'images/products/kogda-zavtra/kogda-zavtra-3.webp'
                ]
            ],
            [
                'id' => 2,
                'name' => 'Футболка "Мачо и ботан"',
                'price' => 1575,
                'old_price' => 3500,
                'discount' => 55,
                'tag' => '',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nПечать: Шелкография\nКрой: Оверсайз\nРост моделей: 183/160\nРазмер на моделях: L/M\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['M' => 8, 'L' => 2, 'XL' => 0],
                'images' => [
                    'images/products/macho-i-botan/macho-i-botan-1.webp',
                    'images/products/macho-i-botan/macho-i-botan-2.webp',
                    'images/products/macho-i-botan/macho-i-botan-3.webp',
                    'images/products/macho-i-botan/macho-i-botan-4.webp',
                    'images/products/macho-i-botan/macho-i-botan-5.webp',
                    'images/products/macho-i-botan/macho-i-botan-6.webp'
                ]
            ],
            [
                'id' => 3,
                'name' => 'Зип-худи "MellSher"',
                'price' => 7000,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: 3х нитка пенье 330 гр/м²\nСостав: 80% хлопок 20% полиэстер\nПечать: Шелкография\nКрой: Оверсайз\nОверсайз зип-худи на молнии. Каждое изделие порвано вручную.\nРост моделей: 183/160\nРазмер на моделях: L/M\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0],
                'images' => [
                    'images/products/zip-khudi-mellsher/zip-khudi-mellsher-1.webp',
                    'images/products/zip-khudi-mellsher/zip-khudi-mellsher-2.webp',
                    'images/products/zip-khudi-mellsher/zip-khudi-mellsher-3.webp',
                    'images/products/zip-khudi-mellsher/zip-khudi-mellsher-4.webp',
                    'images/products/zip-khudi-mellsher/zip-khudi-mellsher-5.webp',
                    'images/products/zip-khudi-mellsher/zip-khudi-mellsher-6.webp'
                ]
            ],
            [
                'id' => 4,
                'name' => 'Футболка "Рэптилоид"',
                'price' => 2500,
                'old_price' => null,
                'discount' => null,
                'tag' => 'Новинка',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nПечать: Шелкография\nКрой: Базовый\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 7, 'M' => 15, 'L' => 4, 'XL' => 15],
                'images' => [
                    'images/products/reptiloid/reptiloid-1.webp',
                    'images/products/reptiloid/reptiloid-2.webp',
                    'images/products/reptiloid/reptiloid-3.webp',
                    'images/products/reptiloid/reptiloid-4.webp'
                ]
            ],
            [
                'id' => 5,
                'name' => 'Футболка "Неудачник"',
                'price' => 3500,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nПечать: Шелкография\nКрой: Оверсайз\nРост моделей: 183/160\nРазмер на моделях: L/M\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['M' => 8, 'L' => 0, 'XL' => 3],
                'images' => [
                    'images/products/neudachnik/neudachnik-1.jpg',
                    'images/products/neudachnik/neudachnik-2.jpg',
                    'images/products/neudachnik/neudachnik-3.webp',
                    'images/products/neudachnik/neudachnik-4.jpg',
                    'images/products/neudachnik/neudachnik-5.jpg',
                    'images/products/neudachnik/neudachnik-6.webp'
                ]
            ],
            [
                'id' => 6,
                'name' => 'Футболка "Этапы идеальных разрушений"',
                'price' => 3500,
                'old_price' => null,
                'discount' => null,
                'tag' => 'Новинка',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nПечать: Шелкография\nКрой: Оверсайз\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 0, 'M' => 2, 'L' => 14, 'XL' => 5],
                'images' => [
                    'images/products/etapy-idealnykh-razrusheniy/etapy-idealnykh-razrusheniy-1.webp',
                    'images/products/etapy-idealnykh-razrusheniy/etapy-idealnykh-razrusheniy-2.webp',
                    'images/products/etapy-idealnykh-razrusheniy/etapy-idealnykh-razrusheniy-3.webp',
                    'images/products/etapy-idealnykh-razrusheniy/etapy-idealnykh-razrusheniy-4.webp',
                    'images/products/etapy-idealnykh-razrusheniy/etapy-idealnykh-razrusheniy-5.webp'
                ]
            ],
            [
                'id' => 7,
                'name' => 'Футболка "Мужья на час"',
                'price' => 2500,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nПечать: Шелкография\nКрой: Оверсайз\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 6, 'M' => 12, 'L' => 15, 'XL' => 0],
                'images' => [
                    'images/products/muzhya-na-chas/muzhya-na-chas-1.webp',
                    'images/products/muzhya-na-chas/muzhya-na-chas-2.webp',
                    'images/products/muzhya-na-chas/muzhya-na-chas-3.webp',
                    'images/products/muzhya-na-chas/muzhya-na-chas-4.webp',
                    'images/products/muzhya-na-chas/muzhya-na-chas-5.webp'
                ]
            ],
            [
                'id' => 8,
                'name' => 'Футболка "Черные мопсы"',
                'price' => 3000,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: Тонкий летний хлопок пенье 180 гр/м²\nСостав: 95% хлопок, 5% лайкра\nПринт: Эластичный и долговечный термотрансфер\nКрой: Комфортный классический.\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 2, 'M' => 0, 'L' => 1, 'XL' => 15],
                'images' => [
                    'images/products/chernye-mopsy/chernye-mopsy-1.webp',
                    'images/products/chernye-mopsy/chernye-mopsy-2.webp',
                    'images/products/chernye-mopsy/chernye-mopsy-3.webp',
                    'images/products/chernye-mopsy/chernye-mopsy-4.webp',
                    'images/products/chernye-mopsy/chernye-mopsy-5.webp'
                ]
            ],
            [
                'id' => 9,
                'name' => 'Футболка "Ангел"',
                'price' => 3000,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nНанесение: Вышивка; Шелкография на спине\nКрой: Оверсайз\nРост моделей: 183/160\nРазмер на моделях: M/S\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 11, 'M' => 5, 'L' => 3, 'XL' => 12],
                'images' => [
                    'images/products/angel/angel-1.webp',
                    'images/products/angel/angel-2.webp',
                    'images/products/angel/angel-3.webp',
                    'images/products/angel/angel-4.webp'
                ]
            ],
            [
                'id' => 10,
                'name' => 'Футболка "Демон"',
                'price' => 3000,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nНанесение: Вышивка; Шелкография на спине\nКрой: Оверсайз\nРост моделей: 183/160\nРазмер на моделях: M/S\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 4, 'M' => 5, 'L' => 3, 'XL' => 12],
                'images' => [
                    'images/products/demon/demon-1.webp',
                    'images/products/demon/demon-2.webp',
                    'images/products/demon/demon-3.webp',
                    'images/products/demon/demon-4.webp'
                ]
            ],
            [
                'id' => 11,
                'name' => 'Футболка "Ангелочек инфантил"',
                'price' => 3000,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nПечать: Шелкография\nКрой: Оверсайз\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 4, 'M' => 9, 'L' => 1, 'XL' => 15],
                'images' => [
                    'images/products/angelochek-infantil/angelochek-infantil-1.webp',
                    'images/products/angelochek-infantil/angelochek-infantil-2.webp',
                    'images/products/angelochek-infantil/angelochek-infantil-3.webp',
                    'images/products/angelochek-infantil/angelochek-infantil-4.webp',
                    'images/products/angelochek-infantil/angelochek-infantil-5.webp'
                ]
            ],
            [
                'id' => 12,
                'name' => 'Футболка "42 братуха" v2',
                'price' => 3500,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nНанесение: Шелкография\nКрой: Оверсайз\nРост моделей: 183/160\nРазмер на моделях: M/S\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 4, 'M' => 9, 'L' => 1, 'XL' => 4],
                'images' => [
                    'images/products/42-bratukha-v2/42-bratukha-v2-1.webp',
                    'images/products/42-bratukha-v2/42-bratukha-v2-2.webp',
                    'images/products/42-bratukha-v2/42-bratukha-v2-3.webp',
                    'images/products/42-bratukha-v2/42-bratukha-v2-4.webp',
                    'images/products/42-bratukha-v2/42-bratukha-v2-5.webp',
                    'images/products/42-bratukha-v2/42-bratukha-v2-6.webp',
                    'images/products/42-bratukha-v2/42-bratukha-v2-7.webp',
                    'images/products/42-bratukha-v2/42-bratukha-v2-8.webp',
                    'images/products/42-bratukha-v2/42-bratukha-v2-9.webp'
                ]
            ],
            [
                'id' => 13,
                'name' => 'Футболка "42 братуха" v2 варёная',
                'price' => 3500,
                'old_price' => null,
                'discount' => null,
                'tag' => 'Новинка',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nНанесение: Шелкография\nКрой: Оверсайз\nОкрашено методом Garment Dye\nРост моделей: 183/160\nРазмер на моделях: M/S\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['M' => 9, 'L' => 1, 'XL' => 15],
                'images' => [
                    'images/products/42-bratukha-varenaya/42-bratukha-varenaya-1.webp',
                    'images/products/42-bratukha-varenaya/42-bratukha-varenaya-2.webp',
                    'images/products/42-bratukha-varenaya/42-bratukha-varenaya-3.webp',
                    'images/products/42-bratukha-varenaya/42-bratukha-varenaya-4.webp',
                    'images/products/42-bratukha-varenaya/42-bratukha-varenaya-5.webp',
                    'images/products/42-bratukha-varenaya/42-bratukha-varenaya-6.webp',
                    'images/products/42-bratukha-varenaya/42-bratukha-varenaya-7.webp',
                    'images/products/42-bratukha-varenaya/42-bratukha-varenaya-8.webp',
                    'images/products/42-bratukha-varenaya/42-bratukha-varenaya-9.webp'
                ]
            ],
            [
                'id' => 14,
                'name' => 'Футболка "42 братуха" v2 золотая Limited',
                'price' => 10000,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Лимитированная версия, тираж 50 штук, на вороте нанесён индивидуальный номер.\nМатериал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nНанесение: Шелкография\nКрой: Оверсайз\nРост модели: 183\nРазмер на модели: L\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0],
                'images' => [
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-1.webp',
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-2.webp',
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-3.webp',
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-4.webp',
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-5.webp',
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-6.webp',
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-7.webp',
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-8.webp',
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-9.webp',
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-10.webp',
                    'images/products/42-bratukha-v2-zolotaya-limited/42-bratukha-v2-zolotaya-limited-11.webp'
                ]
            ],
            [
                'id' => 15,
                'name' => 'Худи "Отсо" серое',
                'price' => 3500,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: футер 3х нитка 330 гр/м²\nСостав: 80% хлопок 20% полиэстер\nПечать: ШелкографияКрой: Оверсайз\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 3, 'M' => 1, 'L' => 0],
                'images' => [
                    'images/products/otso-seroe/otso-seroe-1.webp',
                    'images/products/otso-seroe/otso-seroe-2.webp',
                    'images/products/otso-seroe/otso-seroe-3.webp',
                    'images/products/otso-seroe/otso-seroe-4.webp'
                ]
            ],
            [
                'id' => 16,
                'name' => 'Футболка "Мне хорошо"',
                'price' => 3000,
                'old_price' => null,
                'discount' => null,
                'tag' => '',
                'description' => "Материал: 2х нитка пенье 240 гр/м²\nСостав: 95% хлопок 5% лайкра\nПечать: Вышивка\nКрой: Оверсайз\n\nОтправляем в течение недели с момента заказа",
                'sizes_stock' => ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0],
                'images' => [
                    'images/products/mne-khorosho/mne-khorosho-1.webp',
                    'images/products/mne-khorosho/mne-khorosho-2.webp',
                    'images/products/mne-khorosho/mne-khorosho-3.webp',
                    'images/products/mne-khorosho/mne-khorosho-4.webp'
                ]
            ]
        ],
        'reviews' => [
            ['product_id' => 1, 'user' => 'Никита', 'text' => 'Тяги шикарные, на весну самое то!', 'rating' => 5]
        ],
        'orders' => []
    ];
    file_put_contents(DB_FILE, json_encode($defaultData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getData() {
    return json_decode(file_get_contents(DB_FILE), true);
}

function saveData($data) {
    file_put_contents(DB_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$data = getData();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];

    if ($action === 'register') {
        $login = trim($_POST['login']);
        $contact = trim($_POST['contact']);
        $password = trim($_POST['password']);
        
        foreach ($data['users'] as $u) {
            if ($u['login'] === $login) {
                echo json_encode(['success' => false, 'message' => 'Этот логин уже занят']);
                exit;
            }
            if (isset($u['contact']) && $u['contact'] === $contact) {
                echo json_encode(['success' => false, 'message' => 'Этот телефон или E-mail уже используется']);
                exit;
            }
        }
        
        $data['users'][] = [
            'login' => $login,
            'contact' => $contact,
            'password' => $password,
            'role' => 'user',
            'blocked' => false
        ];
        saveData($data);
        $_SESSION['user'] = $login;
        $_SESSION['role'] = 'user';
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'login') {
        $identifier = trim($_POST['identifier']);
        $password = trim($_POST['password']);
        
        foreach ($data['users'] as $u) {
            $isMatch = ($u['login'] === $identifier) || (isset($u['contact']) && $u['contact'] === $identifier);
            if ($isMatch && $u['password'] === $password) {
                if ($u['blocked']) {
                    echo json_encode(['success' => false, 'message' => 'Ваш аккаунт заблокирован']);
                    exit;
                }
                $_SESSION['user'] = $u['login'];
                $_SESSION['role'] = $u['role'];
                echo json_encode(['success' => true, 'role' => $u['role']]);
                exit;
            }
        }
        echo json_encode(['success' => false, 'message' => 'Неверный логин, телефон/email или пароль']);
        exit;
    }

    if ($action === 'login') {
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);
        foreach ($data['users'] as $u) {
            if ($u['login'] === $login && $u['password'] === $password) {
                if ($u['blocked']) {
                    echo json_encode(['success' => false, 'message' => 'Ваш аккаунт заблокирован']);
                    exit;
                }
                $_SESSION['user'] = $login;
                $_SESSION['role'] = $u['role'];
                echo json_encode(['success' => true, 'role' => $u['role']]);
                exit;
            }
        }
        echo json_encode(['success' => false, 'message' => 'Неверный логин или пароль']);
        exit;
    }

    if ($action === 'logout') {
        session_destroy();
        echo json_encode(['success' => true]);
        exit;
    }

function slugify($text) {
    $translit = [
        'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ё'=>'yo', 'ж'=>'zh', 'з'=>'z', 
        'и'=>'i', 'й'=>'j', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p', 'р'=>'r', 
        'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'х'=>'h', 'ц'=>'ts', 'ч'=>'ch', 'ш'=>'sh', 'щ'=>'shch', 
        'ъ'=>'', 'ы'=>'y', 'ь'=>'', 'э'=>'e', 'ю'=>'yu', 'я'=>'ya',
        'А'=>'A', 'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D', 'Е'=>'E', 'Ё'=>'Yo', 'Ж'=>'Zh', 'З'=>'Z', 
        'И'=>'I', 'Й'=>'J', 'К'=>'K', 'Л'=>'L', 'М'=>'M', 'Н'=>'N', 'О'=>'O', 'П'=>'P', 'Р'=>'R', 
        'С'=>'S', 'Т'=>'T', 'У'=>'U', 'Ф'=>'F', 'Х'=>'H', 'Ц'=>'Ts', 'Ч'=>'Ch', 'Ш'=>'Sh', 'Щ'=>'Shch', 
        'Ъ'=>'', 'Ы'=>'Y', 'Ь'=>'', 'Э'=>'E', 'Ю'=>'Yu', 'Я'=>'Ya',
        '"'=>'', '\''=>'', '?'=>'', '!'=>'', ','=>'', '.'=>'', '«'=>'', '»'=>''
    ];
    $text = strtr($text, $translit);
    
    $text = str_ireplace(['Futbolka', 'Zip-khudi', 'Zip-hoodie', 'Svitshot'], '', $text);
    
    $text = trim($text);
    $text = preg_replace('/[^A-Za-z0-9-]+/', '-', $text);
    $text = strtolower($text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

if ($action === 'add_product') {
    if (($_SESSION['role'] ?? '') !== 'admin') {
        echo json_encode(['success' => false, 'message' => 'Нет прав доступа']);
        exit;
    }
    
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = (int)$_POST['price'];
    $old_price = $_POST['old_price'] ? (int)$_POST['old_price'] : null;
    $discount = $_POST['discount'] ? (int)$_POST['discount'] : null;
    $tag = trim($_POST['tag'] ?? '');
    
    $slug = slugify($name);
    $targetDir = __DIR__ . "/images/products/{$slug}";
    
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $uploadedImages = [];
    
    if (isset($_FILES['product_images'])) {
        $files = $_FILES['product_images'];
        $count = count($files['name']);
        
        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $tmpName = $files['tmp_name'][$i];
                $origName = $files['name'][$i];
                $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                
                $index = $i + 1;
                $newFileName = "{$slug}-{$index}.{$ext}";
                $destPath = "{$targetDir}/{$newFileName}";
                
                if (move_uploaded_file($tmpName, $destPath)) {
                    $uploadedImages[] = "images/products/{$slug}/{$newFileName}";
                }
            }
        }
    }
    
    if (empty($uploadedImages)) {
        echo json_encode(['success' => false, 'message' => 'Пожалуйста, выберите хотя бы одно основное изображение']);
        exit;
    }
    
    $sizesStock = [];
    if (isset($_POST['sizes']) && is_array($_POST['sizes'])) {
        foreach ($_POST['sizes'] as $sizeName) {
            $postKey = "stock_" . $sizeName;
            $stockQty = isset($_POST[$postKey]) ? (int)$_POST[$postKey] : 0;
            $sizesStock[$sizeName] = $stockQty;
        }
    }
    
    if (empty($sizesStock)) {
        $sizesStock = ['M' => 10];
    }

    $newProduct = [
        'id' => time(),
        'name' => $name,
        'price' => $price,
        'old_price' => $old_price,
        'discount' => $discount,
        'tag' => htmlspecialchars($tag),
        'description' => htmlspecialchars($description),
        'sizes_stock' => $sizesStock,
        'images' => $uploadedImages
    ];
    
    $data['products'][] = $newProduct;
    saveData($data);
    echo json_encode(['success' => true]);
    exit;
}

    if ($action === 'block_user') {
        if (($_SESSION['role'] ?? '') !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Нет прав доступа']);
            exit;
        }
        
        $identifier = trim($_POST['username']);
        $blockedAny = false;
        
        foreach ($data['users'] as &$u) {
            if ($u['role'] === 'admin') {
                continue;
            }
            
            $isMatch = ($u['login'] === $identifier) || (isset($u['contact']) && $u['contact'] === $identifier);
            if ($isMatch) {
                $u['blocked'] = true;
                $blockedAny = true;
            }
        }
        
        if ($blockedAny) {
            saveData($data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Пользователь с такими данными не найден']);
        }
        exit;
    }

    if ($action === 'add_review') {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Нужно войти на сайт']);
            exit;
        }
        $newReview = [
            'product_id' => (int)$_POST['product_id'],
            'user' => $_SESSION['user'],
            'text' => htmlspecialchars($_POST['text']),
            'rating' => (int)$_POST['rating']
        ];
        $data['reviews'][] = $newReview;
        saveData($data);
        echo json_encode(['success' => true]);
        exit;
    }
}
?>