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

def reload_messages(c_id1):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM chat where ToUserID='%s' and role='Candidate' or role='Offer' ORDER BY Time ASC"%(c_id1)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		for row in results:
			role=row['role']
			divid=row['ID']
			time=row["Time"]
			datetime=time.strftime('%d-%m-%Y %H : %M %a')
			if role=="Offer":
				fromuser=row["FromUser"]
				jobid=row['Text']
				sql_inst="SELECT * FROM institutes where ID='%s'"%(fromuser)
				try:
					cursor.execute(sql_inst)
					row_inst = cursor.fetchone()
					inst_id=row_inst['ID']
					inst_name = row_inst['Bname']
					inst_image=row_inst['Image']
					institute_bemail=row_inst['Bemail'];
					institute_contact=row_inst['Phone'];
					institute_type=row_inst['institute_type'];
					institute_descr=row_inst['institute_descr'];
					institute_address=row_inst['institute_address'];
					institute_country=row_inst['institute_country'];
					institute_zip=row_inst['institute_zip'];
					if not os.path.exists("Inst_images"):
						os.makedirs("Inst_images")
					filename = "Inst_images/%s.jpeg"%inst_name
					with open(filename, 'wb') as f:
						f.write(inst_image)
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
						print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4>Job offer</h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>
						<a href="#" id="show_institute" class="div_link"><div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s" class="alert-dismissable fade in inst_id"><div class="media"><div class="media-left"><img class="img-circle" style="height:150px;" src="%s" /></div><div class="media-body" style="line-height: 25px;"><h4 class="media-heading"><b>Institute name : </b>%s</h4><div class="row"><div class="col-xs-6"><h5><b>Job Title : </b>%s</h5>
						<h5 id="description_first"><b>Institute description : </b>%s</h5>
						</div><div class="col-xs-6 job_id" id="%s">
						<h5><b>Institute Type: </b>%s</h5>
                    	<h5><b>Business Email: </b>%s</h5>
                    	<h5><b>Business Contact: </b>%s</h5>
                    	<h5><b>Institute Address: </b>%s</h5>
						<h5><b>Country: </b>%s</h5>
						<h5><b>ZIP: </b>%s</h5></div></div></div></div></div></div><div class="col-md-3 pull-right">%s</div></div></a></div><br/>"""%(divid,inst_id,filename,inst_name,job_name,institute_descr,job_id,institute_type,institute_bemail,institute_contact,institute_address,institute_country,institute_zip,datetime))
					except:
						print("Try again !")
				except:
					print("Try again !")
			else:
				fromuser=row["FromUser"]
				text=row['Text']
				print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4>Verification <span class="glyphicon glyphicon-ok-sign" style="color:green;"><span></h4></div><div class="col-md-3"><a href="#" onclick='delete_mes("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>
				<div class="row" style="margin-bottom:20px;"><div class="col-md-9"><div id="%s"  class="alert-dismissable fade in"><strong>%s </strong> : %s </div></div><div class="col-md-3 pull-right">%s</div></div></div><br/>"""%(divid,divid,fromuser,text,datetime))
	except:
		conn.rollback()
		print("Try again !")
	print('<script type="text/javascript" src="js/read_more.js"></script>')
	conn.close()

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

def mess_total_count(c_id1):
	global cursor,conn
	connect_to_database()
	sql="SELECT * FROM Chat where ToUserID='%s' and role='Candidate' or role='Offer'"%(c_id1)
	try:
		cursor.execute(sql)
		results=cursor.rowcount
		rownum="%s"%results
		print(rownum)
		conn.commit()
	except:
		conn.rollback()
		print("0")
	conn.close()