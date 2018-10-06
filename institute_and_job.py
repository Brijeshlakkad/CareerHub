#!/usr/bin/python
import cgi, cgitb
import sys
import os
import pymysql
import base64

class institute_and_job:
	global inst_id,inst_name,institute_bemail,institute_contact,institute_type,institute_descr
	global institute_address,institute_country,institute_zip,filename,inst_impressions,job_impressions
	global job_id,job_name,job_location,job_inst_id
	def institute_details(self,conn,cursor,fromuser):
		sql_inst="SELECT ID,Bname,Image,Bemail,Phone,institute_type,institute_descr,institute_address,institute_country,institute_zip,Impression FROM institutes where ID='%s'"%(fromuser)
		try:
			cursor.execute(sql_inst)
			row_inst = cursor.fetchone()
			self.inst_id=row_inst[0]
			self.inst_name = row_inst[1]
			self.inst_image=row_inst[2]
			self.institute_bemail=row_inst[3]
			self.institute_contact=row_inst[4]
			self.institute_type=row_inst[5]
			self.institute_descr=row_inst[6]
			self.institute_address=row_inst[7]
			self.institute_country=row_inst[8]
			self.institute_zip=row_inst[9]
			self.inst_impressions=row_inst[10]
			if not os.path.exists("Inst_images"):
				os.makedirs("Inst_images")
			self.filename = "Inst_images/%s.jpeg"%self.inst_name
			with open(self.filename, 'wb') as f:
				f.write(self.inst_image)
		except:
			print("try again!")
	def job_details(self,conn,cursor,jobid):
		sql_job="SELECT job_id,job_title,job_impressions,institute_id,country,state,city FROM jobs where job_id='%s'"%(jobid)
		try:
			cursor.execute(sql_job)
			row_job = cursor.fetchone()
			self.job_id = row_job[0]
			self.job_name = row_job[1]
			self.job_impressions=row_job[2]
			self.job_inst_id=row_job[3]
			job_l1 = row_job[4]
			job_l2 = row_job[5]
			job_l3 = row_job[6]
			self.job_location = "%s, %s, %s"%(job_l3,job_l2,job_l1)
		except:
			print("try again!")
