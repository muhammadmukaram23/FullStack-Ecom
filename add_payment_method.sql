-- Add payment_method column to Orders table if it doesn't exist
ALTER TABLE Orders ADD COLUMN payment_method VARCHAR(100) DEFAULT 'Cash on Delivery';

-- If you get an error about the column already existing, you can run this instead:
-- ALTER TABLE Orders MODIFY COLUMN payment_method VARCHAR(100) DEFAULT 'Cash on Delivery'; 