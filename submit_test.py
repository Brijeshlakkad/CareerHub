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

def add_test(title,parid,course,subjects):
	global cursor,conn
	connect_to_database()
	sql="Insert into Tests(Title,Course,Subjects,PostedBy) values('%s','%s','%s','%s')"%(title,course,subjects,parid)
	try:
		cursor.execute(sql)
		conn.commit()
		sql2="Select ID from Tests Where Title='%s'"%(title)
		try:
			cursor.execute(sql2)
			results = cursor.fetchall()
			for row in results:
				test_id=row['ID']
				print(test_id)
		except:
			conn.rollback()
			print("-1")
	except:
		conn.rollback()
		print("-1")
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
	
def history_total_count(c_id1):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM History where UserID='%s'"%(c_id1)
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