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

def add_question(testid,que,a1,a2,a3,a4,ans):
	global cursor,conn
	connect_to_database()
	sql="Insert into Questions(Question,A1,A2,A3,A4,TestID,Ans) values('%s','%s','%s','%s','%s','%s','%s')"%(que,a1,a2,a3,a4,testid,ans)
	try:
		cursor.execute(sql)
		conn.commit()
		testid=int(testid)
		sql2="Select Total_num from Tests Where ID='%s'"%(testid)
		try:
			cursor.execute(sql2)
			results = cursor.fetchone()
			num=results['Total_num']
			n=int(num)
			n+=1
			sql3="Update Tests SET Total_num='%s' where ID='%s'"%(n,testid)
			try:
				cursor.execute(sql3)
				conn.commit()
				print("1")
			except:
				conn.rollback()
				print("-11")
		except:
			conn.rollback()
			print("-12")
	except:
		conn.rollback()
		print("-13")
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
	