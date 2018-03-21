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

def reload_certificate(c_id):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM Results where CandID='%s' ORDER BY Updated_Time DESC"%(c_id)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		for row in results:
			divid=row['ID']
			time=row["Updated_time"]
			datetime=time.strftime('%H : %M')
			testid=row['TestID']
			right=row['Rightt']
			total_que=row['Total']
			total_que=int(total_que)
			right=int(right)
			right_perc=((right)/total_que)*100
			solved=row['Attained']
			solved=int(solved)
			solved_perc=(solved/total_que)*100
			sql2="SELECT * FROM Tests where ID='%s'"%(testid)
			try:
				cursor.execute(sql2)
				result_of_test = cursor.fetchone()
				title=result_of_test['Title']
				course=result_of_test['Course']
				str_sub=result_of_test['Subjects']
				postedby=result_of_test['Postedby']
				if postedby=="-99":
					postedby="CareerHub"
				subjects=str_sub.split("|")
				if len(subjects)==1:
					sub_string=str_sub.strip()
				else:
					sub_string=""
					j=0
					for i in subjects:
						if j==0:
							sub_string+=i.strip()
						else:
							sub_string+=", "+i.strip()
						j+=1
					sub_string+=""
				solved_width="width:%s%%"%solved_perc
				right_width="width:%s%%"%right_perc
				formid="Form%s"%divid
				process_solved="""<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="%s" aria-valuemin="0" aria-valuemax="100" style="%s">%.2f%%</div></div>"""%(solved_perc,solved_width,solved_perc)
				process_right="""<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="%s" aria-valuemin="0" aria-valuemax="100" style="%s">%.2f%%</div></div>"""%(right_perc,right_width,right_perc)
				print("""<br/><div id="%s" class="alert alert-info" style="padding:30px;"><div class="row"><h3><span class="glyphicon glyphicon-certificate"></span> Certificate <small>approved by %s</small></h3></div><div class="row"><div class="col-lg-6"><table class="myTable"><tr><td>Test name</td><td>%s</td></tr><tr><td>Course</td><td>%s</td></tr><tr><td>Subjects</td><td>%s</td></tr></table></div><div class="col-lg-6"><div class="row">Right Questions :%s</div><div class="row">Total attained Questions :%s</div></div></div><br/><div class="row"><form method="post" name="%s" id="%s" action="take_test.php"><input type='hidden' name="test_id" value="%s" /><input type='hidden' name="retest" value="01" /><button type="button" id="get_test_btn" onclick="get_test_fun('%s')" class="btn btn-primary" >Get again!</button></form></div></div><hr/>"""%(divid,postedby,title,course,sub_string,process_right,process_solved,formid,formid,testid,formid))
				
				
			except:
				conn.rollback()
				print("Server is taking load...")
	except:
		conn.rollback()
		print("Server is taking load...")
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
	
def certificate_total_count(c_id):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM Results where CandID='%s'"%(c_id)
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
