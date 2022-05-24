import pymysql.cursors
import os
import json

# Connect to the database
def deobfuscate(passw):
  stringResult = ""
  flag = 1
  cList = list(passw)
  for index in range(len(cList)):
    elem = ord(cList[index]) - flag
    stringResult += chr(elem)
    flag *= -1
  return stringResult

fObj = open('config.json',)
data = json.load(fObj)
fObj.close()

connection = pymysql.connect(host='127.0.0.1',
                             user=data['userNameMasterDB'],
                             password=data['passwordMasterDB'],
                             database='budget_app',
                             cursorclass=pymysql.cursors.DictCursor)

def executeQuery(query, table):
  with connection.cursor() as cursor:
    sql = query
    cursor.execute(f"SHOW TABLES LIKE '{table}';")
    result = cursor.fetchone()
    if result != None:
      print(f"Warning Table '{table}' already exists!")
      return
    cursor.execute(sql)
    result = cursor.fetchone()
    print(f"Table '{table}' has been created succesfully!")

def dropEverything():
  with connection.cursor() as cursor:
    sql = f"SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA = 'budget_app'"
    cursor.execute(sql)
    for table in cursor.fetchall():
      sql = f"DROP TABLE {table['TABLE_NAME']}"
      cursor.execute(sql)
    connection.commit()
    print("Tables dropped!")

dropEverything()
executeQuery("""CREATE TABLE users (
              id INT(7) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              username varchar(100) not null unique,
              fullname varchar(100) not null unique,
              password varchar(155) not null,
              isAdmin varchar(1),
              created_at datetime default current_TIMESTAMP,
              date_salary TIMESTAMP
              )
  """, "users")

executeQuery("""CREATE TABLE pusculite (
              id INT(7) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              denumire varchar(200),
              procentaj INT(4),
              status varchar(100),
              id_user int(7)
              )
  """, "pusculite")

executeQuery("""CREATE TABLE detalii (
              id INT(7) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              id_pusculite INT(7),
              id_users INT(7),
              suma INT(7),
              tip varchar(1),
              detalii varchar(128),
              expected_date TIMESTAMP
              )
  """, "detalii")