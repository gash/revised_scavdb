#!/usr/bin/python

first_numbers = [318,1,21,40,58,79,98,115,137,157,176,194,214,228,247,269,285,299]
#first_numbers = [351,1,17,32,51,70,86,105,125,142,161,177,193,211,231,253,273,290,310,331]
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
    print_page_number = page_number #For 2013 only
    if( page_number >= 13): #For 2013 only
        print_page_number = page_number+1  #For 2013 only
#    print item, first_numbers[page_number], print_page_number
    if( print_page_number > 14):
        print "UPDATE items SET page="+str(print_page_number)+" WHERE item_id="+str(item)+";"
#    print "INSERT INTO items VALUES ("+str(item)+','+str(page_number)+",'n',NULL,NULL,NULL,unix_timestamp());"
