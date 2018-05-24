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
	def send_mail(self,email_ad,mob,name):
		SMTPserver = 'smtp.gmail.com'
		sender =     ''
		destination = email_ad
		text_subtype = 'html'
		content="""\
		<b>Welcome to the CareerHub</b> <br> \
		dear %s ,<br> \
			You have registered your email address successfully <br> \
			Your Mobile number %s <br> \
		""" % (name,mob)
		subject="Sign up successfully"
		try:
			msg = MIMEText(content, text_subtype)
			msg['Subject']= subject
			msg['From']   = sender 
			conn = SMTP(SMTPserver)
			conn.set_debuglevel(False)
			conn.login(self.USERNAME, self.PASSWORD)
			try:
				conn.sendmail(sender, destination, msg.as_string())
			finally:
				conn.quit()
		except Exception:
			print("0")

m=Mail()
form = cgi.FieldStorage()
db=pymysql.connect("localhost",'root','','Mini_Project')
print("Content-type:text/html\r\n\r\n")

if form.getvalue('s_email'):
	email = form.getvalue('s_email')
if form.getvalue('s_user'):
	user = form.getvalue('s_user')
if form.getvalue('s_bemail'):
	bemail = form.getvalue('s_bemail')
if form.getvalue('s_buser'):
	buser = form.getvalue('s_buser')
if form.getvalue('s_mobile'):
	phone = form.getvalue('s_mobile')
if form.getvalue('s_password'):
	password = form.getvalue('s_password')
cursor=db.cursor();
sql="INSERT INTO Institutes (Name,Email,Bname,Bemail,Phone,Password) values('%s','%s','%s','%s','%s','%s')" % (user,email,buser,bemail,phone,password)
try:
	cursor.execute(sql)
	db.commit()
	m.send_mail(email,phone,user)
	print("1")
except:
	db.rollback()
	print("0")
	
db.close()