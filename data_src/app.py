# coding:utf-8

import os
from flask import Flask, jsonify
from alive import alive_api
from import_yf_data import import_yf_data_api

app = Flask(__name__)
# app.config["MONGO_URI"] = "mongodb://mongo:27017/stock_db"
print('mongodb://' + os.environ['MONGODB_USERNAME'] + ':' + os.environ['MONGODB_PASSWORD'] + '@' + os.environ['MONGODB_HOSTNAME'] + ':27017/' + os.environ['MONGODB_DATABASE']
)
app.config["MONGO_URI"] = 'mongodb://' + os.environ['MONGODB_USERNAME'] + ':' + os.environ['MONGODB_PASSWORD'] + '@' + os.environ['MONGODB_HOSTNAME'] + ':27017/' + os.environ['MONGODB_DATABASE']

app.register_blueprint(alive_api, url_prefix='/api')
app.register_blueprint(import_yf_data_api, url_prefix='/api')

@app.errorhandler(404)
def resource_not_found(e):
    return jsonify(error=str(e)), 404

if __name__ == '__main__':
    app.run(host='0.0.0.0',port=9000,debug=True)
