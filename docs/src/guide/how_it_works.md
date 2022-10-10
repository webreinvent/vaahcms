# How It Works

[[toc]]


## Description

### Background of the project
This section consists of the working of the frontend as well as the backend of the project in brief.

### Frontend of the Project

![Frontend of RxConnect](~@assets/rxconnect_frontend.png)


To access this application, there needs to be 3 types of users.
1. SynergEyes (Admin): No restrictions for accessing the application
2. Customers(Practice, doctors): Need to be registered first
3. Users

Once they register, a database will be created for the backend team of the company to call the registered customers. Once the customer is registered by filling the registration form, the Vantage system will provide 3 things:
1.  Account number
2.  PIN and
3.  Customer group code.

Without which the customer account will not be activated. Once activated, an URL will be sent to the customers to log in to their account, which will include their account number, username, and password over which they can change their passwords as well.

The first registered customer would be the admin, and he can have several users under him like patients, practice, or staff. All the users need to be registered users after they will fill the registration form.

There could be multiple users under a practice. They could be patients, staff members.
There is no option available to delete the users by admin. Only editing can be done.

Each product has some parameters which collectively will make a product group code to define the price of the product. Additional options are also there, which will change the product code and price.

When the user logins to add the product, he will land on the screen where he will find 3 options:
1.  Both eyes
2.  Left eye and
3.  Right eye.

If he selects both eyes option, then 2 boxes will be opened containing all the product code, parameters, additional options. If he selects the left eye, only 1 box will be opened for the left eye, the same goes for the right eye. There will be an input field in which he will add the patient details. They can be existing patients who have already bought from the admin else he will add new patients. After that, he will go to the ‘add to cart’ button, and a pop up will open. In the pop-up, there are 2 radio buttons given below, ‘ship to practice’ and ‘ship to patient’. If he selects ‘ship to practice’ a ‘continue shopping’ button will show up, then he can buy multiple orders. If he selects ‘ship to patient’ then he will land up to ‘order confirmation’ page by clicking the ‘buy now’ button.

### Backend of the Project

![Backend of RxConnect](~@assets/rxconnect_backend.png)

The backend of the project is the portion which is basically available for the Admin, where he has the full capability to set, manage all the operations related to the application as well as related to the users.

It has basically three important section
1. Manage User
2. Manage Account
3. Manage New Account

## Scope of the project

*  This project consists of the following important sections, which I have shown in a diagram and all the
   sections have their unique functionality, I have mentioned in their respective page sections.
*  I have also mentioned all the technologies used, library and plugins used with their version.
*  This application will interact with the 3 databases using API and it is working seamlessly.
*  I have also included here the use case diagram of the RxConnect which is the simplest way to
   briefly describe the user's interaction with the system and with different use cases.


## Use Case for RxConnect

![Use Case For RxConnect](~@assets/rxconnect_ufd_1.png)

## DB Schema

![DB Schema For RxConnect](~@assets/db_schema.png)

