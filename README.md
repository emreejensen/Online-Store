GGC Online Store

Project Description
This website will provide GGC students a platform to exchange used items such computers, books, small furniture, electronics etc.  Students don’t need to login to view the items. But to sell or buy, they need to create an account and login. 
Before login, anyone should be able to browse for sale items. 

After user login, they can
•	post things they would like to sell (an item table with owner_ id, and buyer_id if sold)
•	purchase items they like 

Admin user will be able to login, delete/edit all users, delete/edit items for sale, check items sold, remove items if sold for more than 100 days, remove malicious users. 


1.	registration page: register a new user with first name, last name, email, phone, pw, confirm pw, security questions (tell user to make up their own question or you the developer provide questions), answer to security questions

2.	login page: email and pw to login, add forgot password link.  If they forgot pw, click the link or button, it should load the security questions, ask user to answer the security questions, if correct, provide input box to type new pw, and another input box to confirm new pw, and submit.  Then login with email and new pw. 

3.	After user login, show menu for these pages:
•	home page: welcome message, introduce how to use the website
•	I Want to Sell : provide user the opportunity to list item for sell, each item needs a pic, a short description, price; one user can list up to 5 items; if this user already listed items for sale, list all the items on this page
•	I Want to Buy: browser items (have all things displayed with checkbox so user can add an item to the shopping cart.
•	Transaction history: list items sold and purchased for this user
•	Update my profile(display current phone, email, pw, profile pic and allow user to change)
•	Logout 

4. for admin user
•	Display for sale items(belong to which user, price, pic, description) 
•	Display sold items in the past week or month(your decision): seller, buyer,  item name, price, item description
•	Display all user, be able to edit a user or remove malicious user
•	Allow admin to create announcements and push the announcements to user’s home page.
•	Add any other power you want the admin to have
•	Bonus: Update Admin Profile: this is the personal information of the admin user(note: the website could have more than one admin)
•	Logout

Here’s what you need to do:
•	Design your database table carefully, for users table, must have(id; registration_date, and other data from the registration form); for item table, must have (item_id; upload_date; sold_date, seller_id, buyer_id).
Step 1 
•	Complete all the static pages; create database table for users, complete the login page(student login and admin login).  Must use session for login. 
Step 2 
•	Complete the functions after student login (mainly buy and sell), create item table to store all the for-sale items.  
Step 3 
•	Complete the admin functions. 
•	Add cookies so user could choose UI(font size,  dark theme and a light themed text color and background color), and save login information   
•	Clean up everything, remover messages for developer, add style using html/css to all  the pages.   

Submission:
1.	please zip all the php files and the sql file from phpMyAdmin ( I need to be able to import your sql file and unzip your php file in my htdocs folder to make it to work)
2.	please submit the URL
3.	Please submit one or two videos to demonstrate the general user functions and the admin function

Bonus:
1.	Post most recently listed 5 items on the website home page
2.	Allow admin to select and post featured items on home page
3.	Allow user to search by date, by price etc.
4.	Other improvements you made 
Please specify the bonus you completed in D2L/Comment box for the final product submission.
