#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import security
import save_history
import config
			
def count_rows(instid,candid,jobid):
	conn,cursor=config.connect_to_database()
	sql="select * from chat where FromUser='%s' and ToUserID='%s' and Text='%s'"%(instid,candid,jobid)
	try:
		cursor.execute(sql)
		num=cursor.rowcount
		return num
	except:
		conn.rollback()
		return "-1"
	conn.close()

def check_offer_cand(c_id,inst_id,j_id):
	conn,cursor=config.connect_to_database()
	sql="select Type,ID,ToUserID,FromUser,Time,Text,role from(select 'chat' as Type,ID,ToUserID,FromUser,Time,Text,role from chat UNION ALL select 'application' as Type,application_id,candidate_id,institute_id,apply_datetime,job_id,status_bit from applications) as Messages where FromUser='%s' and ToUserID='%s' and Text='%s'"%(inst_id,c_id,j_id)
	try:
		cursor.execute(sql)
		result=cursor.rowcount
		if result==1:
			row=cursor.fetchone()
			role=row['role']
			return role
		else:
			return "1x"
	except:
		conn.rollback()
		return "-1x"
	conn.close()

def accept_offer(candid,instid,jobid,role):
	conn,cursor=config.connect_to_database()
	num=count_rows(instid,candid,jobid)
	num=int(num)
	if num==1:
		sql="update chat SET role='%s' where FromUser='%s' and ToUserID='%s' and Text='%s'"%(role,instid,candid,jobid)
		try:
			cursor.execute(sql)
			conn.commit()
			mess=instid
			save_history.enter_history(conn,cursor,mess,candid,role)
			print("1")
		except:
			conn.rollback()
			print("-1")
	else:
		print("-1")
	conn.close()
	
def deny_offer(candid,instid,jobid,role):
	conn,cursor=config.connect_to_database()
	num=count_rows(instid,candid,jobid)
	num=int(num)
	if num==1:
		sql="Update chat SET role='%s' where FromUser='%s' and ToUserID='%s' and Text='%s'"%(role,instid,candid,jobid)
		try:
			cursor.execute(sql)
			conn.commit()
			mess=instid
			role="Deny_offer"
			save_history.enter_history(conn,cursor,mess,candid,role)
			print("1")
		except:
			conn.rollback()
			print("-1")
	else:
		print("-1")
	conn.close()
