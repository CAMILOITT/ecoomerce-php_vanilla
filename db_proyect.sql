CREATE TABLE `sales` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `customer_id` int,
  `subtotal` decimal(10,2),
  `tax` decimal(10,2),
  `total` decimal(10,2),
  `state` tinyint,
  `bill_number` varchar(50),
  `bill_date` datetime,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `sale_details` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `sale_id` int,
  `product_id` int,
  `amount` int,
  `price` decimal(10,2),
  `discount` decimal(10,2),
  `iva` decimal(10,2),
  `subtotal` decimal(10,2),
  `total` decimal(10,2)
);

CREATE TABLE `documents` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100),
  `state` tinyint,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `roles` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(250),
  `state` tinyint
);

CREATE TABLE `providers` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100),
  `ruc` varchar(13),
  `address` text,
  `phone` varchar(15),
  `email` varchar(250),
  `consultant` varchar(200),
  `state` tinyint
);

CREATE TABLE `products` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `category_id` int,
  `name` varchar(250),
  `code` varchar(50),
  `description` text,
  `iva` tinyint,
  `unit_price` decimal(10,2),
  `discount` decimal(5,4),
  `state` tinyint,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `role_id` int,
  `document_id` int,
  `name` varchar(100),
  `lastname` varchar(100),
  `dni` varchar(13),
  `address` text,
  `phone` varchar(15),
  `email` varchar(200),
  `password` varchar(200),
  `state` tinyint,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `customers` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `document_id` int,
  `name` varchar(100),
  `lastname` varchar(100),
  `dni` varchar(13),
  `address` text,
  `phone` varchar(15),
  `email` varchar(200),
  `password` varchar(200),
  `state` tinyint,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `permissions` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `role_id` int,
  `module` varchar(255),
  `can_read` tinyint,
  `can_create` tinyint,
  `can_update` tinyint,
  `can_delete` tinyint,
  `state` tinyint,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `inventory_movements` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `product_id` int,
  `type` varchar(25),
  `quantity` int,
  `unit_price` decimal(10,2),
  `total` decimal(10,2),
  `reference_type` varchar(25),
  `reference_id` int,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `payment_methods` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(250),
  `state` tinyint
);

CREATE TABLE `purchase_details` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `product_id` int,
  `purchase_id` int,
  `amount` int,
  `price` decimal(10,2),
  `iva` decimal(10,2),
  `subtotal` decimal(10,2),
  `total` decimal(10,2)
);

CREATE TABLE `purchases` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `provider_id` int,
  `bill_number` varchar(30),
  `subtotal` decimal(10,2),
  `tax` decimal(10,2),
  `total` decimal(10,2),
  `state` tinyint,
  `created_at` datetime
);

CREATE TABLE `shopping_cart` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `customer_id` int,
  `product_id` int,
  `amount` int,
  `created_at` datetime
);

CREATE TABLE `categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `parent_id` int,
  `name` varchar(100),
  `state` tinyint
);

CREATE TABLE `payment_details` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `sale_id` int,
  `payment_method_id` int,
  `value` decimal(10,2),
  `description` text,
  `state` tinyint
);

ALTER TABLE `sales` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `sales` ADD FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

ALTER TABLE `sale_details` ADD FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

ALTER TABLE `sale_details` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `products` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`);

ALTER TABLE `customers` ADD FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`);

ALTER TABLE `permissions` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

ALTER TABLE `inventory_movements` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `inventory_movements` ADD FOREIGN KEY (`reference_id`) REFERENCES `inventory_movements` (`id`);

ALTER TABLE `purchase_details` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `purchase_details` ADD FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`);

ALTER TABLE `purchases` ADD FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`);

ALTER TABLE `shopping_cart` ADD FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

ALTER TABLE `shopping_cart` ADD FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `categories` ADD FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`);

ALTER TABLE `payment_details` ADD FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

ALTER TABLE `payment_details` ADD FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`);
