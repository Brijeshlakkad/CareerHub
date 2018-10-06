#!/usr/bin/python
import cgi, cgitb
import sys
import os
import pymysql
import security
import config
import candidate_details

def send_offer_cand(c_id,inst_id,j_id,role):
	conn,cursor=config.connect_to_database()
	sql="Insert into chat(FromUser,ToUserID,Text,role) values('%s','%s','%s','%s')"%(inst_id,c_id,j_id,role)
	try:
		cursor.execute(sql)
		conn.commit()
		obj_cand=candidate_details.candidate()
		obj_cand.candidate_details(conn,cursor,c_id)
		cand_rank=obj_cand.cand_rank
		cand_rank=int(cand_rank)
		cand_rank+=100
		sql_cand="update candidates set Candidate_rank='%s' where ID='%s'"%(cand_rank,c_id)
		try:
			cursor.execute(sql_cand)
			conn.commit()
			print("11")
		except:
			conn.rollback()
			print("00")
	except:
		conn.rollback()
		print("00")
	conn.close()

def delete_offer_cand(c_id,inst_id,j_id,role):
	conn,cursor=config.connect_to_database()
	sql="delete from chat where FromUser='%s' and ToUserID='%s' and Text='%s' and role='%s'"%(inst_id,c_id,j_id,role)
	try:
		cursor.execute(sql)
		conn.commit()
		print("11")
	except:
		conn.rollback()
		print("00")
	conn.close()

def check_offer_cand(c_id,inst_id,j_id):
	conn,cursor=config.connect_to_database()
	sql="select role from chat where FromUser='%s' and ToUserID='%s' and Text='%s'"%(inst_id,c_id,j_id)
	try:
		cursor.execute(sql)
		result=cursor.rowcount
		if result==1:
			row=cursor.fetchone()
			role=row[0]
			return "%s"%role
		else:
			return "1x"
	except:
		conn.rollback()
		return "-1x"
	conn.close()
