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
	sql="SELECT * FROM chat where ToUserID='%s' and role='Candidate' or role='job' ORDER BY Time ASC"%(c_id1)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		for row in results:
			role=row['role']
			divid=row['ID']
			time=row["Time"]
			datetime=time.strftime('%H : %M')
			if role=="job":
				fromuser=row["FromUser"]
				text=row['Text']
				print("""<div style="margin-top:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row" style="margin-right:20px;margin-top:20px;"><div class="col-md-8"><div id="%s"  class="alert-dismissable fade in" style="margin:30px;"> %s | <strong>%s </strong> : %s </div></div><div class="col-md-4"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div></div><br/>"""%(divid,datetime,fromuser,text,divid))
			else:
				fromuser=row["FromUser"]
				text=row['Text']
				print("""<div style="margin-top:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row" style="margin-right:20px;margin-top:20px;"><div class="col-md-8"><div id="%s"  class="alert-dismissable fade in" style="margin:30px;"> %s | <strong>%s </strong> : %s </div></div><div class="col-md-4"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div></div><br/>"""%(divid,datetime,fromuser,text,divid))
			
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
	sql="DELETE FROM chat where ToUserID='%s' and role='Candidate' or role='job'"%(c_id1)
	try:
		cursor.execute(sql)
		conn.commit()
	except:
		conn.rollback()
	conn.close()

def mess_total_count(c_id1):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM Chat where ToUserID='%s' and role='Candidate' or role='job'"%(c_id1)
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