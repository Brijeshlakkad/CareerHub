#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb

def connect_to_database():
	global conn,cursor
	conn = MySQLdb.connect (host = "localhost",user = "root",passwd = "",db = "mini_project")
	cursor = conn.cursor ()
	cursor = conn.cursor(MySQLdb.cursors.DictCursor)

def reload_all(inst_id,role_div):
	global cursor,conn
	connect_to_database()
	sql="Select * from chat where %s ORDER BY Time DESC"%(role_div)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		for row in results:
			role=row['role']
			divid=row['ID']
			time=row["Time"]
			datetime=time.strftime('%H : %M')
			if role=="Accepted":
				fromuser=row["ToUserID"]
				jobid=row['Text']
				sql_cand="SELECT * FROM Candidates where ID='%s'"%(fromuser)
				try:
					cursor.execute(sql_cand)
					row_inst = cursor.fetchone()
					cand_id=row_inst['ID']
					cand_name = row_inst['Name']
					cand_image=row_inst['Image']
					cand_email=row_inst['Email']
					cand_contact=row_inst['Phone']
					if not os.path.exists("cand_images"):
						os.makedirs("cand_images")
					filename = "cand_images/%s.jpeg"%cand_name
					with open(filename, 'wb') as f:
						f.write(cand_image)
					sql_job="SELECT * FROM jobs where job_id='%s'"%(jobid)
					try:
						cursor.execute(sql_job)
						row_job = cursor.fetchone()
						job_id = row_job['job_id']
						job_name = row_job['job_title']
						print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;">
						<div class="row" style=""><div class="col-md-9"></div><div class="col-md-3 pull-right">%s</div></div>
						<div class="row"><div class="col-md-9"><div class="media"><div class="media-left"><img class="img-circle" style="height:60px;" src="%s" /></div><div class="media-body" style="line-height: 25px;"><h4><a class="btn" id="show_candidate_link" class="div_link" onclick='get_candidate_profile("%s","%s")'><span id='%s' class='cand_id'><h4><b>%s</b></h4></span></a> accepted Job <span class='job_id' id='%s'>%s</span></h4></div></div></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div></div><br/>"""%(time,filename,cand_id,job_id,cand_id,cand_name,job_id,job_name,divid))
					except:
						print("Try again !")
				except:
					print("Try again !")
			elif role=="Offer":
				fromuser=row["ToUserID"]
				jobid=row['Text']
				sql_cand="SELECT * FROM Candidates where ID='%s'"%(fromuser)
				try:
					cursor.execute(sql_cand)
					row_inst = cursor.fetchone()
					cand_id=row_inst['ID']
					cand_name = row_inst['Name']
					cand_image=row_inst['Image']
					cand_email=row_inst['Email']
					cand_contact=row_inst['Phone']
					if not os.path.exists("cand_images"):
						os.makedirs("cand_images")
					filename = "cand_images/%s.jpeg"%cand_name
					with open(filename, 'wb') as f:
						f.write(cand_image)
					sql_job="SELECT * FROM jobs where job_id='%s'"%(jobid)
					try:
						cursor.execute(sql_job)
						row_job = cursor.fetchone()
						job_id = row_job['job_id']
						job_name = row_job['job_title']
						print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;">
						<div class="row" style=""><div class="col-md-9"></div><div class="col-md-3 pull-right">%s</div></div>
						<div class="row"><div class="col-md-9"><div class="media"><div class="media-left"><img class="img-circle" style="height:60px;" src="%s" /></div><div class="media-body" style="line-height: 25px;"><h4>Job <span class='job_id' id='%s'><b>%s</b> offer sent to <span style='cursor:pointer;' class="show_candidate_link"><span id='%s' class='cand_id'><b>%s</b></span></span></span></h4></div></div></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div></div><br/>"""%(time,filename,job_id,job_name,cand_id,cand_name,divid))
					except:
						print("Try again !")
				except:
					print("Try again !")
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
		role_div="role='Candidate' or role='Offer' or role='Accepted'"
		mess_total_count(cand_id,role_div)
	elif load_inbox=="offer_sent":
		role_div="role='Offer'"
		mess_total_count(cand_id,role_div)
	elif load_inbox=="accpeted":
		role_div="role='Accepted'"
		mess_total_count(cand_id,role_div)