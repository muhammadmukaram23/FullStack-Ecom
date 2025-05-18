from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from typing import List

from app import crud, models, schemas
from app.database import get_db

router = APIRouter()


@router.post("/", response_model=schemas.Product, status_code=status.HTTP_201_CREATED)
def create_product(product: schemas.ProductCreate, db: Session = Depends(get_db)):
    # Check if category exists
    db_category = crud.get_category(db, category_id=product.category_id)
    if not db_category:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Category not found"
        )
    return crud.create_product(db=db, product=product)


@router.get("/", response_model=List[schemas.Product])
def read_products(skip: int = 0, limit: int = 100, db: Session = Depends(get_db)):
    products = crud.get_products(db, skip=skip, limit=limit)
    return products


@router.get("/category/{category_id}", response_model=List[schemas.Product])
def read_products_by_category(category_id: int, skip: int = 0, limit: int = 100, db: Session = Depends(get_db)):
    # Check if category exists
    db_category = crud.get_category(db, category_id=category_id)
    if not db_category:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Category not found"
        )
    products = crud.get_products_by_category(db, category_id=category_id, skip=skip, limit=limit)
    return products


@router.get("/{product_id}", response_model=schemas.Product)
def read_product(product_id: int, db: Session = Depends(get_db)):
    db_product = crud.get_product(db, product_id=product_id)
    if db_product is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Product not found"
        )
    return db_product


@router.put("/{product_id}", response_model=schemas.Product)
def update_product(product_id: int, product: schemas.ProductUpdate, db: Session = Depends(get_db)):
    # Check if product exists
    db_product = crud.get_product(db, product_id=product_id)
    if db_product is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Product not found"
        )
    
    # Check if category exists if category_id is provided
    if product.category_id is not None:
        db_category = crud.get_category(db, category_id=product.category_id)
        if not db_category:
            raise HTTPException(
                status_code=status.HTTP_404_NOT_FOUND,
                detail="Category not found"
            )
    
    return crud.update_product(db, product_id=product_id, product=product)


@router.delete("/{product_id}", response_model=schemas.Product)
def delete_product(product_id: int, db: Session = Depends(get_db)):
    db_product = crud.delete_product(db, product_id=product_id)
    if db_product is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Product not found"
        )
    return db_product


# Product Image endpoints
@router.post("/{product_id}/images", response_model=schemas.ProductImage)
@router.post("/{product_id}/images/", response_model=schemas.ProductImage)
def create_product_image(product_id: int, image: schemas.ProductImageCreate, db: Session = Depends(get_db)):
    # Check if product exists
    db_product = crud.get_product(db, product_id=product_id)
    if db_product is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Product not found"
        )
    
    print(f"Adding image URL: {image.image_url} to product ID: {product_id}")  # Debug print
    return crud.create_product_image(db=db, product_id=product_id, image=image)


@router.get("/{product_id}/images", response_model=List[schemas.ProductImage])
@router.get("/{product_id}/images/", response_model=List[schemas.ProductImage])
def read_product_images(product_id: int, db: Session = Depends(get_db)):
    # Check if product exists
    db_product = crud.get_product(db, product_id=product_id)
    if db_product is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Product not found"
        )
    
    return crud.get_product_images(db=db, product_id=product_id)


@router.delete("/images/{image_id}", response_model=schemas.ProductImage)
@router.delete("/images/{image_id}/", response_model=schemas.ProductImage)
def delete_product_image(image_id: int, db: Session = Depends(get_db)):
    db_image = crud.delete_product_image(db, image_id=image_id)
    if db_image is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Image not found"
        )
    return db_image