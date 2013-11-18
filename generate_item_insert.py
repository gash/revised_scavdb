#!/usr/bin/python

first_numbers = [1, 18, 30, 44, 66, 86, 105, 125, 147, 165, 185, 201, 217, 235, 253, 269, 277]
#first_numbers = [302,1,24,45,67,87,110,133,157,181,201,225,247,270,287]
num_pages = len(first_numbers)-1
first_numbers.sort()
#print num_pages
last_number = first_numbers[-1]
first_numbers[-1] = first_numbers[-1]+1
#print first_numbers
page_number = 1;
for item in range(1,last_number+1):
    if(item == first_numbers[page_number]):
        page_number = page_number+1
#    print item, first_numbers[page_number]
    print "INSERT INTO items VALUES ("+str(item)+','+str(page_number)+",'n',NULL,NULL,NULL,unix_timestamp());"
