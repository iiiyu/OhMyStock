# -*- coding:utf-8 -*-

from flask import Blueprint

alive_api = Blueprint("alive", __name__)

from alive import alive
