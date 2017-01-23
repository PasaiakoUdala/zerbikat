#!/usr/bin/python

con = MySQLdb.connect(host='SERVER', user='DBUSER', passwd='DBPASSWD', db='DATABASE')
cur = con.cursor()

cur.execute("SHOW TABLES")
data = "SET FOREIGN_KEY_CHECKS = 0; \n"
tables = []
for table in cur.fetchall():
    tables.append(table[0])

for table in tables:
    if table != "fos_user" and table != 'udala':

        # Begiratu ea udala_id eremua existitzen den
        cur.execute("SHOW columns from `" + str(table) + "` where field='udala_id' \n")
        badu = cur.rowcount

        if badu == 1:
            data += "DELETE FROM `" + str(table) + "` WHERE udala_id=64; \n"
            cur.execute("SELECT * FROM `" + str(table) + "` WHERE udala_id=64;")
        else:
            data += "DELETE FROM `" + str(table) + "`; \n"
            cur.execute("SELECT * FROM `" + str(table) + "`;")

        for row in cur.fetchall():
            data += "INSERT INTO `" + str(table) + "` VALUES("
            first = True
            for field in row:
                if not first:
                    data += ', '
                data += '"' + str(field).replace("\"", "\'") + '"'
                first = False


            data += ");\n"
        data += "\n\n"

data += "SET FOREIGN_KEY_CHECKS = 1; \n"
FILE = open("export_zerbikat.sql","w")
FILE.writelines(data)
FILE.close()
