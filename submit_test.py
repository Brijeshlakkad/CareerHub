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

def show_tests(postedby):
	global cursor,conn
	connect_to_database()
	sql="Select * FROM Tests where Postedby='%s'"%(postedby)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		for row in results:
			divid=row['ID']
			time=row["Time"]
			datetime=time.strftime('%H : %M')
			title=row['Title']
			num=row['Total_num']
			course=row['Course']
			str_sub=row['Subjects']
			subjects=str_sub.split("|")
			if len(subjects)==1:
				sub_string=str_sub.strip()
			else:
				sub_string="<ol>"
				for i in subjects:
					sub_string+="<li>"+i.strip()+"</li>"
					sub_string+="</ol>"
			print("""<div id="%s" class='style_prevu_kit test_div' style="padding:10px;"><div class="row"><div class="col-sm-6"><button class="btn btn-link" onclick="show_questions(%s)" >%s</button></div><div class="col-sm-6"><span class="glyphicon glyphicon-time"></span> Posted on  %s</div></div><hr /><div class="row"><div class="col-sm-6">Total Questions</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6">Course</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6">Subjects</div><div class="col-sm-6">%s</div></div></div><hr/><hr/>"""%(divid,divid,title,time,num,course,sub_string))
	except:
		conn.rollback()
		print("-1")
	conn.close()
