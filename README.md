
**Author**: This is a group project of Min Ni, Bowen Gong, Tingting Li and Liu Su.

**Prerequesite**:
- Platform: Bitnami 7.1, downloaded from [a link](https://bitnami.com/stacks/infrastructure)
- Language Level: PHP 7.1


## 1 Introduction

This is an information system application to support a new online auction system called GTBay.

## 2 How to get started?

### 2.1 Login to phpMyAdmin
After you installed Binami and open phpMyAdmin, login as 'root' to phpMyAdmin [a link](http://127.0.0.1:80/phpmyadmin/) using the password you entered during the Bitnami installation phase. 

### 2.2 Import database and original seed data
Import the SQL schema from [(SQL schema)](sql/team005_p2_schema.sql), and then import the seed data [(SQL seed data)](sql/team005_p3_seed_data.sql) to the phpMyAdmin by clicking the "Import" button on the menu.


### 2.3 Restart Apahce server usging Bitnami WAMP Stack Tool

### 2.4 Lauch the URL
Now, we come to the step of lauching URL [a link](http://localhost:8080/Website-Development-of-an-Auction-System---GTBay-/login.php). From here, you can experience all the functions provided by this website listed below.

## 2 Functions provided by the website
- registration with a unique username
- login with existing username
- main menu as an admin to see all the users and items information 
- main mune as a normal user
- search for item based on keyword, price range, category, condition etc.
- view item: view the item details for any items from searching results
- rate itme: each user can rate an item once by giving stars and comments
- bit item: you can bid any item that auction has not ended with price at least $1 higher than the existing bidding price
- sell items: you need to provide category, condition, starting bid amount, minmum sale price, auction lenght, get it now price, item id and returns accepted or not to selll an item successfully
- logout from any web pages






