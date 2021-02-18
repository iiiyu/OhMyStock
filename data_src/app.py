# coding:utf-8

from flask import Flask
from alive import alive_api

app = Flask(__name__)

app.register_blueprint(alive_api, url_prefix='/api')

if __name__ == '__main__':
    app.run(host='0.0.0.0',port=9000,debug=True)
