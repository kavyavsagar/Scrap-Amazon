# Scrap-Website
Any shopping website can easily scrapped by passing your search query and got the result instantly.


Create a class based data scraping engine to get data from one of the provided sources.

- 
Methods:
Class should include following methods:
  
a: Connection (Connecting to outward URLs, can use curl or fopen or getcontents, no external wrappers)
  
b: Scrapping (Get chunk of a data and discard the rest)
  
c: Parsing (Parse the data into sortable arrays)
  
d: Sorting (Sort based on different variables available in array)

- 


Working:
1. On page load there should a text input field with one submit button. 

2. When user type the query and submit the following routine should be followed:
  
a: Grab the query via Javascript (jQuery can be used) and use ajax method to send query to our class.
  
b: Class should connect to one of the provided URLs (after replacing required variables).
  
c: Scrap the data, parse it and sort it based on provided information
  
d: Write data into JSON and print it to grab it via Ajax.


3. Get the return data from Ajax and display it to use in friendly manner.

- 

Sources: (Choose any 1 of the following sources).

a. Souq.com
b. Alshop.com
c. Aliexpress.com
d. Amazon.com


- 
Example:
1. User type 'iphone' in the query box and submit.

2. You send query to your class using ajax.

3. You create query URL based on your source (e.g. http://www.amazon.com/s/?url=search-alias%3Daps&field-keywords=iphone)

4. Use your class method to first connect to url, than grab the data, retrieve the product name, prices (include currency), 
image and push them into an array

5. Sort the array by prices.
6. Convert array to json and print.

7. Grab data sent by PHP and display to user.

