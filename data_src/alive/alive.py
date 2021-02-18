from alive import alive_api

@alive_api.route("/alive")
def alive():
    return {
        'Code': 0,
        'Message': 'The Server is alive!'
    }
