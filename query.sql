CREATE TABLE `seller`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `first_name` varchar(25) NOT NULL,
    `last_name` varchar(25) DEFAULT NULL,
    `mobile` VARCHAR(15) NOT NULL,
    `profile_image` varchar(256) NOT NULL,
    PRIMARY KEY (`id`),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
ALTER TABLE `seller`
ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;



CREATE TABLE `shop`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `seller_id` INT(11) NOT NULL,
    `shop_name` varchar(256) NOT NULL,
    `shop_image` varchar(256) NOT NULL,
    `location` varchar(256) NOT NULL,
    `type` varchar(256) DEFAULT NULL,
    `description` varchar(1028) DEFAULT NULL,
    PRIMARY KEY (`id`),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `shop`
ADD FOREIGN KEY (`seller_id`) REFERENCES `seller`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


CREATE TABLE `buyer`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `first_name` varchar(25) NOT NULL,
    `last_name` varchar(25) DEFAULT NULL,
    `mobile` VARCHAR(15) NOT NULL,
    `profile_image` varchar(256) NOT NULL,
    PRIMARY KEY (`id`),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
ALTER TABLE `buyer`
ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;






CREATE TABLE `products` (
    `product_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `title` varchar(256) DEFAULT NULL,
    `image_path` varchar(256) DEFAULT NULL,
    `price` int(11) NOT NULL,
    `avalibility` enum('yes', 'no') NOT NULL DEFAULT 'yes',
    `description` varchar(1028) DEFAULT NULL,
    PRIMARY KEY (`product_id`),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- =============================

ALTER TABLE `products`
ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
-- ==============================
CREATE TABLE `cart` (
    `cart_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `product_id` int(11) NOT NULL,
    `shop_id` INT(11) NOT NULL,
    `quantity` int(5) NOT NULL,
    PRIMARY KEY (`cart_id`),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
ALTER TABLE `cart`
ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `cart`
ADD FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `cart`
ADD FOREIGN KEY (`shop_id`) REFERENCES `shop`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ==============================

CREATE TABLE `orders` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `product_id` int(11) NOT NULL,
    `grand_total` float(10, 2) NOT NULL,
    `status` enum('placed', 'cancel','delivered') NOT NULL DEFAULT 'placed',
    PRIMARY KEY (`id`),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;
ALTER TABLE `orders`
ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `products`
ADD FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;




