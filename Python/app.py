from flask import Flask, json, request
from flask_mysqldb import MySQL
import collections

app = Flask(__name__)


app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'task'

mysql = MySQL(app)

@app.route('/insertUser', methods=['GET', 'POST'])
def insert_user():
    if request.method == "POST":
        user = request.get_json()
        name = user['name']
        gender = user['gender']
        email = user['email']
        cur_user = mysql.connection.cursor()
        cur_user.execute("INSERT INTO users (name, gender, email) VALUES (%s, %s, %s)", (name, gender, email))
        mysql.connection.commit()
        cur_user.close()
        return "Done Insert User"

@app.route('/insertFile', methods=['GET', 'POST'])
def insert_file():
    if request.method == "POST":
        csv = request.get_json()
        csv_file = csv['csv_file']
        file_name = csv['file_name']
        number_of_lines = csv['number_of_lines']
        cur_file = mysql.connection.cursor()
        cur_file.execute("INSERT INTO csv_file (csv_file, file_name, number_of_lines) VALUES (%s, %s, %s)", (csv_file, file_name, number_of_lines))
        mysql.connection.commit()
        cur_file.close()
        return "Insert File Done"

@app.route('/', methods=['GET', 'POST'])
def select():
    if request.method == "GET":
        cur_select = mysql.connection.cursor()
        cur_select.execute("SELECT * FROM csv_file ORDER BY id DESC LIMIT 1")
        mysql.connection.commit()
        result = cur_select.fetchall()
        cur_select.close()
        objects_list = []
        for row in result:
            json_object = collections.OrderedDict()
            json_object['id'] = row[0]
            json_object['file_name'] = row[2]
            json_object['number_of_lines'] = row[3]
            json_object['date'] = row[4]
            objects_list.append(json_object)
        json_result = json.dumps(objects_list)
        with open('student_objects.js', 'w') as json_map:
            json_map.write(json_result)
        return json_result

if __name__ == '__main__':
    app.run()
