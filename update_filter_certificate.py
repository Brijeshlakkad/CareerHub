#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import candidate_details
import config
import test_details
import no_found
def print_on_screen_test(conn,cursor,arr_id):
	for i in arr_id:
		obj=test_details.test()
		obj.test_details(conn,cursor,i)
		divid=obj.divid
		title=obj.title
		course=obj.course
		postedby=obj.postedby
		sub_string=obj.sub_string
		time=obj.time
		num_que=obj.num_que
		print("""<div id="%s" class='style_prevu_kit test_div' style="padding:10px;"><div class="row"><div class="col-sm-6"><h3>%s</h3></div><div class="col-sm-6"><span class="glyphicon glyphicon-time"></span> Posted on  %s</div></div><hr /><div class="row"><div class="col-sm-6">Total Questions</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6">Course</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6">Subjects</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"><form method="post" action="take_test.php"><input type="hidden" name="test_id" value="%s"/><button type="submit" class="btn btn-primary">Apply now!</button></form></div></div></div><hr/><hr/>"""%(divid,title,time,num_que,course,sub_string,divid))

def update_filter_panel(skillarr1,candid):
	conn,cursor=config.connect_to_database()
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
			num_que=row['Total_num']
			num_que=int(num_que)
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
							sql3="Select * from results where CandID='%s' AND TestID='%s'"%(candid,testid)
							try:
								cursor.execute(sql3)
								results_num=cursor.rowcount
								if results_num==0 and testid not in arr_id and num_que!=0:
									arr_id.append(testid)
								else:
									flag-=1
							except:
								conn.rollback()
								print("-1")
						except:
							conn.rollback()
							print("-1")
		if flag==0 or len(arr_id)==0:
			no_found.no_found("Tests(0)")
		else:
			print_on_screen_test(conn,cursor,arr_id)
	except:
		conn.rollback()
		print("-1")
	conn.close()
	
def update_filter_random(candid):
	conn,cursor=config.connect_to_database()
	sql_visit="select TestID from visited_test where CandID='%s'"%candid
	try:
		cursor.execute(sql_visit)
		results=cursor.fetchall()
		arr_id=[]
		for row in results:
			arr_id.append(row['TestID'])
		print_on_screen_test(conn,cursor,arr_id)
	except:
		print("Server is taking load!!")
