#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import base64

class institute_and_job:
	global inst_id,inst_name,institute_bemail,institute_contact,institute_type,institute_descr
	global institute_address,institute_country,institute_zip,filename,inst_impressions,job_impressions
	global job_id,job_name,job_location
	def institute_details(self,conn,cursor,fromuser):
		sql_inst="SELECT * FROM institutes where ID='%s'"%(fromuser)
		try:
			cursor.execute(sql_inst)
			row_inst = cursor.fetchone()
			self.inst_id=row_inst['ID']
			self.inst_name = row_inst['Bname']
			self.inst_image=row_inst['Image']
			self.institute_bemail=row_inst['Bemail']
			self.institute_contact=row_inst['Phone']
			self.institute_type=row_inst['institute_type']
			self.institute_descr=row_inst['institute_descr']
			self.institute_address=row_inst['institute_address']
			self.institute_country=row_inst['institute_country']
			self.institute_zip=row_inst['institute_zip']
			self.inst_impressions=row_inst['Impression']
			if not os.path.exists("Inst_images"):
				os.makedirs("Inst_images")
			self.filename = "Inst_images/%s.jpeg"%self.inst_name
			with open(self.filename, 'wb') as f:
				f.write(self.inst_image)
		except:
			print("try again!")
	def job_details(self,conn,cursor,jobid):
		sql_job="SELECT * FROM jobs where job_id='%s'"%(jobid)
		try:
			cursor.execute(sql_job)
			row_job = cursor.fetchone()
			self.job_id = row_job['job_id']
			self.job_name = row_job['job_title']
			self.job_impressions=row_job['job_impressions']
			job_l1 = row_job['country']
			job_l2 = row_job['state']
			job_l3 = row_job['city']
			self.job_location = "%s, %s, %s"%(job_l3,job_l2,job_l1)
		except:
			print("try again!")