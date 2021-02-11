# CSC 306 Final

## Instructions

1. Clone repo.
2. Run docker-compose up -d --build

__Access web server__: localhost:80

__Access phpmyadmin__: localhost:8080

## Default Configuration
Default MySQL information

container name: db

Username: root

Password: NOTPRODUCTION

## Use

Project consist of a small mock e-commerce site developed using PHP and MySQL that specializes in the sale of board games. A database is prepopulated with data for different board games. 

Database entities consist of the following:

- Store Product
  - PRODUCT ID
  - PRODUCT_NAME
  - PRODUCT DESC
  - PRODUCT COST
- Store Customer
  - Customer ID
  - First Name
  - Last Name
  - Email
  - Address
  - City
  - State
  - Zip
- Store Order
  - Order ID
  - Date
  - Customer ID
- Store Order Items
  - Order ID
  - Item ID
  - Quantity
  
Web site consist of the following pages/views
- Store Page
- Customer Details Page
- Order Completion Page
- Error Page
- My Cart Page


## __WARNING__
This was created to use in a learning/dev environment (specifically to complete a final project for a PHP and Web Development academic course. Does not use best practices for a production deployment. Modifications will be needed to run in productions. Changes MySql authentication method back to native.
