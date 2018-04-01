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

def send_offer_cand(c_id,inst_id,j_id,role):
	global cursor,conn
	connect_to_database()
	sql="Insert into chat(FromUser,ToUserID,Text,role) values('%s','%s','%s','%s')"%(inst_id,c_id,j_id,role)
	try:
		cursor.execute(sql)
		conn.commit()
		print("11")
	except:
		conn.rollback()
		print("00")
	conn.close()
	
def delete_offer_cand(c_id,inst_id,j_id,role):
	global cursor,conn
	connect_to_database()
	sql="delete from chat where FromUser='%s' and ToUserID='%s' and Text='%s' and role='%s'"%(inst_id,c_id,j_id,role)
	try:
		cursor.execute(sql)
		conn.commit()
		print("11")
	except:
		conn.rollback()
		print("00")
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
			return "%s"%role
		else:
			return "1x"
	except:
		conn.rollback()
		return "-1x"
	conn.close()
	
form = cgi.FieldStorage()	
if form.getvalue('send_offer') and form.getvalue('inst_id') and form.getvalue('job_id'):
	c_id = security.protect_data(form.getvalue('send_offer'))
	inst_id=security.protect_data(form.getvalue('inst_id'))
	j_id=security.protect_data(form.getvalue('job_id'))
	role="Offer"
	send_offer_cand(c_id,inst_id,j_id,role)
	
if form.getvalue('delete_offer') and form.getvalue('inst_id') and form.getvalue('job_id'):
	c_id = security.protect_data(form.getvalue('delete_offer'))
	inst_id=security.protect_data(form.getvalue('inst_id'))
	j_id=security.protect_data(form.getvalue('job_id'))
	role="Offer"
	delete_offer_cand(c_id,inst_id,j_id,role)
	
if form.getvalue('check_offer') and form.getvalue('inst_id') and form.getvalue('job_id'):
	c_id = security.protect_data(form.getvalue('check_offer'))
	inst_id=security.protect_data(form.getvalue('inst_id'))
	j_id=security.protect_data(form.getvalue('job_id'))
	status=check_offer_cand(c_id,inst_id,j_id)
	status=security.protect_data(status)
	print("%s"%status)