# Extra reasons
Web application based on cohere AI that asks the user for a topic to give reasons about and answers what the cohere generation model suggests.

## **Required setup to run**
In order for the code to run, you need to set some environment variables. I have chosen to have a .htaccess file containing the following information (changing XXXXX by your values):
<br/><br/>
> SetEnv COHERE_API_KEY "BEARER XXXXX"<br/>
> SetEnv MYSQL_DB_HOST "XXXXX"<br/>
> SetEnv MYSQL_DB_NAME "XXXXX"<br/>
> SetEnv MYSQL_DB_USERNAME "XXXXX"<br/>
> SetEnv MYSQL_DB_PASSWORD "XXXXX"<br/>

<br/>
Also you need to have the database set up as mentioned at the "Database" section of this readme.

## **Project architecture**
This is a very simple project and will just use a very simple frontend and backend.

### **Frontend**
As a frontend, I'll be using a simple web page built in plain html, js and css as it will be a simple page that will be calling the backend with the user input and will display the response.

### **Backend**
As a backend, I'll be using a php file that will capture the user input and call the cohere api using curl. 
I've chosen this solution to avoid the cohere API key to be visible in the network tab in chrome as a security measure.
However, as the task to be executed by the backend is just to proxy the request by now, I opted for a single php file instead of creating a more complex backend project.
In addition, to keep a track on what the users are interested on, the "api" stores the search in a mysql database.

### **Database**
As a database to store the user's searches, I have chosen to use a mysql as it's easy to set up and use and fits the needs.
The database has only one table called 'searches' that has the following structure:
| Field | Type | Collation | Null | Default | Extra |
| ------ | ---- | ------------ | ---- | -------------- | ----- |
| id | int(11) | | No | None | AUTO_INCREMENT |
| prompt | varchar(255) | utf8mb4_unicode_ci | No | None | |
| response | text | | No | None | |
| timestamp | timestamp | utf8mb4_unicode_ci | No | current_timestamp() | ON UPDATE CURRENT_TIMESTAMP() |
