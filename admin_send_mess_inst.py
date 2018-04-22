#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import config

def send_message(c_id,fromuser,message):
	conn,cursor=config.connect_to_database()
	sql="INSERT INTO chat (FromUser,ToUserID, text, role) VALUES ('%s','%s','%s', 'Institute')"%(fromuser,c_id,message)
	try:
		cursor.execute(sql)
		conn.commit()
		return "1"
	except:
		conn.rollback()
		return "0"
	conn.close()
