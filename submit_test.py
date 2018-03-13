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
			print("""<div id="%s" class='style_prevu_kit test_div' style="padding:10px;"><div class="row"><div class="col-sm-6"><button class="btn btn-link" onclick="show_questions(%s)" ><h3>%s</h3></button><span class="pull-right"><form action="edit_test.php" method="post" ><input type="hidden" name="test_id" value="%s" /><button class="btn btn-sm btn-primary" type="submit" >Edit <span class="glyphicon glyphicon-pencil"></span></button></form></span><span class="pull-right"><button class="btn btn-sm btn-danger" onclick="remove_test(%s)" >Delete <span class="glyphicon glyphicon-trash"></span></button></span></div><div class="col-sm-6"><span class="glyphicon glyphicon-time"></span> Posted on  %s</div></div><hr /><div class="row"><div class="col-sm-6">Total Questions</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6">Course</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6">Subjects</div><div class="col-sm-6">%s</div></div></div><hr/><hr/>"""%(divid,divid,title,divid,divid,time,num,course,sub_string))
	except:
		conn.rollback()
		print("-1")
	conn.close()
	
def update_test(testid,title,course,subjects):
	global cursor,conn
	connect_to_database()
	sql="Update Tests SET Title='%s',Course='%s',Subjects='%s' where ID='%s'"%(title,course,subjects,testid)
	try:
		cursor.execute(sql)
		conn.commit()
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def remove_test(testid):
	global cursor,conn
	connect_to_database()
	sql="Delete from Tests where ID='%s'"%(testid)
	try:
		cursor.execute(sql)
		conn.commit()
		return "1"
	except:
		conn.rollback()
		return "-1"
	conn.close()
	
def total_test_num(postedby):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM Tests where Postedby='%s'"%(postedby)
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
