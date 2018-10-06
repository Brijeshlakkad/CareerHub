#!/usr/bin/python
import pymysql

def enter_history(conn,cursor,mess,candid,role):
	sql="insert into history(Field,UserID,role) values('%s','%s','%s')"%(mess,candid,role)
	try:
		cursor.execute(sql)
		conn.commit()
	except:
		conn.rollback()
