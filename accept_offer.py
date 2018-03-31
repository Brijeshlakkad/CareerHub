#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import security
import save_history
cgitb.enable(display=0, logdir="/path/to/logdir")

def connect_to_database():
	global conn,cursor
	conn = MySQLdb.connect (host = "localhost",user = "root",passwd = "",db = "mini_project")
	cursor = conn.cursor ()
	cursor = conn.cursor(MySQLdb.cursors.DictCursor)
	
def get_institute(conn,cursor,instid):
	sql="select * from institutes where ID='%s'"%(instid)
	try:
		cursor.execute(sql)
		result=cursor.fetchone()
		return result['Bname']
	except:
		conn.rollback()
			
def count_rows(candid,instid,jobid,role):
	global cursor,conn
	connect_to_database()
	sql="select * from chat where FromUser='%s' and ToUserID='%s' and Text='%s' and role='%s'"%(candid,instid,jobid,role)
	try:
		cursor.execute(sql)
		num=cursor.rowcount
		return num
	except:
		conn.rollback()
		return "-1"
	conn.close()

def accept_offer(candid,instid,jobid,role):
	global cursor,conn
	connect_to_database()
	num=count_rows(candid,instid,jobid,role)
	num=int(num)
	if num==0:
		sql="insert into chat(FromUser,ToUserID,Text,role) values('%s','%s','%s','%s')"%(candid,instid,jobid,role)
		try:
			cursor.execute(sql)
			conn.commit()
			mess=instid
			save_history.enter_history(conn,cursor,mess,candid,role)
			print("1")
		except:
			conn.rollback()
			print("-1")
	else:
		print("-1")
	conn.close()
	
