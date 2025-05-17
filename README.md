# E-Commerce API

A FastAPI application for an e-commerce platform using MySQL as the database.

## Project Structure

```
.
├── .env                  # Environment variables
├── main.py               # Entry point for the application
├── requirements.txt      # Python dependencies
├── setup.sh              # Setup script
└── app/
    ├── __init__.py
    ├── database.py       # Database configuration
    ├── models.py         # SQLAlchemy models
    ├── schemas.py        # Pydantic schemas
    ├── crud.py           # CRUD operations
    ├── init_db.py        # Database initialization script
    └── routers/
        ├── __init__.py
        ├── users.py
        ├── products.py
        ├── categories.py
        ├── carts.py
        └── orders.py
```

## Installation and Setup

1. Make sure you have MySQL installed and running.

2. Clone the repository:

```bash
git clone <repository-url>
cd ecommerce-api
```

3. Edit the `.env` file to set your MySQL credentials:

```
DB_USER=root
DB_PASSWORD=yourpassword
DB_HOST=localhost
DB_PORT=3306
DB_NAME=ecommerce
```

4. Run the setup script:

```bash
chmod +x setup.sh
./setup.sh
```

This will:
- Create the MySQL database
- Set up a virtual environment
- Install dependencies
- Initialize the database tables

5. Start the application:

```bash
source venv/bin/activate
uvicorn main:app --reload
```

6. Access the API documentation at http://localhost:8000/docs

## API Endpoints

### Users
- `POST /api/users` - Create a new user
- `GET /api/users` - Get all users
- `GET /api/users/{user_id}` - Get a specific user
- `PUT /api/users/{user_id}` - Update a user
- `DELETE /api/users/{user_id}` - Delete a user

### Categories
- `POST /api/categories` - Create a new category
- `GET /api/categories` - Get all categories
- `GET /api/categories/{category_id}` - Get a specific category
- `PUT /api/categories/{category_id}` - Update a category
- `DELETE /api/categories/{category_id}` - Delete a category

### Products
- `POST /api/products` - Create a new product
- `GET /api/products` - Get all products
- `GET /api/products/category/{category_id}` - Get products by category
- `GET /api/products/{product_id}` - Get a specific product
- `PUT /api/products/{product_id}` - Update a product
- `DELETE /api/products/{product_id}` - Delete a product
- `POST /api/products/{product_id}/images` - Add image to product
- `GET /api/products/{product_id}/images` - Get product images
- `DELETE /api/products/images/{image_id}` - Delete product image

### Carts
- `POST /api/carts` - Create a new cart
- `GET /api/carts/user/{user_id}` - Get active cart for user
- `GET /api/carts/{cart_id}` - Get a specific cart
- `POST /api/carts/{cart_id}/items` - Add item to cart
- `GET /api/carts/{cart_id}/items` - Get cart items
- `PUT /api/carts/items/{item_id}` - Update cart item
- `DELETE /api/carts/items/{item_id}` - Delete cart item

### Orders
- `POST /api/orders` - Create a new order
- `GET /api/orders` - Get all orders
- `GET /api/orders/user/{user_id}` - Get orders for user
- `GET /api/orders/{order_id}` - Get a specific order