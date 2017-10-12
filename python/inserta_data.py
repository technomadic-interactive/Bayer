import MySQLdb
import time
import re
import os
db = MySQLdb.connect("localhost","root","Ro9311o/","technomadic" )
#cursor = db.cursor()
with open ("data_decoded.txt", "r") as myfile:
	data = myfile.readlines()
	for line in data:
		line.strip()
		#print line
		tag_id = re.search("\'(.{16})\'",line)
		date = re.search("\'(.{10}) ",line)
		time = re.search("(.{8})\.",line)
		temp = re.search("\'(.{6}),",line)
		x = re.search("\'(.{6}),(.+?),",line)
		y = re.search("\'(.{6}),(.+?),(.+?),",line)
		z = re.search("\'(.{6}),(.+?),(.+?),(.+?),",line)
		battery = re.search(",(.{4})\'",line)
		print tag_id.group(1)
		print date.group(1)
		print time.group(1)
		print temp.group(1)
		print x.group(2)
		print y.group(3)
		print z.group(4)
		print battery.group(1)
		cursor=db.cursor()
		sql = "INSERT IGNORE INTO tbl_alarmas values(NULL,'"+time.group(1)+"','"+date.group(1)+"',"+tag_id.group(0)+","+temp.group()+"','"+x.group(2)+"','"+y.group(3)+"','"+z.group(4)+"','"+battery.group(1)+"')"
		print sql
		cursor.execute(sql,)
		db.commit()
		
#cursor=db.cursor()
#sql = "INSERT IGNORE INTO tbl_alarmas values(NULL,'"+time.group(1)+"','"+date.group(1)+"',"+tag_id.group(0)+","+temp.group()+"','"+x.group(2)+"','"+y.group(3)+"','"+z.group(4)+"','"+battery.group(1)+"')"
#print sql
#cursor.execute(sql,)
#db.commit()
cursor.close()
db.close()
