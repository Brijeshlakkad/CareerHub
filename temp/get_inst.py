def get_institute(conn,cursor,instid):
	sql="select * from institutes where ID='%s'"%(instid)
	try:
		cursor.execute(sql)
		result=cursor.fetchone()
		return result['Bname']
	except:
		conn.rollback()