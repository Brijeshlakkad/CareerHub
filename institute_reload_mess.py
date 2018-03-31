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
	sql="SELECT * FROM chat where ToUserID='%s' and role='Institute' ORDER BY Time ASC"%(c_id1)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		for row in results:
			divid=row['ID']
			fromuser=row["FromUser"]
			time=row["Time"]
			datetime=time.strftime('%H : %M')
			text=row['Text']
			print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4>Verification <span class="glyphicon glyphicon-ok-sign" style="color:green;"><span></h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>
				<div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s"  class="alert-dismissable fade in"><strong>%s </strong> : %s </div></div><div class="col-md-3 pull-right">%s</div></div></div><br/>"""%(divid,divid,fromuser,text,datetime))
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
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def delete_all_mess(c_id1):
	global cursor,conn
	connect_to_database()
	sql="DELETE FROM chat where ToUserID='%s' and role='Institute'"%(c_id1)
	try:
		cursor.execute(sql)
		conn.commit()
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def mess_total_count(c_id1):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM Chat where ToUserID='%s' and role='Institute'"%(c_id1)
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