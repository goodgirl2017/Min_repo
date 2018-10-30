
USE cs6400_Spring18_team005 ;

-- Inserting 21 Users --
INSERT INTO User (username,password,first_name,last_name) VALUES ('michael@bluthco.com','michael123','Michael','Bluth');
INSERT INTO User (username,password,first_name,last_name) VALUES ('rtaylor@gatech.edu','password123','Robert','Taylor');
INSERT INTO User (username,password,first_name,last_name) VALUES ('dwilliamson@gatech.edu','password123','Daniel','Williamson');
INSERT INTO User (username,password,first_name,last_name) VALUES ('llopez@gatech.edu','password123','Luis','Lopez');
INSERT INTO User (username,password,first_name,last_name) VALUES ('pestrada@gatech.edu','password123','Patrick','Estrada');
INSERT INTO User (username,password,first_name,last_name) VALUES ('rwalker@gatech.edu','password123','Rodney','Walker');
INSERT INTO User (username,password,first_name,last_name) VALUES ('shenry@gatech.edu','password123','Sean','Henry');
INSERT INTO User (username,password,first_name,last_name) VALUES ('tfox@gatech.edu','password123','Thomas','Fox');
INSERT INTO User (username,password,first_name,last_name) VALUES ('jflowers@gatech.edu','password123','Jacob','Flowers');
INSERT INTO User (username,password,first_name,last_name) VALUES ('braymond@gatech.edu','password123','Bianca','Raymond');
INSERT INTO User (username,password,first_name,last_name) VALUES ('jcarroll@gatech.edu','password123','Julie','Carroll');
INSERT INTO User (username,password,first_name,last_name) VALUES ('jhernandez@gatech.edu','password123','Jane','Hernandez');
INSERT INTO User (username,password,first_name,last_name) VALUES ('crogers@gatech.edu','password123','Colleen','Rogers');
INSERT INTO User (username,password,first_name,last_name) VALUES ('efrank@gatech.edu','password123','Elizabeth','Frank');
INSERT INTO User (username,password,first_name,last_name) VALUES ('ahess@gatech.edu','password123','Alicia','Hess');
INSERT INTO User (username,password,first_name,last_name) VALUES ('tjohnson@gatech.edu','password123','Tara','Johnson');
INSERT INTO User (username,password,first_name,last_name) VALUES ('cchavez@gatech.edu','password123','Christine','Chavez');
INSERT INTO User (username,password,first_name,last_name) VALUES ('admin01@gtonline.com','admin123','Sharon','Lowery');
INSERT INTO User (username,password,first_name,last_name) VALUES ('admin02@gtonline.com','admin123','Gary','Turner');
INSERT INTO User (username,password,first_name,last_name) VALUES ('admin03@gtonline.com','admin123','Kristina','Scott');
INSERT INTO User (username,password,first_name,last_name) VALUES ('admin04@gtonline.com','admin123','Charles','James');
INSERT INTO User (username,password,first_name,last_name) VALUES ('user1','pass1','Danite','Kelor');
INSERT INTO User (username,password,first_name,last_name) VALUES ('user2','pass2','Dodra','Kiney');
INSERT INTO User (username,password,first_name,last_name) VALUES ('user3','pass3','Peran','Bishop');
INSERT INTO User (username,password,first_name,last_name) VALUES ('user4','pass4','Randy','Roran');
INSERT INTO User (username,password,first_name,last_name) VALUES ('user5','pass5','Ashod','Iankel');
INSERT INTO User (username,password,first_name,last_name) VALUES ('user6','pass6','Cany','Achant');
INSERT INTO User (username,password,first_name,last_name) VALUES ('admin1','opensesame','Riley','Fuiss');
INSERT INTO User (username,password,first_name,last_name) VALUES ('admin2','opensesayou','Tonnis','Kinser');

-- Inserting 21 RegularUsers --
INSERT INTO RegularUser (username) VALUES ('michael@bluthco.com');
INSERT INTO RegularUser (username) VALUES ('rtaylor@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('dwilliamson@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('llopez@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('pestrada@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('rwalker@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('shenry@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('tfox@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('jflowers@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('braymond@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('jcarroll@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('jhernandez@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('crogers@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('efrank@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('ahess@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('tjohnson@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('cchavez@gatech.edu');
INSERT INTO RegularUser (username) VALUES ('admin01@gtonline.com');
INSERT INTO RegularUser (username) VALUES ('admin02@gtonline.com');
INSERT INTO RegularUser (username) VALUES ('admin03@gtonline.com');
INSERT INTO RegularUser (username) VALUES ('admin04@gtonline.com');
INSERT INTO RegularUser (username) VALUES ('user3');
INSERT INTO RegularUser (username) VALUES ('user4');
INSERT INTO RegularUser (username) VALUES ('user5');
INSERT INTO RegularUser (username) VALUES ('user6');
INSERT INTO RegularUser (username) VALUES ('admin2');

-- Inserting AdministrativeUsers --
INSERT INTO AdministrativeUser (username,position) VALUES ('admin01@gtonline.com','1');
INSERT INTO AdministrativeUser (username,position) VALUES ('admin02@gtonline.com','2');
INSERT INTO AdministrativeUser (username,position) VALUES ('admin03@gtonline.com','3');
INSERT INTO AdministrativeUser (username,position) VALUES ('admin04@gtonline.com','4');
INSERT INTO AdministrativeUser (username,position) VALUES ('admin1','Technical Support');
INSERT INTO AdministrativeUser (username,position) VALUES ('admin2','Chief Techy');

-- Inserting 7 Categories --
INSERT INTO Category (categoryname) VALUES ('Art');
INSERT INTO Category (categoryname) VALUES ('Books');
INSERT INTO Category (categoryname) VALUES ('Sporting Goods');
INSERT INTO Category (categoryname) VALUES ('Home & Garden');
INSERT INTO Category (categoryname) VALUES ('Electronics');
INSERT INTO Category (categoryname) VALUES ('Toys');
INSERT INTO Category (categoryname) VALUES ('Other');


-- Inserting 21 Items --
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('michael@bluthco.com','Art','True','2','item1','daily moisturizer','4.0','3.0','5','100.0','2018-04-07 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('michael@bluthco.com','Books','False','3','item2','description 1','5.0','4.0','5','100.0','2018-04-08 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('rtaylor@gatech.edu','Electronics','True','4','item3','description 2','4.5','4.0','5','100.0','2018-04-09 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('rtaylor@gatech.edu','Home & Garden','False','5','item4','description 3','4.2','4.0','5','100.0','2018-04-10 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('dwilliamson@gatech.edu','Sporting Goods','True','1','item5','description 4','4.7','4.0','5','100.0','2018-04-11 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('dwilliamson@gatech.edu','Toys','False','2','item6','description 5','4.4','4.0','5','100.0','2018-04-12 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('llopez@gatech.edu','Other','False','3','item7','description 6','4.9','4.0','5','100.0','2018-04-13 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('llopez@gatech.edu','Art','True','2','item8','daily moisturizer 1','3.8','3.0','5','100.0','2018-04-14 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('pestrada@gatech.edu','Books','False','3','item9','description 7','4.9','4.0','5','100.0','2018-04-15 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('pestrada@gatech.edu','Electronics','True','4','item10','description 8','4.7','4.0','5','100.0','2018-04-16 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('rwalker@gatech.edu','Home & Garden','False','5','item11','description 9','4.8','4.0','5','100.0','2018-04-17 18:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('user3','Art','True','3','Danish Art Book','Delicious Danish Art','4.9','10','10','15.0','2018-04-05 15:33:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('user2','Electronics','False','4','Nikon D3','New and in box!','1800','1500','7','2000.0','2018-04-05 09:19:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('user1','Electronics','False','2','Canon Powershot','Point and shoot!','60.00','40.00','7','80.0','2018-04-01 14:14:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('admin2','Electronics','False','2','Garmin GPS','it is a navigator','50.0','25.0','7','75.0','2018-04-16 03:15:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('user4','Electronics','False','4','MacBook Pro','it is a very good white laptop from apple','1500','1000','7',null,'2018-04-16 01:01:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('user5','Electronics','False','3','Microsoft Surface','it is a very good black laptop from Microsoft','750','500','7','899','2018-04-16 06:00:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('admin1','Books','False','1','SQL in 10 Minutes','Learn SQL really fast!','10.0','5.0','7','12.0','2018-04-05 16:48:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('admin2','Books','False','2','SQL in 8 Minutes','Learn SQL even faster!','8','5','7','10','2018-04-08 10:01:00',null);
INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time,winner) VALUES ('user6','Sporting Goods','True','4','Pull-up Bar','Works on any door frame.','25','20','7','40','2018-04-09 22:09:00',null);


-- Inserting 42 Ratings --
INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('michael@bluthco.com','good stuff','4','12:00:30');
/*INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('michael@bluthco.com','very good stuff','4','16:50:22');*/
INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('rtaylor@gatech.edu','good stuff','4','16:50:22');
/*INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('rtaylor@gatech.edu','good stuff','4','12:00:30');*/
INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('dwilliamson@gatech.edu','good stuff','4','16:50:22');
/*INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('dwilliamson@gatech.edu','good stuff','4','11:21:55');*/
INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('llopez@gatech.edu','good stuff','4','11:21:55');
/*INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('llopez@gatech.edu','good stuff','4','12:00:30');*/
INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('pestrada@gatech.edu','good stuff','4','12:00:30');
/*INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('pestrada@gatech.edu','good stuff','4','11:21:55');*/
INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('rwalker@gatech.edu','good stuff','4','16:50:22');
/*INSERT INTO Rating (username,comments,number_of_stars,rate_time) VALUES ('rwalker@gatech.edu','good stuff','4','12:00:30');*/
INSERT INTO Rating (username,comments,number_of_stars,rate_time,ItemID) VALUES ('user5','Great for getting OMSCS coursework done.','5','2018-04-16 04:15:00','16');
INSERT INTO Rating (username,comments,number_of_stars,rate_time,ItemID) VALUES ('user4','Looks nice but underpowered.','2','2018-04-16 07:00:00','17');
INSERT INTO Rating (username,comments,number_of_stars,rate_time,ItemID) VALUES ('user3',' ','3','2018-04-16 08:00:00','17');
INSERT INTO Rating (username,comments,number_of_stars,rate_time,ItemID) VALUES ('user2','Great GPS!','5','2018-04-16 17:00:00','15');
INSERT INTO Rating (username,comments,number_of_stars,rate_time,ItemID) VALUES ('user3','Not so great GPS!','2','2018-04-16 18:00:00','15');
INSERT INTO Rating (username,comments,number_of_stars,rate_time,ItemID) VALUES ('user4','A favorite of mine.','4','2018-04-16 19:00:00','15');
INSERT INTO Rating (username,comments,number_of_stars,rate_time,ItemID) VALUES ('user1','Go for the Italian stuff instead.','1','2018-04-01 16:46:00','12');
INSERT INTO Rating (username,comments,number_of_stars,rate_time,ItemID) VALUES ('admin1','Not recommended.','1','2018-04-06 23:56:00','19');
INSERT INTO Rating (username,comments,number_of_stars,rate_time,ItemID) VALUES ('user1','This book is okay.','3','2018-04-07 13:32:00','19');
INSERT INTO Rating (username,comments,number_of_stars,rate_time,ItemID) VALUES ('user2','I learned SQL in 8 minutes!','5','2018-04-07 14:44:00','19');

-- Inserting 63 Bids --
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('michael@bluthco.com','2018-04-09 10:01:00','3.5');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('michael@bluthco.com','2018-04-10 10:01:00','4.0');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('michael@bluthco.com','2018-04-11 10:01:00','5');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('michael@bluthco.com','2018-04-12 10:01:00','6');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('michael@bluthco.com','2018-04-13 10:01:00','10');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('michael@bluthco.com','2018-04-14 10:01:00','11');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('rtaylor@gatech.edu','2018-04-09 10:01:00','7');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('rtaylor@gatech.edu','2018-04-10 10:01:00','8');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('rtaylor@gatech.edu','2018-04-11 10:01:00','9');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('rtaylor@gatech.edu','2018-04-12 10:01:00','10');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('rtaylor@gatech.edu','2018-04-13 10:01:00','11');
INSERT INTO Bid (username,bid_time,bid_amount) VALUES ('rtaylor@gatech.edu','2018-04-14 10:01:00','12');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user4','2018-04-15 10:01:00','30','15');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user5','2018-04-16 10:01:00','31','15');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user3','2018-04-17 10:01:00','33','15');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user4','2018-04-18 10:01:00','40','15');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user6','2018-04-19 10:01:00','45','15');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user6','2018-04-01 13:55:00','80','14');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user1','2018-04-04 08:37:00','1500','13');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user3','2018-04-04 09:15:00','1501','13');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user1','2018-04-04 12:27:00','1795','13');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user4','2018-04-08 20:20:00','20','20');
INSERT INTO Bid (username,bid_time,bid_amount,ItemID) VALUES ('user2','2018-04-09 21:15:00','25','20');