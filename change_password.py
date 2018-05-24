#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import pymysql
import cgi, cgitb 
import sys
import os
import re

from smtplib import SMTP_SSL as SMTP 
from email.mime.text import MIMEText

class Mail:
	USERNAME = "Your Email"
	PASSWORD = "Your password"
	def send_mail(self,email_ad):
		SMTPserver = 'smtp.gmail.com'
		sender =     'brijeshlakkad22@gmail.com'
		destination = email_ad
		text_subtype = 'html'
		content="""\
		<b>Your Password has changed successfully.</b> <br>
		"""
		subject="Password Changed"
		try:
			msg = MIMEText(content, text_subtype)
			msg['Subject']= subject
			msg['From']   = sender 
			conn = SMTP(SMTPserver)
			conn.set_debuglevel(False)
			conn.login(self.USERNAME, self.PASSWORD)
			try:
				conn.sendmail(sender, destination, msg.as_string())
				print("1")
			finally:
				conn.quit()
		except Exception:
			print("0")

m=Mail()
form = cgi.FieldStorage()
db=pymysql.connect("localhost",'root','','Mini_Project')
print("Content-type:text/html\r\n\r\n")

if form.getvalue('email'):
	email = form.getvalue('email')
if form.getvalue('npass'):
	npass = form.getvalue('npass')

cursor=db.cursor();
sql="Update Candidates SET Password='%s' where Email='%s'" % (npass,email)
try:
	cursor.execute(sql)
	db.commit()
	m.send_mail(email)
except:
	db.rollback()
	print("0")
	
db.close()