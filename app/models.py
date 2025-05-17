from sqlalchemy import Column, Integer, String, Text, Float, ForeignKey, DECIMAL, TIMESTAMP, func
from sqlalchemy.orm import relationship

from app.database import Base


class User(Base):
    __tablename__ = "User"

    user_id = Column(Integer, primary_key=True, index=True, autoincrement=True)
    user_name = Column(String(100))
    user_email = Column(String(100), unique=True, index=True)
    user_password = Column(String(100))
    user_age = Column(Integer)

    # Relationships
    carts = relationship("Cart", back_populates="user")
    orders = relationship("Order", back_populates="user")


class Category(Base):
    __tablename__ = "Category"

    category_id = Column(Integer, primary_key=True, index=True, autoincrement=True)
    category_name = Column(String(100))

    # Relationships
    products = relationship("Product", back_populates="category")


class Product(Base):
    __tablename__ = "Product"

    product_id = Column(Integer, primary_key=True, index=True, autoincrement=True)
    product_name = Column(String(100))
    product_description = Column(Text)
    product_price = Column(DECIMAL(10, 2))
    category_id = Column(Integer, ForeignKey("Category.category_id"))

    # Relationships
    category = relationship("Category", back_populates="products")
    images = relationship("ProductImage", back_populates="product")
    cart_items = relationship("CartItem", back_populates="product")


class ProductImage(Base):
    __tablename__ = "ProductImages"

    image_id = Column(Integer, primary_key=True, index=True, autoincrement=True)
    product_id = Column(Integer, ForeignKey("Product.product_id"))
    image_url = Column(Text)

    # Relationships
    product = relationship("Product", back_populates="images")


class Cart(Base):
    __tablename__ = "Cart"

    cart_id = Column(Integer, primary_key=True, index=True, autoincrement=True)
    user_id = Column(Integer, ForeignKey("User.user_id"))

    # Relationships
    user = relationship("User", back_populates="carts")
    cart_items = relationship("CartItem", back_populates="cart")
    orders = relationship("Order", back_populates="cart")


class CartItem(Base):
    __tablename__ = "CartItems"

    id = Column(Integer, primary_key=True, index=True, autoincrement=True)
    cart_id = Column(Integer, ForeignKey("Cart.cart_id"))
    product_id = Column(Integer, ForeignKey("Product.product_id"))
    quantity = Column(Integer, default=1)

    # Relationships
    cart = relationship("Cart", back_populates="cart_items")
    product = relationship("Product", back_populates="cart_items")


class Order(Base):
    __tablename__ = "Orders"

    order_id = Column(Integer, primary_key=True, index=True, autoincrement=True)
    user_id = Column(Integer, ForeignKey("User.user_id"))
    cart_id = Column(Integer, ForeignKey("Cart.cart_id"))
    user_address = Column(Text)
    payment_method = Column(String(100), default="Cash on Delivery")
    order_date = Column(TIMESTAMP, server_default=func.now())

    # Relationships
    user = relationship("User", back_populates="orders")
    cart = relationship("Cart", back_populates="orders")


class Contact(Base):
    __tablename__ = "Contact"

    contact_id = Column(Integer, primary_key=True, index=True, autoincrement=True)
    name = Column(String(100))
    email = Column(String(100))
    subject = Column(String(200))
    message = Column(Text)
    created_at = Column(TIMESTAMP, server_default=func.now())