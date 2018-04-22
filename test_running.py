#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import config
def que_reload(testid,cu_id):
	conn,cursor=config.connect_to_database()
	sql="Select * FROM Questions where TestID='%s'"%(testid)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		i=0
		for row in results:
			divid=row['ID']
			time=row["Time"]
			datetime=time.strftime('%H : %M')
			que=row['Question']
			a1=row['A1']
			a2=row['A2']
			a3=row['A3']
			a4=row['A4']
			i+=1
			que_id="question%s"%i
			error="error%s"%i
			ans1="name='%s' value='1'"%(divid)
			ans2="name='%s' value='2'"%(divid)
			ans3="name='%s' value='3'"%(divid)
			ans4="name='%s' value='4'"%(divid)
			print("""<div id="%s" class="panel-body" style="line-height:30px;"><div id='question'>%s. <strong>%s</strong></div><div id='mcqs' class="form-group"><div><input type='radio' %s /> %s</div><div><input type='radio' %s /> %s</div><div><input type='radio' %s /> %s</div><div><input type='radio' %s /> %s</div><div id="%s"></div></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>"""%(que_id,i,que,ans1,a1,ans2,a2,ans3,a3,ans4,a4,error))
		print("""<div id="controls"><button class="btn btn-sm btn-primary" type="button" onclick="check_answers()">Submit</button></div>""")
	except:
		conn.rollback()
		print("-1")
	conn.close()
def delete_visited_test(running_testid):
	conn,cursor=config.connect_to_database()
	sql="delete from visited_test where TestID='%s'"%running_testid
	cursor.execute(sql)
	try:
		cursor.execute(sql)
		conn.commit()
		print("11")
	except:
		conn.rollback()
		print("00")
	conn.close()