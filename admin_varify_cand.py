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

def check_already(c_id):
	global bits,cursor,conn,updated,sbits
	sql="select * from Candidates where ID='%s'"%c_id;
	try:
		cursor.execute(sql)
		results = cursor.fetchone()
		sbits=results["Status_bits"]
		bits=sbits.split(",/,")
		updated=results["isUpdated"]
		return len(bits)
	except:
		conn.rollback()
		return "0"

def update_database(c_id1,flag1):
	global bits,cursor,conn,updated,sbits
	connect_to_database()
	c_id=(int)(c_id1)
	flag=(int)(flag1)
	if flag==1:
		if check_already(c_id)==1:
			sbits+=",/,"+"1"
			sql="Update Candidates SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
			try:
				cursor.execute(sql)
				conn.commit()
				return "11"
			except:
				conn.rollback()
				return "10"
		elif check_already(c_id)>=1 and bits[1]=="1" and updated=="1":
			bits[1]="1"
			s=",/,"
			sbits=s.join(bits);
			sql="Update Candidates SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
			try:
				cursor.execute(sql)
				conn.commit()
				return "11"
			except:
				conn.rollback()
				return "10"
		else:
			return "01"
	elif flag==0:
		if check_already(c_id)==1:
			sbits+=",/,"+"0"
			sql="Update Candidates SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
			try:
				cursor.execute(sql)
				conn.commit()
				return "11"
			except:
				conn.rollback()
				return "10"
		elif check_already(c_id)>=1 and bits[1]=="1" and updated=="1":
			bits[1]="0"
			s=",/,"
			sbits=s.join(bits);
			sql="Update Candidates SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
			try:
				cursor.execute(sql)
				conn.commit()
				return "11"
			except:
				conn.rollback()
				return "10"
		else:
			return "01"
	else:
		return "01"
	conn.close()