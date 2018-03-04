#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb

def connect_to_database():
	global conn,cursor
	conn = MySQLdb.connect (host = "localhost",user = "root",passwd = "",db = "mini_project")
	cursor = conn.cursor ()
	cursor = conn.cursor(MySQLdb.cursors.DictCursor)

def reload_messages(c_id1):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM chat where ToUserID='%s' ORDER BY Time ASC"%(c_id1)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		for row in results:
			divid=row['ID']
			fromuser=row["FromUser"]
			time=row["Time"]
			datetime=time.strftime('%H : %M')
			text=row['Text']
			print("""<div id="%s"  class="alert alert-info alert-dismissable fade in" ><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a> %s | <strong>%s </strong> : %s </div><br/>"""%(divid,divid,datetime,fromuser,text))
	except:
		conn.rollback()
		print("Try again !")
	conn.close()

def delete_message(c_id1):
	global cursor,conn
	connect_to_database()
	sql="DELETE FROM chat where ID='%s'"%(c_id1)
	try:
		cursor.execute(sql)
		conn.commit()
	except:
		conn.rollback()
	conn.close()

def delete_all_mess(c_id1):
	global cursor,conn
	connect_to_database()
	sql="DELETE FROM chat where ToUserID='%s'"%(c_id1)
	try:
		cursor.execute(sql)
		conn.commit()
	except:
		conn.rollback()
	conn.close()

def mess_total_count(c_id1):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM Chat where ToUserID='%s'"%(c_id1)
	try:
		cursor.execute(sql)
		results=cursor.rowcount
		rownum="%s"%results
		print(rownum)
		conn.commit()
	except:
		conn.rollback()
		print("0")
	conn.close()