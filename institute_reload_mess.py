#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import config
import candidate_details
import institute_and_job
import no_found
def reload_all(inst_id,role_div):
	conn,cursor=config.connect_to_database()
	sql="Select * from chat where %s ORDER BY Time DESC"%(role_div)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		rownum=cursor.rowcount
		if rownum==0:
			no_found.no_found("Inbox(0)")
		else:
			for row in results:
				role=row['role']
				divid=row['ID']
				time=row["Time"]
				datetime=time.strftime('%H : %M')
				if role=="Offer" or role=="Accepted":
					fromuser=row["ToUserID"]
					jobid=row['Text']
					obj_cand=candidate_details.candidate()
					obj_cand.candidate_details(conn,cursor,fromuser)
					obj_job=institute_and_job.institute_and_job()
					obj_job.job_details(conn,cursor,jobid)
					if role=="Offer":
						status_header="<span style='color:#FFAE00;'><strong><h4>Job Sent</h4></strong></span>"
						status_div="""<h4>Job <span class='job_id' id='%s'><b>%s</b> offer sent to <span style='cursor:pointer;' class="show_candidate_link"><span id='%s' class='cand_id'><b>%s</b></span></span></span></h4>"""%(obj_job.job_id,obj_job.job_name,obj_cand.cand_id,obj_cand.cand_name)
					elif role=="Accepted":
						status_header="<span style='color:green;'><strong><h4>Job Accepted</h4></strong></span>"
						status_div="""<h4>Job <span class='job_id' id='%s'><b>%s</b> accepted by <span style='cursor:pointer;' class="show_candidate"><span id='%s' class='cand_id'><b>%s</b></span></span></span></h4>"""%(obj_job.job_id,obj_job.job_name,obj_cand.cand_id,obj_cand.cand_name)
					print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;">
					<div class="row" style=""><div class="col-md-9">%s</div><div class="col-md-3 pull-right">%s</div></div>
						<hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>
							<div class="row"><div class="col-md-9"><div class="media"><div class="media-left"><img class="img-circle" style="height:60px;" src="%s" /></div><div class="media-body" style="line-height: 25px;"><div id='status_div'>%s</div></div></div></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div></div><br/>"""%(status_header,time,obj_cand.filename,status_div,divid))
				else:
					fromuser=row["FromUser"]
					text=row['Text']
					if fromuser=="Admin":
						if text=="verified":
							print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4>Verification <span class="glyphicon glyphicon-ok-sign" style="color:green;"><span></h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>
					<div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s"  class="alert-dismissable fade in"><strong>%s </strong> : Hurray!!Your profile is varified successfully.</div></div><div class="col-md-3 pull-right">%s</div></div></div><br/>"""%(divid,divid,fromuser,time))
						elif text=="rejected":
							print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4>Verification <span class="glyphicon glyphicon-remove" style="color:red;"><span></h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>
					<div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s"  class="alert-dismissable fade in"><strong>%s </strong> : We are sorry!!Your profile is rejected.</div></div><div class="col-md-3 pull-right">%s</div></div></div><br/>"""%(divid,divid,fromuser,time))
	except:
		conn.rollback()
		print("Try again !")
	print('<script type="text/javascript" src="js/show_cand.js"></script>')
	conn.close()

def reload_messages(load_inbox,inst_id):
	if load_inbox=="all":
		role_div="ToUserID='%s' and role='Institute' or FromUser='%s' and role='Offer' or role='Accepted'"%(inst_id,inst_id)
		reload_all(inst_id,role_div)
	elif load_inbox=="accepted":
		role_div="FromUser='%s' and role='Accepted'"%(inst_id)
		reload_all(inst_id,role_div)
	elif load_inbox=="offer_sent":
		role_div="FromUser='%s' and role='Offer'"%(inst_id)
		reload_all(inst_id,role_div)

def delete_message(c_id1):
	conn,cursor=config.connect_to_database()
	sql="DELETE FROM chat where ID='%s'"%(c_id1)
	try:
		cursor.execute(sql)
		conn.commit()
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def delete_all_mess(c_id1):
	conn,cursor=config.connect_to_database()
	sql="DELETE FROM chat where ToUserID='%s' and role='Institute'"%(c_id1)
	try:
		cursor.execute(sql)
		conn.commit()
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def mess_total_count(c_id1,role_div):
	conn,cursor=config.connect_to_database()
	sql="SELECT * FROM Chat where ToUserID='%s' and %s"%(c_id1,role_div)
	try:
		cursor.execute(sql)
		results=cursor.rowcount
		rownum="%s"%results
		print("%s"%rownum)
		conn.commit()
	except:
		conn.rollback()
		print("0")
	conn.close()
	
def mess_count_part(load_inbox,inst_id):
	if load_inbox=="all":
		role_div="ToUserID='%s' and role='Institute' or FromUser='%s' and role='Offer' or role='Accepted'"%(inst_id,inst_id)
		mess_total_count(inst_id,role_div)
	elif load_inbox=="offer_sent":
		role_div="FromUser='%s' and role='Offer'"%(inst_id)
		mess_total_count(inst_id,role_div)
	elif load_inbox=="accpeted":
		role_div="FromUser='%s' and role='Accepted'"%(inst_id)
		mess_total_count(inst_id,role_div)