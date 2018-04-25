#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import base64
import config
import institute_and_job
import no_found
import candidate_details

def application_candidates(conn,cursor,cand_id,inst_id,job_id,cand_list):
	sql_app="select Type,ID,ToUserID,FromUser,Time,Text,role from(select 'chat' as Type,ID,ToUserID,FromUser,Time,Text,role from chat UNION ALL select 'application' as Type,application_id,candidate_id,institute_id,apply_datetime,job_id,status_bit from applications) as Messages where FromUser='%s' and Text='%s' and role='Accepted' or role='1'"%(inst_id,job_id)
	try:
		cursor.execute(sql_app)
		results=cursor.fetchall()
		cand_id=int(cand_id)
		for row in results:
			cand_id2=int(row['ToUserID'])
			if row['ToUserID'] not in cand_list and cand_id2!=cand_id:
				cand_list.append(row['ToUserID'])
		print("%s"%cand_list)
		return cand_list
	except:
		conn.rollback()
		return "-99x"



def get_string(string):
	if string!=None:
		string=string.strip()
		string=string.lower()
		return string
	else:
		return "None"

def get_int(string):
	if string!=None:
		string=int(string)
		return string
	else:
		return "None"

def get_percentage_of_match(conn,cursor,main_cand_id,cand_list):
	match_list=[]
	total_list=[]
	for i in cand_list:
		total_match=0
		total=0
		cand=candidate_details.candidate()
		cand.candidate_details(conn,cursor,main_cand_id)
		test_cand=candidate_details.candidate()
		test_cand.candidate_details(conn,cursor,i)
		if (get_string(cand.course)!="None") and (get_string(test_cand.course)!="None"):
			if get_string(cand.course)==get_string(test_cand.course):
				total_match+=5
			total+=5
		if get_string(cand.degree)!="None" and get_string(test_cand.degree)!="None":
			if get_string(cand.degree)==get_string(test_cand.degree):
				total_match+=5
			total+=5
		if get_string(cand.passing_year)!="None" and get_string(test_cand.passing_year)!="None":
			if get_int(cand.passing_year)==get_string(test_cand.passing_year):
				total_match+=2
			total+=2
		if get_string(cand.internship)!="None" and get_string(test_cand.internship)!="None":
			if get_string(cand.internship)==get_string(test_cand.internship):
				total_match+=5
			total+=5
		if get_string(cand.country)!="None" and get_string(test_cand.country)!="None":
			if get_string(cand.country)==get_string(test_cand.country):
				total_match+=1
				if get_string(cand.state)!="None" and get_string(test_cand.state)!="None":
					if get_string(cand.state)==get_string(test_cand.state):
						total_match+=1
						if get_string(cand.city)!="None" and get_string(test_cand.city)!="None":
							if get_string(cand.city)==get_string(test_cand.city):
								total_match+=1
							total+=1
					total+=1
			total+=1
		if get_int(cand.cand_rank)!="None" and get_int(test_cand.cand_rank)!="None":
			if get_int(cand.cand_rank)==get_int(test_cand.cand_rank):
				total_match+=10
			elif get_int(cand.cand_rank)>=get_int(test_cand.cand_rank):
				total_match+=20
			total+=20
		if get_int(cand.experience)!="None" and get_int(test_cand.experience)!="None":
			if get_int(cand.experience)==get_int(test_cand.experience):
				total_match+=10
			elif get_int(cand.experience)>=get_int(test_cand.experience):
				total_match+=20
			total+=20
		total_list.append(total)
		match_list.append(total_match)
		print("%s <br/> %s"%(total,total_match))
	length=len(match_list)
	perc_total=0
	print("%s"%length)
	for i in range(length):
		perc=(int(match_list[i])/int(total_list[i]))*100
		print("%s"%perc)
		perc_total+=perc
		print("%s"%perc_total)
	perc_final=perc_total/length
	print("%s"%perc_final)
	return perc_final
	
def print_on_screen(match,job_id):
	print("""<div style="margin:20px;padding:20px;background-color:white;border-left:3px solid rgba(23,139,158,1.00);border-top:2px solid rgba(23,139,158,1.00);box-shadow: 5px 5px 5px #aaaaaa;"><div class="row"><div class="col-md-9"><h4>Your net prediction to get job is <b>%.2f %%</b></h4></div><div class="col-md-3"><a href="#"' class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div><hr style="border-width:2px;border-color:rgbs(180,180,180,1.00);"/>%s"""%(match,job_id))
	
	
def predictor_cal(cand_id,job_id):
	conn,cursor=config.connect_to_database()
	obj_job=institute_and_job.institute_and_job()
	obj_job.job_details(conn,cursor,job_id)
	inst_id=obj_job.job_inst_id
	obj_inst=institute_and_job.institute_and_job()
	obj_inst.institute_details(conn,cursor,inst_id)
	cand_list=[]
	state=application_candidates(conn,cursor,cand_id,inst_id,job_id,cand_list)
	if state!="-99x":
		cand_list=state
		match=get_percentage_of_match(conn,cursor,cand_id,cand_list)
		print_on_screen(match,job_id)
		