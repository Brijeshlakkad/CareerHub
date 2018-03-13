#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import submit_test
import submit_question
import security
print("Content-type:text/html\r\n\r\n")
cgitb.enable(display=0, logdir="/path/to/logdir")
form = cgi.FieldStorage()	
if form.getvalue('add_title'):
	if form.getvalue('parid') and form.getvalue('course') and form.getvalue('subjects'):
		title = form.getvalue('add_title')
		parid = form.getvalue('parid')
		course = form.getvalue('course')
		subjects = form.getvalue('subjects')
		title=security.protect_data(title)
		parid=security.protect_data(parid)
		course=security.protect_data(course)
		subjects=security.protect_data(subjects)
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
		testid=security.protect_data(testid)
		add_que=security.protect_data(add_que)
		mcq1=security.protect_data(mcq1)
		mcq2=security.protect_data(mcq2)
		mcq3=security.protect_data(mcq3)
		mcq4=security.protect_data(mcq4)
		ans=security.protect_data(ans)
		submit_question.add_question(testid,add_que,mcq1,mcq2,mcq3,mcq4,ans)
		
if form.getvalue('tests_reload'):
	postedby=form.getvalue('tests_reload')
	postedby=security.protect_data(postedby)
	submit_test.show_tests(postedby)
	
if form.getvalue('questions_reload'):
	testid=form.getvalue('questions_reload')
	testid=security.protect_data(testid)
	submit_question.show_questions(testid)

if form.getvalue('update_que'):
	if form.getvalue('mcq1') and form.getvalue('mcq2') and form.getvalue('mcq3') and form.getvalue('mcq4') and form.getvalue('ans'):
		queid = form.getvalue('que_id')
		update_que = form.getvalue('update_que')
		mcq1 = form.getvalue('mcq1')
		mcq2 = form.getvalue('mcq2')
		mcq3 = form.getvalue('mcq3')
		mcq4 = form.getvalue('mcq4')
		ans = form.getvalue('ans')
		queid=security.protect_data(queid)
		update_que=security.protect_data(update_que)
		mcq1=security.protect_data(mcq1)
		mcq2=security.protect_data(mcq2)
		mcq3=security.protect_data(mcq3)
		mcq4=security.protect_data(mcq4)
		ans=security.protect_data(ans)
		submit_question.update_question(queid,update_que,mcq1,mcq2,mcq3,mcq4,ans)

if form.getvalue('update_test'):
	if form.getvalue('test_id') and form.getvalue('course') and form.getvalue('subjects'):
		title = form.getvalue('update_test')
		testid = form.getvalue('test_id')
		course = form.getvalue('course')
		subjects = form.getvalue('subjects')
		title=security.protect_data(title)
		testid=security.protect_data(testid)
		course=security.protect_data(course)
		subjects=security.protect_data(subjects)
		submit_test.update_test(testid,title,course,subjects)

if form.getvalue('remove_test'):
	testid = form.getvalue('remove_test')
	testid=security.protect_data(testid)
	xx=submit_test.remove_test(testid)
	if xx=="1":
		submit_question.remove_questions_of_test(testid)
	else:
		print("-1")
	
if form.getvalue('remove_que') and form.getvalue('test_id'):
	queid = form.getvalue('remove_que')
	testid = form.getvalue('test_id')
	testid=security.protect_data(testid)
	queid=security.protect_data(queid)
	submit_question.remove_question(queid,testid)

if form.getvalue('total_test_num'):
	postedby = form.getvalue('total_test_num')
	postedby=security.protect_data(postedby)
	submit_test.total_test_num(postedby)

if form.getvalue('total_que_num'):
	testid = form.getvalue('total_que_num')
	testid=security.protect_data(testid)
	submit_question.total_que_num(testid)