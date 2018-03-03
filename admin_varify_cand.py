#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import re
import MySQLdb

conn = MySQLdb.connect (host = "localhost",user = "root",passwd = "",db = "mini_project")
cursor = conn.cursor ()
cursor = conn.cursor(MySQLdb.cursors.DictCursor)
form = cgi.FieldStorage()

print("Content-type:text/html\r\n\r\n")

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
		print("0")

def update_database(c_id,flag):
	global bits,cursor,conn,updated,sbits
	if flag==1:
		if check_already(c_id)==1:
			sbits+=",/,"+"1"
			sql="Update Candidates SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
			try:
				cursor.execute(sql)
				conn.commit()
				print("11")
			except:
				conn.rollback()
				print("10")
		elif check_already(c_id)>=1 and bits[1]=="1" and updated=="1":
			bits[1]="1"
			s=",/,"
			sbits=s.join(bits);
			sql="Update Candidates SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
			try:
				cursor.execute(sql)
				conn.commit()
				print("11")
			except:
				conn.rollback()
				print("10")
		else:
			print("01")
	elif flag==0:
		if check_already(c_id)==1:
			sbits+=",/,"+"0"
			sql="Update Candidates SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
			try:
				cursor.execute(sql)
				conn.commit()
				print("11")
			except:
				conn.rollback()
				print("10")
		elif check_already(c_id)>=1 and bits[1]=="1" and updated=="1":
			bits[1]="0"
			s=",/,"
			sbits=s.join(bits);
			sql="Update Candidates SET Status_bits='%s',isUpdated='0' where ID='%s'"%(sbits,c_id)
			try:
				cursor.execute(sql)
				conn.commit()
				print("11")
			except:
				conn.rollback()
				print("10")
		else:
			print("01")
	

if form.getvalue('id'):
	c_id = (int)(form.getvalue('id'))

if form.getvalue('flag'):
	flag = (int)(form.getvalue('flag'))
update_database(c_id,flag)
conn.close()
