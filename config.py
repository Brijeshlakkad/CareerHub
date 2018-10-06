#!/usr/bin/python
import cgi, cgitb
import sys
import os
import pymysql
import base64
def connect_to_database():
	conn=pymysql.connect("localhost",'root','root','mini_project',8889)
	cursor = conn.cursor()
	return conn,cursor
