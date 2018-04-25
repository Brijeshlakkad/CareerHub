#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb

class candidate:
	global cand_id,cand_name,cand_image,cand_email,cand_contact,filename,quali_str,quali_arr,cand_rank
	global course,gender,passing_year,internship,degree,country,state,city,experience
	def candidate_details(self,conn,cursor,cand_id):
		sql_cand="SELECT * FROM Candidates where ID='%s'"%(cand_id)
		try:
			cursor.execute(sql_cand)
			row_cand = cursor.fetchone()
			self.cand_id=row_cand['ID']
			self.cand_name = row_cand['Name']
			self.cand_image=row_cand['Image']
			self.cand_email=row_cand['Email']
			self.cand_contact=row_cand['Phone']
			self.cand_rank=row_cand['Candidate_rank']
			self.quali_str=row_cand['Quali']
			self.quali_arr=self.quali_str.split(",/,")
			if not os.path.exists("cand_images"):
				os.makedirs("cand_images")
			self.filename = "cand_images/%s.jpeg"%self.cand_name
			with open(self.filename, 'wb') as f:
				f.write(self.cand_image)
			self.course=row_cand['Course']
			self.gender=row_cand['Gender']
			self.passing_year=row_cand['Passing_year']
			self.internship=row_cand['Intern']
			self.degree=row_cand['Degree']
			self.country=row_cand['Country']
			self.state=row_cand['State']
			self.city=row_cand['City']
			self.experience=row_cand['Experience']
		except:
			print("Server is taking too load")