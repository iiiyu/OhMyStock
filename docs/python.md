## First

Create python environment in Docker.

[Try Out Development Containers: Python](https://github.com/microsoft/vscode-remote-try-python)

[Python/Flask Tutorial Sample for VS Code](https://github.com/microsoft/python-sample-vscode-flask-tutorial/tree/tutorial)

[How To Set Up Flask with MongoDB and Docker](https://www.digitalocean.com/community/tutorials/how-to-set-up-flask-with-mongodb-and-docker)

```
docker ps

docker exec -it {mongodb_container_id} bash
mongo -u root -p example


```

```
show dbs;
use stock_db;
db.createUser({user: 'test_mongo_user', pwd: 'test_mongodb_user_password', roles: [{role: 'readWrite', db: 'stock_db'}]});
```
