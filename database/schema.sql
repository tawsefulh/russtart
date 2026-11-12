-- RusStart database schema + default data.
-- Import this once into an empty database (phpMyAdmin > Import).

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS cities (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(80)  NOT NULL,
    slug       VARCHAR(100) NOT NULL UNIQUE,
    is_default TINYINT(1)   NOT NULL DEFAULT 0,
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categories (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type       ENUM('article','ad') NOT NULL,
    name       VARCHAR(80)  NOT NULL,
    slug       VARCHAR(100) NOT NULL,
    is_default TINYINT(1)   NOT NULL DEFAULT 0,
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_type_slug (type, slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100) NOT NULL,
    username      VARCHAR(30)  NOT NULL UNIQUE,
    email         VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NULL,
    google_id     VARCHAR(64)  NULL UNIQUE,
    city_id       INT UNSIGNED NULL,
    university    VARCHAR(160) NULL,
    created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_city FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS articles (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    city_id     INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    title       VARCHAR(160) NOT NULL,
    slug        VARCHAR(190) NOT NULL UNIQUE,
    excerpt     VARCHAR(300) NOT NULL,
    body        MEDIUMTEXT   NOT NULL,
    cover       VARCHAR(120) NULL,
    views       INT UNSIGNED NOT NULL DEFAULT 0,
    created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    NULL,
    KEY idx_articles_city (city_id, created_at),
    KEY idx_articles_category (category_id, created_at),
    CONSTRAINT fk_articles_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_articles_city FOREIGN KEY (city_id) REFERENCES cities(id),
    CONSTRAINT fk_articles_category FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ads (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    city_id     INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    title       VARCHAR(140) NOT NULL,
    slug        VARCHAR(190) NOT NULL UNIQUE,
    description TEXT         NOT NULL,
    price       DECIMAL(12,2) NULL,
    address     VARCHAR(255) NOT NULL,
    phone       VARCHAR(20)  NULL,
    whatsapp    VARCHAR(20)  NULL,
    telegram    VARCHAR(40)  NULL,
    image       VARCHAR(120) NULL,
    created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    NULL,
    KEY idx_ads_city (city_id, created_at),
    KEY idx_ads_category (category_id, created_at),
    CONSTRAINT fk_ads_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_ads_city FOREIGN KEY (city_id) REFERENCES cities(id),
    CONSTRAINT fk_ads_category FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default cities
INSERT IGNORE INTO cities (name, slug, is_default) VALUES
('Moscow', 'moscow', 1),
('Saint Petersburg', 'saint-petersburg', 1),
('Kazan', 'kazan', 1),
('Novosibirsk', 'novosibirsk', 1),
('Yekaterinburg', 'yekaterinburg', 1),
('Tomsk', 'tomsk', 1),
('Nizhny Novgorod', 'nizhny-novgorod', 1),
('Samara', 'samara', 1),
('Rostov-on-Don', 'rostov-on-don', 1),
('Ufa', 'ufa', 1),
('Krasnoyarsk', 'krasnoyarsk', 1),
('Voronezh', 'voronezh', 1),
('Perm', 'perm', 1),
('Volgograd', 'volgograd', 1),
('Kursk', 'kursk', 1),
('Belgorod', 'belgorod', 1),
('Tula', 'tula', 1),
('Kaliningrad', 'kaliningrad', 1),
('Vladivostok', 'vladivostok', 1),
('Krasnodar', 'krasnodar', 1);

-- Default article categories
INSERT IGNORE INTO categories (type, name, slug, is_default) VALUES
('article', 'Visa & documents', 'visa-documents', 1),
('article', 'Arrival & registration', 'arrival-registration', 1),
('article', 'Housing & dormitory', 'housing-dormitory', 1),
('article', 'University life', 'university-life', 1),
('article', 'Money & banking', 'money-banking', 1),
('article', 'SIM & internet', 'sim-internet', 1),
('article', 'Transport', 'transport', 1),
('article', 'Food & groceries', 'food-groceries', 1),
('article', 'Health & insurance', 'health-insurance', 1),
('article', 'Russian language', 'russian-language', 1),
('article', 'Part-time work', 'part-time-work', 1),
('article', 'Winter', 'winter', 1),
('article', 'Culture & daily life', 'culture-daily-life', 1);

-- Default advertisement categories
INSERT IGNORE INTO categories (type, name, slug, is_default) VALUES
('ad', 'Electronics & gadgets', 'electronics-gadgets', 1),
('ad', 'Furniture & home', 'furniture-home', 1),
('ad', 'Winter clothing', 'winter-clothing', 1),
('ad', 'Books & study materials', 'books-study-materials', 1),
('ad', 'Kitchen & appliances', 'kitchen-appliances', 1),
('ad', 'Home food', 'home-food', 1),
('ad', 'Rooms & flatmates', 'rooms-flatmates', 1),
('ad', 'Services', 'services', 1),
('ad', 'Bicycles & transport', 'bicycles-transport', 1);
