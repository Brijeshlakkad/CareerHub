#!/usr/bin/python
import cgi, cgitb
import sys
import os
import pymysql
import accept_offer
import config
import no_found
import institute_and_job
def reload_history(c_id1):
	conn,cursor=config.connect_to_database()
	sql="SELECT ID,`Time`,Field,role FROM History where UserID='%s' ORDER BY `Time` DESC"%(c_id1)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		rownum=cursor.rowcount
		if rownum==0:
			no_found.no_found("History(0)")
		else:
			for row in results:
				divid=row[0]
				time=row[1]
				datetime=time.strftime('%H : %M')
				field=row[2]
				role=row[3]
				if role=="Accepted":
					obj_inst=institute_and_job.institute_and_job()
					obj_inst.institute_details(conn,cursor,field)
					inst_name=obj_inst.inst_name
					field_link="""<a id='inst_profile_link' style="cursor:pointer;" onclick="get_institute_profile(%s)" class='div_link'>%s</a>"""%(field,inst_name)
					fdiv="You have <strong>acccepted offer from %s</strong> at %s"%(field_link,datetime)
				elif role=="Deny_offer":
					obj_inst=institute_and_job.institute_and_job()
					obj_inst.institute_details(conn,cursor,field)
					inst_name=obj_inst.inst_name
					field_link="""<a id='inst_profile_link' style="cursor:pointer;" onclick="get_institute_profile(%s)" class='div_link'>%s</a>"""%(field,inst_name)
					fdiv="You have <strong>denied offer from %s</strong> at %s"%(field_link,datetime)
				else:
					fdiv="You have updated <strong> %s</strong> at %s"%(field,datetime)
				print("""<div id="%s"  class="alert alert-info alert-dismissable fade in" ><a href="#" onclick='delete_hist("%s")' class="close" data-dismiss="alert" aria-label="close">&times;</a> %s </div><br/>"""%(divid,divid,fdiv))
	except:
		conn.rollback()
		print("Try again !")
	conn.close()

def delete_history(c_id1):
	conn,cursor=config.connect_to_database()
	c_id1=int(c_id1)
	sql="DELETE FROM History where ID='%s'"%(c_id1)
	try:
		cursor.execute(sql)
		conn.commit()
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def delete_all_history(c_id1):
	conn,cursor=config.connect_to_database()
	sql="DELETE FROM History where UserID='%s'"%(c_id1)
	try:
		cursor.execute(sql)
		conn.commit()
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def history_total_count(c_id1):
	conn,cursor=config.connect_to_database()
	sql="SELECT * FROM History where UserID='%s'"%(c_id1)
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
