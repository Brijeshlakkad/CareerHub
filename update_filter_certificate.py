#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
print("Content-type:text/html\r\n\r\n")


def connect_to_database():
	global conn,cursor
	conn = MySQLdb.connect (host = "localhost",user = "root",passwd = "",db = "mini_project")
	cursor = conn.cursor ()
	cursor = conn.cursor(MySQLdb.cursors.DictCursor)

def update_filter_panel(skillarr1):
	global cursor,conn
	connect_to_database()
	skillarr=list()
	if type(skillarr1) is str:
		skillarr.append(skillarr1)
	else:
		skillarr=skillarr1
	sql="SELECT * FROM Tests"
	arr_id=[]
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
							if testid not in arr_id:
								arr_id.append(testid)
						except:
							conn.rollback()
							print("-1")
		if flag==0:
			print("-1")
		else:
			for i in arr_id:
				sql3="SELECT * FROM Tests where ID='%s'"%(i)
				try:
					cursor.execute(sql3)
					row = cursor.fetchone()
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
						for k in subjects:
							sub_string+="<li>"+k.strip()+"</li>"
						sub_string+="</ol>"
					print("""<div id="%s" class='style_prevu_kit test_div' style="padding:10px;"><div class="row"><div class="col-sm-6"><h3>%s</h3></div><div class="col-sm-6"><span class="glyphicon glyphicon-time"></span> Posted on  %s</div></div><hr /><div class="row"><div class="col-sm-6">Total Questions</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6">Course</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6">Subjects</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"><form method="post" action="take_test.php"><input type="hidden" name="test_id" value="%s"/><input type="hidden" name="visited" value="0"/><button type="submit" class="btn btn-primary">Apply now!</button></form></div></div></div><hr/><hr/>"""%(divid,title,time,num,course,sub_string,divid))
				except:
					conn.rollback()
					print("-1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

form = cgi.FieldStorage()
if form.getvalue('skills[]'):
	skills_arr = form.getvalue('skills[]')
	update_filter_panel(skills_arr)
