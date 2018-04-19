#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import base64
def connect_to_database():
	global conn,cursor
	conn = MySQLdb.connect (host = "localhost",user = "root",passwd = "",db = "mini_project")
	cursor = conn.cursor ()
	cursor = conn.cursor(MySQLdb.cursors.DictCursor)
	
def institute_details(conn,cursor,fromuser):
	global inst_id,inst_name,institute_bemail,institute_contact,institute_type,institute_descr
	global institute_address,institute_country,institute_zip,filename
	sql_inst="SELECT * FROM institutes where ID='%s'"%(fromuser)
	try:
		cursor.execute(sql_inst)
		row_inst = cursor.fetchone()
		inst_id=row_inst['ID']
		inst_name = row_inst['Bname']
		inst_image=row_inst['Image']
		institute_bemail=row_inst['Bemail']
		institute_contact=row_inst['Phone']
		institute_type=row_inst['institute_type']
		institute_descr=row_inst['institute_descr']
		institute_address=row_inst['institute_address']
		institute_country=row_inst['institute_country']
		institute_zip=row_inst['institute_zip']
		if not os.path.exists("Inst_images"):
			os.makedirs("Inst_images")
		filename = "Inst_images/%s.jpeg"%inst_name
		with open(filename, 'wb') as f:
			f.write(inst_image)
	except:
		print("try again!")
		
def job_details(conn,cursor,jobid):
	global job_id,job_name,job_location
	sql_job="SELECT * FROM jobs where job_id='%s'"%(jobid)
	try:
		cursor.execute(sql_job)
		row_job = cursor.fetchone()
		job_id = row_job['job_id']
		job_name = row_job['job_title']
		job_l1 = row_job['country']
		job_l2 = row_job['state']
		job_l3 = row_job['city']
		job_location = "%s, %s, %s"%(job_l3,job_l2,job_l1)
	except:
		print("try again!")
	
def reload_all(c_id1,role_div):
	global cursor,conn
	global inst_id,inst_name,inst_image,institute_bemail,institute_contact,institute_type,institute_descr
	global institute_address,institute_country,institute_zip,filename
	global job_id,job_name,job_location
	connect_to_database()
	c_id1=int(c_id1)
	role_div=str(role_div)
	sql_mess="SELECT * FROM chat where ToUserID='%s' and %s ORDER BY Time ASC"%(c_id1,role_div)
	try:
		cursor.execute(sql_mess)
		results = cursor.fetchall()
		for row in results:
			c_id2=row['ToUserID']
			role=row['role']
			divid=row['ID']
			time=row["Time"]
			datetime=time.strftime('%d-%m-%Y %H : %M %a')
			if role=="Offer":
				fromuser=row["FromUser"]
				jobid=row['Text']
				institute_details(conn,cursor,fromuser)
				job_details(conn,cursor,jobid)
				print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4><b>Job offer</b></h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/><a  class="div_link show_institute" style="cursor:pointer;"><div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s" class="alert-dismissable fade in inst_id"><div class="media role_type" id='Offer'><div class="media-left"><img class="img-circle" style="height:150px;" src="%s" /></div><div class="media-body" style="line-height: 25px;"><h4 class="media-heading"><b>Institute name : </b>%s</h4><div class="row"><div class="col-xs-6"><h5><b>Job Title : </b>%s</h5><h5 class="description_first"><b>Institute description : </b>%s</h5></div><div class="col-xs-6 job_id" id="%s">
						<h5><b>Institute Type: </b>%s</h5>
                    	<h5><b>Business Email: </b>%s</h5>
                    	<h5><b>Business Contact: </b>%s</h5>
                    	<h5><b>Institute Address: </b>%s</h5>
						<h5><b>Country: </b>%s</h5>
						<h5><b>ZIP: </b>%s</h5></div></div></div></div></div></div><div class="col-md-3 pull-right">%s</div></div></a></div><br/>"""%(divid,inst_id,filename,inst_name,job_name,institute_descr,job_id,institute_type,institute_bemail,institute_contact,institute_address,institute_country,institute_zip,datetime))
			elif role=="Request_accepted":
				fromuser=row["FromUser"]
				app_id=row['Text']
				sql="select * from applications where application_id='%s'"%(app_id)
				try:
					cursor.execute(sql)
					result=cursor.fetchone()
					inst_id=result['institute_id']
					jobid=result['job_id']
					institute_details(conn,cursor,inst_id)
					job_details(conn,cursor,jobid)
					print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4><b>Request Accepted</b></h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/><a  class="div_link show_institute" style="cursor:pointer;"><div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s" class="alert-dismissable fade in inst_id"><div class="media role_type" id='Request_accepted'><div class="media-left"><img class="img-circle" style="height:150px;" src="%s" /></div><div class="media-body" style="line-height: 25px;"><h4 class="media-heading"><b>Institute name : </b>%s</h4><div class="row"><div class="col-xs-6"><h5><b>Job Title : </b>%s</h5><h5 class="description_first"><b>Institute description : </b>%s</h5></div><div class="col-xs-6 job_id" id="%s">
						<h5><b>Institute Type: </b>%s</h5>
                    	<h5><b>Business Email: </b>%s</h5>
                    	<h5><b>Business Contact: </b>%s</h5>
                    	<h5><b>Institute Address: </b>%s</h5>
						<h5><b>Country: </b>%s</h5>
						<h5><b>ZIP: </b>%s</h5></div></div></div></div></div></div><div class="col-md-3 pull-right">%s</div></div></a></div><br/>"""%(divid,inst_id,filename,inst_name,job_name,institute_descr,job_id,institute_type,institute_bemail,institute_contact,institute_address,institute_country,institute_zip,datetime))
				except:
					print("Try again !")
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
		print("Try again !")
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
	global cursor,conn
	connect_to_database()
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
	global cursor,conn
	connect_to_database()
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
	global cursor,conn
	connect_to_database()
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

def mess_count_part(load_inbox,cand_id):
	if load_inbox=="all":
		role_div="role='Offer' or role='Request' or role='Candidate' and ToUserID='%s'"%cand_id
		mess_total_count(cand_id,role_div)
	elif load_inbox=="offer":
		role_div="role='Offer'"
		mess_total_count(cand_id,role_div)
	elif load_inbox=="request":
		role_div="role='Request'"
		mess_total_count(cand_id,role_div)