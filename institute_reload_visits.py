#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import config
import no_found
import candidate_details
import institute_and_job
def reload_visits(inst_id):
	conn,cursor=config.connect_to_database()
	sql_visits="select * from profile_visit where ProfileID='%s'"%(inst_id)
	try:
		cursor.execute(sql_visits)
		results=cursor.fetchall()
		rownum=cursor.rowcount
		if rownum==0:
			no_found.no_found("Profile visits(0)")
		else:
			for row in results:
				divid=row['VisitID']
				personid=row['PersonID']
				time=row['VisitedTime']
				howmanytimes=row['HowManyTimes']
				obj_cand=candidate_details.candidate()
				obj_cand.candidate_details(conn,cursor,personid)
				cand_id=obj_cand.cand_id
				cand_name = obj_cand.cand_name
				cand_image=obj_cand.cand_image
				cand_email=obj_cand.cand_email
				cand_contact=obj_cand.cand_contact
				filename=obj_cand.filename
				print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;">
					<div class="row" style=""><div class="col-md-9"></div><div class="col-md-3 pull-right">%s</div></div>
						<hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>
							<div class="row"><div class="col-md-9"><div class="media"><div class="media-left"><img class="img-circle" style="height:60px;" src="%s" /></div><div class="media-body" style="line-height: 25px;"><div id='%s' class='cand_id'><strong>%s</strong> visited <span class="badge">%s</span> times</div></div></div></div><div class="col-md-3"><a href="#" onclick='delete_visit("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div></div><br/>"""%(time,filename,cand_id,cand_name,howmanytimes,divid))
	except:
		conn.rollback()
		print("Server is taking too load...")
	conn.close()
	
def delete_visit(visit_id):
	conn,cursor=config.connect_to_database()
	sql="DELETE FROM profile_visit where VisitID='%s'"%(visit_id)
	try:
		cursor.execute(sql)
		conn.commit()
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def delete_all_visits(inst_id):
	conn,cursor=config.connect_to_database()
	sql="DELETE FROM profile_visit where ProfileID='%s'"%(inst_id)
	try:
		cursor.execute(sql)
		conn.commit()
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def visits_total_count(inst_id):
	conn,cursor=config.connect_to_database()
	sql_visits="select * from profile_visit where ProfileID='%s'"%(inst_id)
	try:
		cursor.execute(sql_visits)
		rownum=cursor.rowcount
		print("%s"%rownum)
		conn.commit()
	except:
		conn.rollback()
		print("0")
	conn.close()

def visits_all_total_count(inst_id):
	conn,cursor=config.connect_to_database()
	sql_visits="select * from profile_visit where ProfileID='%s'"%(inst_id)
	try:
		cursor.execute(sql_visits)
		results=cursor.fetchall()
		totalcount=0
		for row in results:
			count=int(row['HowManyTimes'])
			totalcount+=count
		print("%s"%totalcount)
	except:
		conn.rollback()
		print("0")
	conn.close()
	
def impressions_total_count(inst_id):
	conn,cursor=config.connect_to_database()
	obj_inst=institute_and_job.institute_and_job()
	obj_inst.institute_details(conn,cursor,inst_id)
	inst_impression=obj_inst.inst_impressions
	print("%s"%inst_impression)
	conn.close()