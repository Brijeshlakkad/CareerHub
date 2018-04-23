#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import base64
import config
import institute_and_job
import no_found

def add_visitor(visitor_id,profile_id):
	conn,cursor=config.connect_to_database()
	rownum,howmanytimes=count_visits(visitor_id,profile_id)
	rownum=int(rownum)
	howmanytimes=int(howmanytimes)
	if rownum==0 and howmanytimes==0:
		sql_visit="Insert into profile_visit(ProfileID,PersonID) values('%s','%s')"%(profile_id,visitor_id)
	else:
		howmanytimes+=1
		sql_visit="Update profile_visit SET HowManyTimes='%s' where ProfileID='%s' and PersonID='%s'"%(howmanytimes,profile_id,visitor_id)
	try:
		cursor.execute(sql_visit)
		conn.commit()
		obj_inst=institute_and_job.institute_and_job()
		obj_inst.institute_details(conn,cursor,profile_id)
		inst_impression=obj_inst.inst_impressions
		inst_impression=int(inst_impression)
		inst_impression+=1
		sql_inst="Update Institutes SET Impression='%s' where ID='%s'"%(inst_impression,profile_id)
		try:
			cursor.execute(sql_inst)
			conn.commit()
			print("11")
		except:
			conn.rollback()
			print("Server is taking too load..")
	except:
		conn.rollback()
		print("Server is taking too load..")

def count_visits(visitor_id,profile_id):
	conn,cursor=config.connect_to_database()
	sql_visit="select * from profile_visit where PersonID='%s' and ProfileID='%s'"%(visitor_id,profile_id)
	try:
		cursor.execute(sql_visit)
		rownum=cursor.rowcount
		if rownum==0:
			howmanytimes=0
		else:
			result=cursor.fetchone()
			howmanytimes=result['HowManyTimes']
		return rownum,howmanytimes
	except:
		conn.rollback()
		print("Server is taking too load..")