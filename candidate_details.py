#!/usr/bin/python
import cgi, cgitb
import sys
import os
import pymysql
class candidate:
	global cand_id,cand_name,cand_image,cand_email,cand_contact,filename,quali_str,quali_arr,cand_rank
	global course,gender,passing_year,internship,degree,country,state,city,experience
	def candidate_details(self,conn,cursor,cand_id):
		sql_cand="SELECT ID,Name,Image,Email,Phone,Candidate_rank,Quali,Course,Gender,Passing_year,Intern,Degree,Country,State,City FROM Candidates where ID='%s'"%(cand_id)
		try:
			cursor.execute(sql_cand)
			row_cand = cursor.fetchone()
			self.cand_id=row_cand[0]
			self.cand_name = row_cand[1]
			self.cand_image=row_cand[2]
			self.cand_email=row_cand[3]
			self.cand_contact=row_cand[4]
			self.cand_rank=row_cand[5]
			self.quali_str=row_cand[6]
			self.quali_arr=self.quali_str.split(",/,")
			if not os.path.exists("cand_images"):
				os.makedirs("cand_images")
			self.filename = "cand_images/%s.jpeg"%self.cand_name
			with open(self.filename, 'wb') as f:
				f.write(self.cand_image)
			self.course=row_cand[7]
			self.gender=row_cand[8]
			self.passing_year=row_cand[9]
			self.internship=row_cand[10]
			self.degree=row_cand[11]
			self.country=row_cand[12]
			self.state=row_cand[13]
			self.city=row_cand[14]
			self.experience=row_cand[15]
		except:
			print("Server is taking too load")
