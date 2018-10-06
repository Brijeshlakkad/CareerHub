#!/usr/bin/python
import cgi, cgitb
import sys
import os
import pymysql
from config import connect_to_database

def check_already(c_id):
	global bits,cursor,conn,updated,sbits
	sql="select Status_bits,isUpdated from Institutes where ID='%s'"%c_id;
	try:
		cursor.execute(sql)
		results = cursor.fetchone()
		sbits=results[0]
		bits=sbits.split(",/,")
		updated=results[1]
		return len(bits)
	except:
		conn.rollback()
		return "0"

def add_history(c_id1,flag1,fromuser):
	global conn,cursor
	if flag1==1:
		f="Approved"
	else:
		f="Rejected"
	field="%s institute %s"%(f,c_id1)
	sql="Insert into History(Field,UserID) values('%s',%s)"%(field,fromuser)
	try:
		cursor.execute(sql)
		conn.commit()
		return "11"
	except:
		conn.rollback()
		return "10"

def update_database(c_id1,flag1):
	global bits,cursor,conn,updated,sbits
	connect_to_database()
	c_id=(int)(c_id1)
	flag=(int)(flag1)
	st=add_history(c_id,flag,"-99")
	if flag==1 and st=="11":
		if check_already(c_id)==1:
			sbits+=",/,"+"1"
			sql="Update Institutes SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
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
			sql="Update Institutes SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
			try:
				cursor.execute(sql)
				conn.commit()
				return "11"
			except:
				conn.rollback()
				return "10"
		else:
			return "01"
	elif flag==0 and st=="11":
		if check_already(c_id)==1:
			sbits+=",/,"+"0"
			sql="Update Institutes SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
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
			sql="Update Institutes SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
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
