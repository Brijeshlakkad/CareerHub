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

def send_message(c_id,fromuser,message):
	global cursor,conn
	connect_to_database()
	sql="INSERT INTO chat (FromUser,ToUserID, text, role) VALUES ('%s','%s','%s', 'Candidate')"%(fromuser,c_id,message)
	try:
		cursor.execute(sql)
		conn.commit()
		return "1"
	except:
		conn.rollback()
		return "0"
	conn.close()
