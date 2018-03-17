#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import security
print("Content-type:text/html\r\n\r\n")
cgitb.enable(display=0, logdir="/path/to/logdir")

def connect_to_database():
	global conn,cursor
	conn = MySQLdb.connect (host = "localhost",user = "root",passwd = "",db = "mini_project")
	cursor = conn.cursor ()
	cursor = conn.cursor(MySQLdb.cursors.DictCursor)

def que_reload(testid,cu_id):
	global cursor,conn
	connect_to_database()
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
			print("""<div id="%s" class="panel-body"><div id='question'>%s. %s</div><div id='mcqs' class="form-group"><div><input type='radio' %s /> %s</div><div><input type='radio' %s /> %s</div><div><input type='radio' %s /> %s</div><div><input type='radio' %s /> %s</div><div id="%s"></div></div></div>"""%(que_id,i,que,ans1,a1,ans2,a2,ans3,a3,ans4,a4,error))
	except:
		conn.rollback()
		print("-1")
	conn.close()
	
	
form = cgi.FieldStorage()
if form.getvalue('que_reload') and form.getvalue('current_id'):
	testid = form.getvalue('que_reload')
	current_id = form.getvalue('current_id')
	testid=security.protect_data(testid)
	current_id=security.protect_data(current_id)
	que_reload(testid,current_id)