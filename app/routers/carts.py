from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from typing import List

from app import crud, models, schemas
from app.database import get_db

router = APIRouter()


@router.post("/", response_model=schemas.Cart, status_code=status.HTTP_201_CREATED)
def create_cart(cart: schemas.CartCreate, db: Session = Depends(get_db)):
    # Check if user exists
    db_user = crud.get_user(db, user_id=cart.user_id)
    if not db_user:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="User not found"
        )
    return crud.create_cart(db=db, cart=cart)


@router.get("/user/{user_id}", response_model=schemas.Cart)
def get_active_cart(user_id: int, db: Session = Depends(get_db)):
    # Check if user exists
    db_user = crud.get_user(db, user_id=user_id)
    if not db_user:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="User not found"
        )
    
    cart = crud.get_active_cart_by_user(db=db, user_id=user_id)
    return cart


@router.get("/{cart_id}", response_model=schemas.Cart)
def read_cart(cart_id: int, db: Session = Depends(get_db)):
    db_cart = crud.get_cart(db, cart_id=cart_id)
    if db_cart is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Cart not found"
        )
    return db_cart


# Cart Item endpoints
@router.post("/{cart_id}/items", response_model=schemas.CartItem)
def add_cart_item(cart_id: int, item: schemas.CartItemCreate, db: Session = Depends(get_db)):
    # Check if cart exists
    db_cart = crud.get_cart(db, cart_id=cart_id)
    if not db_cart:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Cart not found"
        )
    
    try:
        return crud.add_cart_item(db=db, cart_id=cart_id, cart_item=item)
    except HTTPException as e:
        raise e
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail=str(e)
        )


@router.get("/{cart_id}/items", response_model=List[schemas.CartItem])
def read_cart_items(cart_id: int, db: Session = Depends(get_db)):
    # Check if cart exists
    db_cart = crud.get_cart(db, cart_id=cart_id)
    if not db_cart:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Cart not found"
        )
    
    return crud.get_cart_items(db=db, cart_id=cart_id)


@router.put("/items/{item_id}", response_model=schemas.CartItem)
def update_cart_item(item_id: int, item: schemas.CartItemUpdate, db: Session = Depends(get_db)):
    db_item = crud.update_cart_item(db, item_id=item_id, cart_item=item)
    if db_item is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Cart item not found"
        )
    return db_item


@router.delete("/items/{item_id}", response_model=schemas.CartItem)
def delete_cart_item(item_id: int, db: Session = Depends(get_db)):
    db_item = crud.delete_cart_item(db, item_id=item_id)
    if db_item is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Cart item not found"
        )
    return db_item