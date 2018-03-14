#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
print("Content-type:text/html\r\n\r\n")

form = cgi.FieldStorage()
if form.getvalue('skills'):
	skills = form.getvalue('skills')
	update_filter_panel(skills)

def connect_to_database():
	global conn,cursor
	conn = MySQLdb.connect (host = "localhost",user = "root",passwd = "",db = "mini_project")
	cursor = conn.cursor ()
	cursor = conn.cursor(MySQLdb.cursors.DictCursor)

def update_filter_panel(skills):
	global cursor,conn
	connect_to_database()
	skillarr=[]
	skillarr.append(skills)
	sql="SELECT * FROM Tests"
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		flag=0
		for row in results:
			subjects=row['Subjects']
			subarr=subjects.split("|")
			for i in subarr:
				i=i.strip()
				i=i.lower()
				for j in skillarr:
					j=j.strip()
					j=j.lower()
					if i.find(j)!=-1:
						flag+=1
						testid=row['ID']
						sql2="SELECT * FROM Tests where ID='%s'"%(testid)
						try:
							cursor.execute(sql2)
							print("<div>%s</div>"%testid)
						except:
							conn.rollback()
							print("-1")
			if flag==0:
				print("-1")
	except:
		conn.rollback()
		print("-1")
	conn.close()