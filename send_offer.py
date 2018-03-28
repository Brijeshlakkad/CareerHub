#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import security
print("Content-type:text/html\r\n\r\n")


def connect_to_database():
	global conn,cursor
	conn = MySQLdb.connect (host = "localhost",user = "root",passwd = "",db = "mini_project")
	cursor = conn.cursor ()
	cursor = conn.cursor(MySQLdb.cursors.DictCursor)

def send_offer_cand(c_id,inst_id,j_id):
	global cursor,conn
	connect_to_database()
	sql="Insert into chat(FromUser,ToUserID,Text,role) values('%s','%s','%s','job')"%(inst_id,c_id,j_id)
	try:
		cursor.execute(sql)
		conn.commit()
		print("11")
	except:
		conn.rollback()
		print("00")
	conn.close()

def delete_history(c_id1):
	global cursor,conn
	connect_to_database()
	sql="DELETE FROM History where ID='%s'"%(c_id1)
	try:
		cursor.execute(sql)
		conn.commit()
	except:
		conn.rollback()
	conn.close()

def delete_all_history(c_id1):
	global cursor,conn
	connect_to_database()
	sql="DELETE FROM History where UserID='%s'"%(c_id1)
	try:
		cursor.execute(sql)
		conn.commit()
	except:
		conn.rollback()
	conn.close()
	
def certificate_total_count(c_id):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM Results where CandID='%s'"%(c_id)
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
	
form = cgi.FieldStorage()	
if form.getvalue('send_offer') and form.getvalue('inst_id') and form.getvalue('job_id'):
	c_id = security.protect_data(form.getvalue('send_offer'))
	inst_id=security.protect_data(form.getvalue('inst_id'))
	j_id=security.protect_data(form.getvalue('job_id'))
	send_offer_cand(c_id,inst_id,j_id)