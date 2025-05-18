from fastapi import APIRouter, Depends, HTTPException, status, Response
from sqlalchemy.orm import Session
from sqlalchemy.exc import SQLAlchemyError
from typing import List, Optional
import logging

from .. import crud, schemas, models
from ..database import get_db

router = APIRouter(
    prefix="/api/wishlists",
    tags=["wishlists"],
    responses={404: {"description": "Not found"}},
)

@router.get("/", response_model=List[schemas.WishlistItem])
def get_user_wishlist(user_id: int, db: Session = Depends(get_db)):
    """
    Retrieve all wishlist items for a specific user.
    """
    wishlist_items = crud.get_wishlist_items_by_user(db, user_id)
    return wishlist_items

@router.post("/", response_model=schemas.WishlistItem, status_code=status.HTTP_201_CREATED)
def add_to_wishlist(wishlist_item: schemas.WishlistItemCreate, db: Session = Depends(get_db)):
    """
    Add a product to the user's wishlist.
    """
    try:
        # Check if user exists
        user = crud.get_user(db, user_id=wishlist_item.user_id)
        if not user:
            raise HTTPException(status_code=404, detail="User not found")
        
        # Check if product exists
        product = crud.get_product(db, product_id=wishlist_item.product_id)
        if not product:
            raise HTTPException(status_code=404, detail="Product not found")
        
        # Check if item already exists in wishlist
        existing_item = crud.get_wishlist_item(db, user_id=wishlist_item.user_id, product_id=wishlist_item.product_id)
        if existing_item:
            return existing_item  # Item already in wishlist
        
        # Add to wishlist
        return crud.create_wishlist_item(db, wishlist_item)
    except SQLAlchemyError as e:
        logging.error(f"Database error: {str(e)}")
        raise HTTPException(status_code=500, detail="Database error occurred")

@router.get("/{user_id}/{product_id}", response_model=schemas.WishlistItem)
def check_wishlist_item(user_id: int, product_id: int, db: Session = Depends(get_db)):
    """
    Check if a specific product is in a user's wishlist.
    """
    item = crud.get_wishlist_item(db, user_id=user_id, product_id=product_id)
    if not item:
        raise HTTPException(status_code=404, detail="Item not in wishlist")
    return item

@router.delete("/{user_id}/{product_id}", status_code=status.HTTP_204_NO_CONTENT)
def remove_from_wishlist(user_id: int, product_id: int, db: Session = Depends(get_db)):
    """
    Remove a product from the user's wishlist.
    """
    try:
        result = crud.delete_wishlist_item(db, user_id=user_id, product_id=product_id)
        if not result:
            raise HTTPException(status_code=404, detail="Item not found in wishlist")
        return Response(status_code=status.HTTP_204_NO_CONTENT)
    except SQLAlchemyError as e:
        logging.error(f"Database error: {str(e)}")
        raise HTTPException(status_code=500, detail="Database error occurred") 