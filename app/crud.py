from sqlalchemy.orm import Session
from sqlalchemy.exc import IntegrityError
from fastapi import HTTPException, status
from passlib.context import CryptContext
import uuid
from typing import List, Optional

from app import models, schemas

# Password context for hashing passwords
pwd_context = CryptContext(schemes=["bcrypt"], deprecated="auto")


# Verify password function
def verify_password(plain_password, hashed_password):
    return pwd_context.verify(plain_password, hashed_password)


# User CRUD operations
def get_user(db: Session, user_id: int):
    return db.query(models.User).filter(models.User.user_id == user_id).first()


def get_user_by_email(db: Session, email: str):
    return db.query(models.User).filter(models.User.user_email == email).first()


def get_users(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.User).offset(skip).limit(limit).all()


def create_user(db: Session, user: schemas.UserCreate):
    hashed_password = pwd_context.hash(user.user_password)
    db_user = models.User(
        user_name=user.user_name,
        user_email=user.user_email,
        user_password=hashed_password,
        user_age=user.user_age,
    )
    db.add(db_user)
    db.commit()
    db.refresh(db_user)
    return db_user


def update_user(db: Session, user_id: int, user: schemas.UserUpdate):
    db_user = get_user(db, user_id)
    if not db_user:
        return None

    update_data = user.dict(exclude_unset=True)
    
    if "user_password" in update_data:
        update_data["user_password"] = pwd_context.hash(update_data["user_password"])
    
    for key, value in update_data.items():
        setattr(db_user, key, value)
    
    db.commit()
    db.refresh(db_user)
    return db_user


def delete_user(db: Session, user_id: int):
    db_user = get_user(db, user_id)
    if not db_user:
        return None
    
    db.delete(db_user)
    db.commit()
    return db_user


# Category CRUD operations
def get_category(db: Session, category_id: int):
    return db.query(models.Category).filter(models.Category.category_id == category_id).first()


def get_categories(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.Category).offset(skip).limit(limit).all()


def create_category(db: Session, category: schemas.CategoryCreate):
    db_category = models.Category(category_name=category.category_name)
    db.add(db_category)
    db.commit()
    db.refresh(db_category)
    return db_category


def update_category(db: Session, category_id: int, category: schemas.CategoryUpdate):
    db_category = get_category(db, category_id)
    if not db_category:
        return None
    
    update_data = category.dict(exclude_unset=True)
    for key, value in update_data.items():
        setattr(db_category, key, value)
    
    db.commit()
    db.refresh(db_category)
    return db_category


def delete_category(db: Session, category_id: int):
    db_category = get_category(db, category_id)
    if not db_category:
        return None
    
    db.delete(db_category)
    db.commit()
    return db_category


# Product CRUD operations
def get_product(db: Session, product_id: int):
    return db.query(models.Product).filter(models.Product.product_id == product_id).first()


def get_products(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.Product).offset(skip).limit(limit).all()


def get_products_by_category(db: Session, category_id: int, skip: int = 0, limit: int = 100):
    return db.query(models.Product).filter(models.Product.category_id == category_id).offset(skip).limit(limit).all()


def create_product(db: Session, product: schemas.ProductCreate):
    db_product = models.Product(
        product_name=product.product_name,
        product_description=product.product_description,
        product_price=product.product_price,
        category_id=product.category_id,
    )
    db.add(db_product)
    db.commit()
    db.refresh(db_product)
    return db_product


def update_product(db: Session, product_id: int, product: schemas.ProductUpdate):
    db_product = get_product(db, product_id)
    if not db_product:
        return None
    
    update_data = product.dict(exclude_unset=True)
    for key, value in update_data.items():
        setattr(db_product, key, value)
    
    db.commit()
    db.refresh(db_product)
    return db_product


def delete_product(db: Session, product_id: int):
    db_product = get_product(db, product_id)
    if not db_product:
        return None
    
    db.delete(db_product)
    db.commit()
    return db_product


# Product Image CRUD operations
def create_product_image(db: Session, product_id: int, image: schemas.ProductImageCreate):
    db_image = models.ProductImage(product_id=product_id, image_url=image.image_url)
    db.add(db_image)
    db.commit()
    db.refresh(db_image)
    return db_image


def get_product_images(db: Session, product_id: int):
    return db.query(models.ProductImage).filter(models.ProductImage.product_id == product_id).all()


def delete_product_image(db: Session, image_id: int):
    db_image = db.query(models.ProductImage).filter(models.ProductImage.image_id == image_id).first()
    if not db_image:
        return None
    
    db.delete(db_image)
    db.commit()
    return db_image


# Cart CRUD operations
def get_cart(db: Session, cart_id: int):
    return db.query(models.Cart).filter(models.Cart.cart_id == cart_id).first()


def get_active_cart_by_user(db: Session, user_id: int):
    # Get cart that has not been converted to order yet
    cart = db.query(models.Cart).filter(
        models.Cart.user_id == user_id,
        ~models.Cart.cart_id.in_(db.query(models.Order.cart_id))
    ).first()
    
    if not cart:
        # Create new cart if none exists
        cart = create_cart(db, schemas.CartCreate(user_id=user_id))
    
    return cart


def create_cart(db: Session, cart: schemas.CartCreate):
    db_cart = models.Cart(
        user_id=cart.user_id
    )
    db.add(db_cart)
    db.commit()
    db.refresh(db_cart)
    return db_cart


# Cart Item CRUD operations
def get_cart_items(db: Session, cart_id: int):
    return db.query(models.CartItem).filter(models.CartItem.cart_id == cart_id).all()


def add_cart_item(db: Session, cart_id: int, cart_item: schemas.CartItemCreate):
    # Check if product exists
    product = db.query(models.Product).filter(models.Product.product_id == cart_item.product_id).first()
    if not product:
        raise HTTPException(status_code=404, detail="Product not found")
    
    # Check if item already exists in cart
    existing_item = db.query(models.CartItem).filter(
        models.CartItem.cart_id == cart_id,
        models.CartItem.product_id == cart_item.product_id
    ).first()
    
    if existing_item:
        # Update quantity
        existing_item.quantity += cart_item.quantity
        db.commit()
        db.refresh(existing_item)
        return existing_item
    
    # Create new cart item
    db_cart_item = models.CartItem(
        cart_id=cart_id,
        product_id=cart_item.product_id,
        quantity=cart_item.quantity
    )
    db.add(db_cart_item)
    db.commit()
    db.refresh(db_cart_item)
    return db_cart_item


def update_cart_item(db: Session, item_id: int, cart_item: schemas.CartItemUpdate):
    db_cart_item = db.query(models.CartItem).filter(models.CartItem.id == item_id).first()
    if not db_cart_item:
        return None
    
    update_data = cart_item.dict(exclude_unset=True)
    for key, value in update_data.items():
        setattr(db_cart_item, key, value)
    
    db.commit()
    db.refresh(db_cart_item)
    return db_cart_item


def delete_cart_item(db: Session, item_id: int):
    db_cart_item = db.query(models.CartItem).filter(models.CartItem.id == item_id).first()
    if not db_cart_item:
        return None
    
    db.delete(db_cart_item)
    db.commit()
    return db_cart_item


# Order CRUD operations
def create_order(db: Session, order: schemas.OrderCreate):
    # Check if cart exists and is not already ordered
    cart = db.query(models.Cart).filter(models.Cart.cart_id == order.cart_id).first()
    if not cart:
        raise HTTPException(status_code=404, detail="Cart not found")
    
    # Check if cart is already ordered
    existing_order = db.query(models.Order).filter(models.Order.cart_id == order.cart_id).first()
    if existing_order:
        raise HTTPException(status_code=400, detail="Cart is already ordered")
    
    # Create new order
    db_order = models.Order(
        user_id=order.user_id,
        cart_id=order.cart_id,
        user_address=order.user_address,
        payment_method=order.payment_method
    )
    db.add(db_order)
    db.commit()
    db.refresh(db_order)
    return db_order


def get_order(db: Session, order_id: int):
    return db.query(models.Order).filter(models.Order.order_id == order_id).first()


def get_user_orders(db: Session, user_id: int, skip: int = 0, limit: int = 100):
    return db.query(models.Order).filter(models.Order.user_id == user_id).offset(skip).limit(limit).all()


def get_orders(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.Order).offset(skip).limit(limit).all()


# Contact CRUD operations
def create_contact(db: Session, contact: schemas.ContactCreate):
    db_contact = models.Contact(
        name=contact.name,
        email=contact.email,
        subject=contact.subject,
        message=contact.message
    )
    db.add(db_contact)
    db.commit()
    db.refresh(db_contact)
    return db_contact


def get_contact(db: Session, contact_id: int):
    return db.query(models.Contact).filter(models.Contact.contact_id == contact_id).first()


def get_contacts(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.Contact).order_by(models.Contact.created_at.desc()).offset(skip).limit(limit).all()


# Wishlist CRUD operations
def get_wishlist_item(db: Session, user_id: int, product_id: int):
    return db.query(models.WishlistItem).filter(
        models.WishlistItem.user_id == user_id,
        models.WishlistItem.product_id == product_id
    ).first()


def get_wishlist_items_by_user(db: Session, user_id: int):
    return db.query(models.WishlistItem).filter(models.WishlistItem.user_id == user_id).all()


def create_wishlist_item(db: Session, wishlist_item: schemas.WishlistItemCreate):
    # Check if item already exists in wishlist
    existing_item = get_wishlist_item(db, wishlist_item.user_id, wishlist_item.product_id)
    if existing_item:
        return existing_item
    
    # Create new wishlist item
    db_item = models.WishlistItem(
        user_id=wishlist_item.user_id,
        product_id=wishlist_item.product_id
    )
    db.add(db_item)
    db.commit()
    db.refresh(db_item)
    return db_item


def delete_wishlist_item(db: Session, user_id: int, product_id: int):
    item = get_wishlist_item(db, user_id, product_id)
    if not item:
        return False
    
    db.delete(item)
    db.commit()
    return True