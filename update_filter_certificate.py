#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import candidate_details
import config
import no_found
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
		if flag==0:
			no_found.no_found("Tests(0)")
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
					print("""<div id="%s" class='style_prevu_kit test_div' style="padding:10px;"><div class="row"><div class="col-sm-6"><h3>%s</h3></div><div class="col-sm-6"><span class="glyphicon glyphicon-time"></span> Posted on  %s</div></div><hr /><div class="row"><div class="col-sm-6">Total Questions</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6">Course</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6">Subjects</div><div class="col-sm-6">%s</div></div><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"><form method="post" action="take_test.php"><input type="hidden" name="test_id" value="%s"/><button type="submit" class="btn btn-primary">Apply now!</button></form></div></div></div><hr/><hr/>"""%(divid,title,time,num,course,sub_string,divid))
				except:
					conn.rollback()
					print("-1")
	except:
		conn.rollback()
		print("-1")
	conn.close()
	
def update_filter_random(candid):
	conn,cursor=config.connect_to_database()
	try:
		obj=candidate_details.candidate()
		obj.candidate_details(conn,cursor,candid)
		quali=obj.quali_arr
		print("dd")
	except:
		print("Server is taking load!!")
