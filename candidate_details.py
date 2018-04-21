#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import config

class candidate:
	global cand_id,cand_name,cand_image,cand_email,cand_contact,filename,cand_image,quali_str,quali_arr
	def candidate_details(self,conn,cursor,cand_id):
		sql_cand="SELECT * FROM Candidates where ID='%s'"%(cand_id)
		try:
			cursor.execute(sql_cand)
			row_inst = cursor.fetchone()
			self.cand_id=row_inst['ID']
			self.cand_name = row_inst['Name']
			self.cand_image=row_inst['Image']
			self.cand_email=row_inst['Email']
			self.cand_contact=row_inst['Phone']
			self.quali_str=row_inst['Quali']
			self.quali_arr=self.quali_str.split(",/,")
			for i in self.quali_arr:
				print("%s"%i)
			if not os.path.exists("cand_images"):
				os.makedirs("cand_images")
			self.filename = "cand_images/%s.jpeg"%self.cand_name
			with open(self.filename, 'wb') as f:
				f.write(self.cand_image)
		except:
			print("Server is taking too load")
