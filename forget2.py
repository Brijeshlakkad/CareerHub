#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import sys
import os
import re
from smtplib import SMTP_SSL as SMTP 
from email.mime.text import MIMEText
import cgi, cgitb 
form = cgi.FieldStorage() 
 
print("Content-type:text/html\r\n\r\n")

if (form.getvalue('forget_email')):
	if form.getvalue('otp'):
		forget_email = form.getvalue('forget_email')
		otp = form.getvalue('otp')
		SMTPserver = 'smtp.gmail.com'
		sender =     'brijeshlakkad22@gmail.com'
		destination = forget_email
		USERNAME = "brijeshlakkad22@gmail.com"
		PASSWORD = "214567267bB"

		text_subtype = 'html'
		content="""\
		Forget Password OTP is : %s

		"""% (otp)
		subject="%s"% otp

		try:
			msg = MIMEText(content, text_subtype)
			msg['Subject']= subject
			msg['From']   = sender 
			conn = SMTP(SMTPserver)

			conn.set_debuglevel(False)
			conn.login(USERNAME, PASSWORD)
			try:
				conn.sendmail(sender, destination, msg.as_string())
				print("1")
			finally:
				conn.quit()
		except Exception:
			print("0")
else:
	print("0")
	