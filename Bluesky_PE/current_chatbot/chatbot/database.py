import mysql.connector 
import string
import random

def connect(): 
  conn = mysql.connector.connect(
  host='localhost',
  database='chatbot',
  user='webuser',
  password='Lab2020')
  return conn

def insert_chat(Random_num, Awnser_Responce, text):
  conn = connect()
  cursor = conn.cursor()
	#get last sequence
  query = "SELECT max(Sequence) FROM chat WHERE Random_num = %s"
  cursor.execute(query,(Random_num,))
  try:#if no sequence sequence will be 1
    Sequence = cursor.fetchall()
    for i in Sequence:
      Sequence = i[0]
    Sequence = Sequence + 1    
  except :
    Sequence = 1

  #puts data in database 
  query =  ("INSERT INTO chat( Random_num, Awnser_Responce, text, Sequence)" \
  "VALUES (%s,%s,%s,%s)")
  args = (Random_num, Awnser_Responce, text, Sequence)

  cursor.execute(query, args)
  conn.commit()
  cursor.close()
  conn.close()

def reloaded_page(Random_num):
  conn = connect()
  cursor = conn.cursor()
  query = ("SELECT Awnser_Responce ,Sequence ,text FROM chat WHERE Random_num = %s")
  cursor.execute(query,(Random_num,))
  
  Sequence = cursor.fetchall()
  cursor.close()
  conn.close()
  return Sequence

def random_id():
  conn = connect()
  cursor = conn.cursor()
  length=5
  while 1:
    randomstr = ''.join(random.choices(string.ascii_letters+string.digits,k=length))
    query = "SELECT Random_nummer FROM chatbot WHERE Random_nummer = %s"
    cursor.execute(query,(randomstr,))
    if cursor.fetchall() != -1:
      break
  print (randomstr)
  query =  ("INSERT INTO chatbot( Random_nummer)" \
  "VALUES (%s)")

  cursor.execute(query, (randomstr,))
  conn.commit()
  cursor.close()
  conn.close()
  return randomstr

def AI(Random_num):
  conn = connect()
  cursor = conn.cursor()
  query = "SELECT AI_ON_OFF FROM chatbot WHERE Random_nummer = %s"
  cursor.execute(query,(Random_num,))
  ON_OFF = cursor.fetchall() 
  for i in ON_OFF:
    ON_OFF = i[0]
  print(ON_OFF)
  cursor.close()
  conn.close()
  if ON_OFF == "ON":
    return True
  else:
    return False

     	