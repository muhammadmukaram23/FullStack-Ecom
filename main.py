from fastapi import FastAPI, Depends, HTTPException, status
from fastapi.middleware.cors import CORSMiddleware
from sqlalchemy.orm import Session
import uvicorn

from app.database import get_db, engine
from app import models, schemas, crud
from app.routers import users, products, categories, carts, orders, contacts, wishlists

# Create all tables in the database
models.Base.metadata.create_all(bind=engine)

app = FastAPI(title="E-Commerce API", version="1.0.0")

# Configure CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Include routers
app.include_router(users.router, prefix="/api/users", tags=["Users"])
app.include_router(products.router, prefix="/api/products", tags=["Products"])
app.include_router(categories.router, prefix="/api/categories", tags=["Categories"])
app.include_router(carts.router, prefix="/api/carts", tags=["Carts"])
app.include_router(orders.router, prefix="/api/orders", tags=["Orders"])
app.include_router(contacts.router, prefix="/api/contacts", tags=["Contacts"])
app.include_router(wishlists.router, tags=["Wishlists"])


@app.get("/", tags=["Root"])
async def root():
    return {"message": "Welcome to the E-Commerce API"}


if __name__ == "__main__":
    uvicorn.run("main:app", host="0.0.0.0", port=8000, reload=True)