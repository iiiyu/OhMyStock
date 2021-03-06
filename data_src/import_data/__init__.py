# -*- coding:utf-8 -*-

from flask import Blueprint

import_data_api = Blueprint("import_data", __name__)

from import_data import import_data
