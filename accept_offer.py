#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import security
print("Content-type:text/html\r\n\r\n")
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
	
def create_mess(conn,cursor,instid):
	inst_name=get_institute(conn,cursor,instid)
	mess="accepted job offer from %s."%inst_name
	return mess

def enter_history(conn,cursor,mess,candid,role):
	if role=="AO":
		role='Candidate'
	sql="insert into history(Field,UserID,role) values('%s','%s','%s')"%(mess,candid,role)
	try:
		cursor.execute(sql)
		conn.commit()
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
			mess=create_mess(conn,cursor,instid)
			enter_history(conn,cursor,mess,candid,role)
			print("1")
		except:
			conn.rollback()
			print("-1")
	else:
		print("-1")
	conn.close()
	
form = cgi.FieldStorage()
if form.getvalue('cand_id') and form.getvalue('inst_id') and form.getvalue('job_id'):
	candid = security.protect_data(form.getvalue('cand_id'))
	instid = security.protect_data(form.getvalue('inst_id'))
	jobid = security.protect_data(form.getvalue('job_id'))
	role="AO"
	accept_offer(candid,instid,jobid,role)

if form.getvalue('count_id') and form.getvalue('inst_id') and form.getvalue('job_id'):
	candid= security.protect_data(form.getvalue('count_id'))
	instid = security.protect_data(form.getvalue('inst_id'))
	jobid = security.protect_data(form.getvalue('job_id'))
	role="AO"
	num=count_rows(candid,instid,jobid,role)
	print("%s"%num)