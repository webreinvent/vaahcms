# Login & Registration Page

[[toc]]

## Purpose
There are three types of view in RxConnect:

- Public view: Accessible without login (Front page, Calculator page, rebates page,etc,.)
- App View: Only accessible with login
- Backend View: Only visible to users who have permission (Admin, Customer Care, etc,.)

The user should be able to come to the login page and navigate to public pages freely and if the user is logs in then based on the permissions the user have they should be taken to either backend view or to the app view.


## Solution
![login_ufd](~@assets/login_ufd.png)

## Assumption
- Users must have valid credentials (valid Email id and valid Password). If they don't have valid
  credentials in that case users are not able to access the application.
- User has to fill the [New Account Registration form](https://rxconnect.synergeyes.com/public/#/new-account-registration).

## Some important features of New Account Application page
The account registration form is divided into 7 sub-sections like:
### Practice Information
*  This will contain the basic information of the practice like his name, email, phone number.
 ```diff
- Primary Contact Name - don't understand the usage of primary and difference between Name of Practice and Primary Contact Name
- Primary Practitioner - who is Primary Practitioner
- Primary Practitioner License 
```

### Products Interested
*  Practitioner needs to check the box of product in which he is interesting to do practice and he can
   select more than one option at a time.

### Shipping Address
*  This section includes the shipping contact name, email, phone number, full address with zip code.
*  Also give an option for the shipping preferences whether they want paperless invoice statement or them
   want printed invoice statement
*  In the shipping country field the default country should be the USA.
*  In case of USA it accepts the correct/ accurate shipping address.

```diff
-E-Invoicing Frequency
```

### Billing Address
*  The next section is for the billing address, billing address may or may not be same as a shipping address  
   so that why here is it given for the practitioners who have different shipping and billing address.
*  They have both the option if in case if the practitioner has the same shipping and billing address
   they just need to check the checkbox of the billing address the same as the shipping address.
*  Then all the fields will be filled automatically the same as the shipping address.
*  Otherwise users have to fill it and it contains a full address with zipping and phone number.
*  In billing country field also the default country should be the USA.
*  In case of USA it accepts the correct/ accurate billing address.

### Additional Information
*  This section will contain the information about the numbers of doctors, staffs and the number of
   contact lens exams each week.
*  And also take information whether the practitioner operates from hospital/medical center on not.
```diff
-according to which detail the customer group code is generated.
```

### How did you hear about us?
*  Here practitioner have to fill from where did he know about this Synergeyes RxConnect from the give option and it is optional.

### Agreements to terms and conditions
*  This is the last step where user have to put his name in a box and check the checkbox of Agreement to the term and condition box if he agrees with it.<br><br>

*  Once the customer is registered by filling the registration form, Vantage system will provide the following things:-
    1. Account number
    2. PIN
    3. Customer group code
*  Database will be created for the backend team of the company to call the registered customers.
*  Then the user has to fill the [user registration form](https://rxconnect.synergeyes.com/public/#/registration) with this data.



## Some important features of *User Registration page*
*  Here user has to fill the following information like :
    *  SynergEyes Account Number
    *  SynergEyes PIN
    *  First Name
    *  Last Name
    *  Email Address
    *  Passwords

*  **If a customer forgets their Account number or don't have Account number:**
    * In this case, he needs to register again by filling the [new account registration form](https://rxconnect.synergeyes.com/public/#/new-account-registration) and Vantage
      the system will provide all the three things to the customer.<br><br>

*  **If a customer forgets their PIN or don't have PIN:**
    * In this case, he gets an option to fill his account number by clicking on the [link](https://rxconnect.synergeyes.com/public/#/registration)
      which is given below the Pin box.
    *  After that, the admin will get an email regarding this and he will inform the PIN to the
       user.
    *  If they have already entered it in the first field just have this account number prefilled. Once
       they enter and submit, in the case also an email with PIN will receive by the admin.
    *  But the notification received by the admin will not show the full primary contact only shows first and last letter of the user name. It is in coded form to maintain the privacy of the customer.<br><br>

* **What is Customer group code?**
    *  It is code which is automatically generated at a time when the new user fills the new account
       registration form.
    *  It is also generated by the Vantage system automatically like the account number and the pin
       number.
    *  The main difference is customer group code is unique and it is nonchangeable like the account
       number.
    *  This code is unique and it varies from company to company, basically depends on which type of
       the company is small, medium, and large.
    *  Due to this code the price of the lenses also vary.<br><br>

*  Without these details, the customer account will not be activated.
*  Once account activated, an URL will be sent to the customers to log in their account which will include their:-
    1. Account number
    2. Username
    3. Password
```diff
-Is this password is the same as what user set while filling the registration form? and is this appear in coded form or not?
```

*  By using the above username and password use can [login](https://rxconnect.synergeyes.com/public/#/) successfully into their account.


## As-Is Registration Process

![Registration_Process_](~@assets/registration_process.png)
**Note**-
1.  **For US customers**: There is an address validation for shipping and billing addresses.
2.   Account Number and PIN should be unique for all the users.
3.   **For International Orders** remove the Call: line with a number listed. They cannot call, they can only email.



## Important Conditions For Forgot Password Page

*  If user forget their password, in this condition also he/she must have to enter the valid and the
   registered email id in the email section.
*  If user enter the wrong email id or id which is not registered in that case he will get an *alert
   message* regarding this.
*  If user enter the right email address, in that case, he will get a mail of reset password, which contain
   the link of the reset password page and this mail will be received by both users.
*  In Reset password page, the new password and confirm a password which is entered by the user must be
   matched.
*  After successfully resetting the password user will be directed to the login page.


## As-Is Forgot Password Process

![Forgot_Password_Process](~@assets/forgot_password_process.png)

## To-Be Login Process

![Flow_Diagram_Of_Login_Process](~@assets/flow_diagram_of_login_process.png)



| **Page Name** | **Image**|
| ------ | ------ |
| **1. New Registration Page (top)**   | ![image](~@assets/new_account_registration_top.png) |
| **2. New Registration Page (Bottom**) | ![image](~@assets/new_account_registration_bottom.png) |
| **3. User Registration Page** | ![image](~@assets/user_registration.png)| 
| **4. Login Page** | ![image](~@assets/login_page.png) | 
| **5. Forgot Password Page** | ![image](~@assets/forgot_password_page.png) | 
| **6. Reset Password Page** | ![image](~@assets/reset_password_page.png)| 
| | |
