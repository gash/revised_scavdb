#!/usr/bin/python

import re
import MySQLdb

file = open("tex_items.txt","r")
items = file.readlines()
new_item = 1
item_number = 1
for i in range(0,len(items)):
    if(new_item == 1):
        item = items[i]
    else:
        item = item + items[i]

    if(i < len(items)-1):
        match_find = re.search('^\d+\.\t',items[i+1])
        if(match_find == None):
            new_item = 0
        else:
            new_item = 1
            item_number = item_number+1
            description = MySQLdb.escape_string(str(item[match_find.end():-1]))
            print "UPDATE items SET mtime=unix_timestamp(), description='"+description+"' WHERE item_id="+str(item_number-1)+";"

