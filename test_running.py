#!/usr/bin/python
import cgi, cgitb
import sys
import os
import pymysql
import config
def que_reload(testid,cu_id):
	conn,cursor=config.connect_to_database()
	sql="Select ID,Time,Question,A1,A2,A3,A4 FROM Questions where TestID='%s'"%(testid)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		i=0
		for row in results:
			divid=row[0]
			time=row[1]
			datetime=time.strftime('%H : %M')
			que=row[2]
			a1=row[3]
			a2=row[4]
			a3=row[5]
			a4=row[6]
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
