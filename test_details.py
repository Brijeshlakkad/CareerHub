#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb

class test:
	global title,course,postedby,sub_string
	def test_details(self,conn,cursor,testid):
		sql_test="SELECT * FROM Tests where ID='%s'"%(testid)
		try:
			cursor.execute(sql_test)
			result_of_test = cursor.fetchone()
			self.title=result_of_test['Title']
			self.course=result_of_test['Course']
			str_sub=result_of_test['Subjects']
			self.postedby=result_of_test['Postedby']
			if self.postedby=="-99":
				self.postedby="CareerHub"
			subjects=str_sub.split("|")
			if len(subjects)==1:
				self.sub_string=str_sub.strip()
			else:
				self.sub_string=""
				j=0
				for i in subjects:
					if j==0:
						self.sub_string+=i.strip()
					else:
						self.sub_string+=", "+i.strip()
					j+=1
				self.sub_string+=""
		except:
			conn.rollback()
			print("Server is taking load...")
