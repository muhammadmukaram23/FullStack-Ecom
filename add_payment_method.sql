-- Add payment_method column to Orders table if it doesn't exist
ALTER TABLE Orders ADD COLUMN payment_method VARCHAR(100) DEFAULT 'Cash on Delivery';

-- If you get an error about the column already existing, you can run this instead:
-- ALTER TABLE Orders MODIFY COLUMN payment_method VARCHAR(100) DEFAULT 'Cash on Delivery'; 
-- Create wishlists table
CREATE TABLE wishlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY user_product_unique (user_id, product_id)
);

-- Create index for faster lookups
CREATE INDEX idx_wishlists_user_id ON wishlists (user_id);
CREATE INDEX idx_wishlists_product_id ON wishlists (product_id);

-- Optional: Add a few test records
-- INSERT INTO wishlists (user_id, product_id) VALUES (1, 5);
-- INSERT INTO wishlists (user_id, product_id) VALUES (1, 10);