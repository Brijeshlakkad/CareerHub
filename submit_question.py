#!/usr/bin/python
import cgi, cgitb
import sys
import os
import pymysql
import config

def add_question(testid,que,a1,a2,a3,a4,ans):
	conn,cursor=config.connect_to_database()
	testid=int(testid)
	sql="Insert into Questions(Question,A1,A2,A3,A4,TestID,Ans) values('%s','%s','%s','%s','%s','%s','%s')"%(que,a1,a2,a3,a4,testid,ans)
	try:
		cursor.execute(sql)
		conn.commit()
		testid=int(testid)
		sql2="Select Total_num from Tests Where ID='%s'"%(testid)
		try:
			cursor.execute(sql2)
			results = cursor.fetchone()
			num=results[0]
			n=int(num)
			n+=1
			sql3="Update Tests SET Total_num='%s' where ID='%s'"%(n,testid)
			try:
				cursor.execute(sql3)
				conn.commit()
				print("1")
			except:
				conn.rollback()
				print("-1")
		except:
			conn.rollback()
			print("-1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def update_question(queid,que,a1,a2,a3,a4,ans):
	conn,cursor=config.connect_to_database()
	sql="Update Questions SET Question='%s',A1='%s',A2='%s',A3='%s',A4='%s',Ans='%s' where ID='%s'"%(que,a1,a2,a3,a4,ans,queid)
	try:
		cursor.execute(sql)
		conn.commit()
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()


def show_questions(testid):
	conn,cursor=config.connect_to_database()
	sql="Select ID,Time,Question FROM Questions where TestID='%s'"%(testid)
	try:
		cursor.execute(sql)
		results = cursor.fetchall()
		for row in results:
			divid=row[0]
			time=row[1]
			datetime=time.strftime('%H : %M')
			que=row[2]
			print("""<div id="%s" class='style_prevu_kit que_div' style="padding:40px;"><div class="row"><h2>%s</h2><span class="pull-right"><form action="edit_question.php" method="post" ><input type="hidden" name="que_id" value="%s" /><button class="btn btn-sm btn-primary" type="submit" >Edit <span class="glyphicon glyphicon-pencil"></span></button></form></span><span class="pull-right"><button class="btn btn-sm btn-danger" onclick="remove_que(%s,%s)" >Delete <span class="glyphicon glyphicon-trash"></span></button></span></div><div class="row"><div class="col-md-offset-5 col-md-5 col-md-offset-2"> <span class="glyphicon glyphicon-time"></span> Posted on %s</div></div></div><hr/><hr/>"""%(divid,que,divid,divid,testid,time))
	except:
		conn.rollback()
		print("-1")
	conn.close()

def remove_questions_of_test(testid):
	conn,cursor=config.connect_to_database()
	sql="Delete from Questions where TestID='%s'"%(testid)
	try:
		cursor.execute(sql)
		conn.commit()
		print("1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def remove_question(queid,testid):
	conn,cursor=config.connect_to_database()
	sql="Delete from Questions where ID='%s'"%(queid)
	try:
		cursor.execute(sql)
		sql2="Select Total_num from Tests where ID='%s'"%(testid)
		try:
			cursor.execute(sql2)
			results = cursor.fetchone()
			num=results[0]
			n=int(num)
			n-=1
			sql3="Update Tests SET Total_num='%s' where ID='%s'"%(n,testid)
			try:
				cursor.execute(sql3)
				conn.commit()
				print("1")
			except:
				conn.rollback()
				print("-1")
		except:
			conn.rollback()
			print("-1")
	except:
		conn.rollback()
		print("-1")
	conn.close()

def total_que_num(testid):
	conn,cursor=config.connect_to_database()
	sql="Select Total_num From Tests where ID='%s'"%(testid)
	try:
		cursor.execute(sql)
		results = cursor.fetchone()
		num=results[0]
		print(num)
	except:
		conn.rollback()
		print("-1")
	conn.close()
