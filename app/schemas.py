from typing import List, Optional
from datetime import datetime
from pydantic import BaseModel, EmailStr, Field, validator
from decimal import Decimal


# User Schemas
class UserBase(BaseModel):
    user_name: str
    user_email: EmailStr
    user_age: int


class UserCreate(UserBase):
    user_password: str


class UserUpdate(BaseModel):
    user_name: Optional[str] = None
    user_email: Optional[EmailStr] = None
    user_password: Optional[str] = None
    user_age: Optional[int] = None


class UserLogin(BaseModel):
    email: EmailStr
    password: str


class User(UserBase):
    user_id: int

    class Config:
        orm_mode = True


# Category Schemas
class CategoryBase(BaseModel):
    category_name: str


class CategoryCreate(CategoryBase):
    pass


class CategoryUpdate(BaseModel):
    category_name: Optional[str] = None


class Category(CategoryBase):
    category_id: int

    class Config:
        orm_mode = True


# Product Image Schemas
class ProductImageBase(BaseModel):
    image_url: str


class ProductImageCreate(ProductImageBase):
    pass


class ProductImage(ProductImageBase):
    image_id: int
    product_id: int

    class Config:
        orm_mode = True


# Product Schemas
class ProductBase(BaseModel):
    product_name: str
    product_description: str
    product_price: Decimal
    category_id: int


class ProductCreate(ProductBase):
    pass


class ProductUpdate(BaseModel):
    product_name: Optional[str] = None
    product_description: Optional[str] = None
    product_price: Optional[Decimal] = None
    category_id: Optional[int] = None


class Product(ProductBase):
    product_id: int
    images: List[ProductImage] = []

    class Config:
        orm_mode = True


# Cart Item Schemas
class CartItemBase(BaseModel):
    product_id: int
    quantity: int = 1


class CartItemCreate(CartItemBase):
    pass


class CartItemUpdate(BaseModel):
    quantity: Optional[int] = None


class CartItem(CartItemBase):
    id: int
    cart_id: int
    product: Product

    class Config:
        orm_mode = True


# Cart Schemas
class CartBase(BaseModel):
    user_id: int


class CartCreate(CartBase):
    pass


class Cart(CartBase):
    cart_id: int
    cart_items: List[CartItem] = []

    class Config:
        orm_mode = True


# Order Schemas
class OrderBase(BaseModel):
    user_id: int
    cart_id: int
    user_address: str
    payment_method: Optional[str] = "Cash on Delivery"


class OrderCreate(OrderBase):
    pass


class Order(OrderBase):
    order_id: int
    order_date: datetime
    cart: Optional[Cart] = None
    user: Optional[User] = None

    class Config:
        orm_mode = True


# Contact Schemas
class ContactBase(BaseModel):
    name: str
    email: EmailStr
    subject: str
    message: str


class ContactCreate(ContactBase):
    pass


class Contact(ContactBase):
    contact_id: int
    created_at: datetime

    class Config:
        orm_mode = True


# Wishlist Item Schemas
class WishlistItemBase(BaseModel):
    user_id: int
    product_id: int


class WishlistItemCreate(WishlistItemBase):
    pass


class WishlistItem(WishlistItemBase):
    id: int
    created_at: datetime
    product: Optional[Product] = None

    class Config:
        orm_mode = True