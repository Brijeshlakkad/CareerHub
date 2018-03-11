#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import submit_test
import submit_question
print("Content-type:text/html\r\n\r\n")

form = cgi.FieldStorage()	
if form.getvalue('add_title'):
	if form.getvalue('parid') and form.getvalue('course') and form.getvalue('subjects'):
		title = form.getvalue('add_title')
		parid = form.getvalue('parid')
		course = form.getvalue('course')
		subjects = form.getvalue('subjects')
		submit_test.add_test(title,parid,course,subjects)

if form.getvalue('add_que'):
	if form.getvalue('testid') and form.getvalue('mcq1') and form.getvalue('mcq2') and form.getvalue('mcq3') and form.getvalue('mcq4') and form.getvalue('ans'):
		testid = form.getvalue('testid')
		add_que = form.getvalue('add_que')
		mcq1 = form.getvalue('mcq1')
		mcq2 = form.getvalue('mcq2')
		mcq3 = form.getvalue('mcq3')
		mcq4 = form.getvalue('mcq4')
		ans = form.getvalue('ans')
		submit_question.add_question(testid,add_que,mcq1,mcq2,mcq3,mcq4,ans)
		
if form.getvalue('tests_reload'):
	postedby=form.getvalue('tests_reload')
	submit_test.show_tests(postedby)
	
if form.getvalue('questions_reload'):
	testid=form.getvalue('questions_reload')
	submit_question.show_questions(testid)

if form.getvalue('update_que'):
	if form.getvalue('mcq1') and form.getvalue('mcq2') and form.getvalue('mcq3') and form.getvalue('mcq4') and form.getvalue('ans'):
		queid = form.getvalue('queid')
		update_que = form.getvalue('update_que')
		mcq1 = form.getvalue('mcq1')
		mcq2 = form.getvalue('mcq2')
		mcq3 = form.getvalue('mcq3')
		mcq4 = form.getvalue('mcq4')
		ans = form.getvalue('ans')
		submit_question.update_question(queid,update_que,mcq1,mcq2,mcq3,mcq4,ans)