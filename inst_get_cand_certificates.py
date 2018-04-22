#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import config

def reload_cand_certificates(c_id):
	conn,cursor=config.connect_to_database()
	numrow=certificate_total_count(cursor,conn,c_id)
	if numrow>0:
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
					print("""<br/><div id="%s" class="alert alert-info" style="padding:30px;"><div class="row"><h3><span class="glyphicon glyphicon-certificate"></span> Certificate <small>approved by %s</small></h3></div><div class="row"><div class="col-lg-6"><table class="myTable"><tr><td>Test name</td><td>%s</td></tr><tr><td>Course</td><td>%s</td></tr><tr><td>Subjects</td><td>%s</td></tr></table></div><div class="col-lg-6"><div class="row">Right Questions :%s</div><div class="row">Total attained Questions :%s</div></div></div><br/></div><hr/>"""%(divid,postedby,title,course,sub_string,process_right,process_solved))


				except:
					conn.rollback()
					print("Server is taking load...")
		except:
			conn.rollback()
			print("Server is taking load...")
		conn.close()
	else:
		print("""<div class="row" align="center" style="margin-top: 80px;">
	<div id="no_found"><img src="Images/not-found2.png" width="100px" alt="no found" /></div>
	<br/>
	<div style="color:gray;">Ceritificates(0)</div>
	</div>""")
		
	
def certificate_total_count(cursor,conn,c_id):
	sql="SELECT * FROM Results where CandID='%s'"%(c_id)
	try:
		cursor.execute(sql)
		rownum=cursor.rowcount
		return rownum
	except:
		conn.rollback()
		return "-99"
	
