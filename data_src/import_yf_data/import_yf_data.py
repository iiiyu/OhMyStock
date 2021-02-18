from import_yf_data import import_yf_data_api
from flask import current_app
from flask_pymongo import PyMongo
import datetime


@import_yf_data_api.route("/test")
def test():
    mongo = PyMongo(current_app)
    collection = mongo.db.test_collection
    new_posts = [{"author": "Mike",
              "text": "Another post!",
              "tags": ["bulk", "insert"],
             "date": datetime.datetime(2009, 11, 12, 11, 14)},
             {"author": "Eliot",
              "title": "MongoDB is fun",
              "text": "and pretty easy too!",
             "date": datetime.datetime(2009, 11, 10, 10, 45)}]

    collection.insert(new_posts)
    return {
        'Code': 0,
        'Message': "test"
    }
