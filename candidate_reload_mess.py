#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import base64
import config
import institute_and_job
import no_found
def reload_all(c_id1,role_div):
	conn,cursor=config.connect_to_database()
	c_id1=int(c_id1)
	role_div=str(role_div)
	sql_mess="select Type,ID,ToUserID,FromUser,Time,Text,role from(select 'chat' as Type,ID,ToUserID,FromUser,Time,Text,role from chat where ToUserID='%s' and %s UNION ALL select 'application' as Type,application_id,candidate_id,institute_id,apply_datetime,job_id,status_bit from applications where candidate_id='%s') as Messages ORDER BY Time DESC"%(c_id1,role_div,c_id1)
	try:
		cursor.execute(sql_mess)
		results = cursor.fetchall()
		rownum=cursor.rowcount
		if rownum==0:
			no_found.no_found("Inbox(0)")
		else:
			for row in results:
				c_id2=row['ToUserID']
				role=row['role']
				divid=row['ID']
				time=row["Time"]
				type_id=row['Type']
				datetime=time.strftime('%d-%m-%Y %H : %M %a')
				if role=="Offer" and type_id=='chat':
					fromuser=row["FromUser"]
					jobid=row['Text']
					obj=institute_and_job.institute_and_job()
					obj.institute_details(conn,cursor,fromuser)
					obj.job_details(conn,cursor,jobid)
					print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4><b>Job offer</b></h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/><a  class="div_link show_institute" style="cursor:pointer;"><div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s" class="alert-dismissable fade in inst_id"><div class="media role_type" id='%s'><div class="media-left"><img class="img-circle" style="height:150px;" src="%s" /></div><div class="media-body" style="line-height: 25px;"><h4 class="media-heading"><b>Institute name : </b>%s</h4><div class="row"><div class="col-xs-6"><h5><b>Job Title : </b>%s</h5><h5 class="description_first"><b>Institute description : </b>%s</h5></div><div class="col-xs-6 job_id" id="%s">
							<h5><b>Institute Type: </b>%s</h5>
							<h5><b>Business Email: </b>%s</h5>
							<h5><b>Business Contact: </b>%s</h5>
							<h5><b>Institute Address: </b>%s</h5>
							<h5><b>Country: </b>%s</h5>
							<h5><b>ZIP: </b>%s</h5></div></div></div></div></div></div><div class="col-md-3 pull-right">%s</div></div></a></div><br/>"""%(divid,obj.inst_id,role,obj.filename,obj.inst_name,obj.job_name,obj.institute_descr,obj.job_id,obj.institute_type,obj.institute_bemail,obj.institute_contact,obj.institute_address,obj.institute_country,obj.institute_zip,datetime))
				elif type_id=="application" and role_div!="role='Offer'":
					fromuser=row["FromUser"]
					jobid=row['Text']
					obj=institute_and_job.institute_and_job()
					obj.institute_details(conn,cursor,fromuser)
					obj.job_details(conn,cursor,jobid)
					if role=="1":
						status_div="<div class='row alert alert-success'><center><h4>Congratulation, You have got this job.</h4></center></div>";
					elif role=="0":
						status_div="<div class='row alert alert-danger'><center><h4>Rejected</h4></center></div>";
					elif role=="-99":
						status_div="<div class='row alert alert-warning'><center><h4>Pending..</h4></center></div>";
					print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4><b>Request sent</b></h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>%s<a  class="div_link show_institute" style="cursor:pointer;"><div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s" class="alert-dismissable fade in inst_id"><div class="media role_type" id='%s'><div class="media-left"><img class="img-circle" style="height:150px;" src="%s" /></div><div class="media-body" style="line-height: 25px;"><h4 class="media-heading"><b>Institute name : </b>%s</h4><div class="row"><div class="col-xs-6"><h5><b>Job Title : </b>%s</h5><h5 class="description_first"><b>Institute description : </b>%s</h5></div><div class="col-xs-6 job_id" id="%s">
							<h5><b>Institute Type: </b>%s</h5>
							<h5><b>Business Email: </b>%s</h5>
							<h5><b>Business Contact: </b>%s</h5>
							<h5><b>Institute Address: </b>%s</h5>
							<h5><b>Country: </b>%s</h5>
							<h5><b>ZIP: </b>%s</h5></div></div></div></div></div></div><div class="col-md-3 pull-right">%s</div></div></a></div><br/>"""%(divid,status_div,obj.inst_id,role,obj.filename,obj.inst_name,obj.job_name,obj.institute_descr,obj.job_id,obj.institute_type,obj.institute_bemail,obj.institute_contact,obj.institute_address,obj.institute_country,obj.institute_zip,datetime))

				else:
					fromuser=row["FromUser"]
					text=row['Text']
					if fromuser=="Admin":
						if text=="verified":
							print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4>Verification <span class="glyphicon glyphicon-ok-sign" style="color:green;"><span></h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>
					<div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s"  class="alert-dismissable fade in"><strong>%s </strong> : Hurray!!Your profile is varified successfully.</div></div><div class="col-md-3 pull-right">%s</div></div></div><br/>"""%(divid,divid,fromuser,datetime))
						elif text=="rejected":
							print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4>Verification <span class="glyphicon glyphicon-remove" style="color:red;"><span></h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>
					<div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s"  class="alert-dismissable fade in"><strong>%s </strong> : We are sorry!!Your profile is rejected.</div></div><div class="col-md-3 pull-right">%s</div></div></div><br/>"""%(divid,divid,fromuser,datetime))
	except:
		conn.rollback()
		print("Try again !2")
	print('<script type="text/javascript" src="js/read_more.js"></script>')
	print('<script type="text/javascript" src="js/show_inst.js"></script>')
	conn.close()

def reload_messages(load_inbox,cand_id):
	if load_inbox=="all":
		role_div="role='Offer' and ToUserID='%s' or role='Request' and ToUserID='%s' or role='Request_accepted' and ToUserID='%s' or role='Candidate' and ToUserID='%s'"%(cand_id,cand_id,cand_id,cand_id)
		reload_all(cand_id,role_div)
	elif load_inbox=="offer":
		role_div="role='Offer'"
		reload_all(cand_id,role_div)
	elif load_inbox=="request":
		role_div="role='Request'"
		reload_all(cand_id,role_div)

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
	sql="DELETE FROM chat where ToUserID='%s' and role='Candidate' or role='Offer'"%(c_id1)
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
	sql="select Type,ID,ToUserID,FromUser,Time,Text,role from(select 'chat' as Type,ID,ToUserID,FromUser,Time,Text,role from chat where ToUserID='%s' and %s UNION ALL select 'application' as Type,application_id,candidate_id,institute_id,apply_datetime,job_id,status_bit from applications where candidate_id='%s') as Messages ORDER BY Time DESC"%(c_id1,role_div,c_id1)
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

def mess_count_part(load_inbox,cand_id):
	if load_inbox=="all":
		role_div="role='Offer' and ToUserID='%s' or role='Request' and ToUserID='%s' or role='Request_accepted' and ToUserID='%s' or role='Candidate' and ToUserID='%s'"%(cand_id,cand_id,cand_id,cand_id)
		mess_total_count(cand_id,role_div)
	elif load_inbox=="offer":
		role_div="role='Offer'"
		mess_total_count(cand_id,role_div)
	elif load_inbox=="request":
		role_div="role='Request'"
		mess_total_count(cand_id,role_div)