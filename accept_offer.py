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
			
def count_rows(instid,candid,jobid):
	global cursor,conn
	connect_to_database()
	sql="select * from chat where FromUser='%s' and ToUserID='%s' and Text='%s'"%(instid,candid,jobid)
	try:
		cursor.execute(sql)
		num=cursor.rowcount
		return num
	except:
		conn.rollback()
		return "-1"
	conn.close()

def check_offer_cand(c_id,inst_id,j_id):
	global cursor,conn
	connect_to_database()
	sql="select role from chat where FromUser='%s' and ToUserID='%s' and Text='%s'"%(inst_id,c_id,j_id)
	try:
		cursor.execute(sql)
		result=cursor.rowcount
		if result==1:
			row=cursor.fetchone()
			role=row['role']
			return role
		else:
			return "1x"
	except:
		conn.rollback()
		return "-1x"
	conn.close()

def accept_offer(candid,instid,jobid,role):
	global cursor,conn
	connect_to_database()
	num=count_rows(instid,candid,jobid)
	num=int(num)
	if num==1:
		sql="update chat SET role='%s' where FromUser='%s' and ToUserID='%s' and Text='%s'"%(role,instid,candid,jobid)
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
	
def deny_offer(candid,instid,jobid,role):
	global cursor,conn
	connect_to_database()
	num=count_rows(instid,candid,jobid)
	num=int(num)
	if num==1:
		sql="delete from chat where role='%s' and FromUser='%s' and ToUserID='%s' and Text='%s'"%(role,instid,candid,jobid)
		try:
			cursor.execute(sql)
			conn.commit()
			mess=instid
			role="Deny_offer"
			save_history.enter_history(conn,cursor,mess,candid,role)
			print("1")
		except:
			conn.rollback()
			print("-1")
	else:
		print("-1")
	conn.close()
