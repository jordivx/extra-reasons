# Extra reasons
Web application based on cohere AI that asks the user for a topic to give reasons about and answers what the cohere generation model suggests.

## **Project architecture**
This is a very simple project and will just use a very simple frontend and backend.

### **Frontend**
As a frontend, I'll be using a simple web page built in plain html, js and css as it will be a simple page that will be calling the backend with the user input and will display the response.

### **Backend**
As a backend, I'll be using a php file that will capture the user input and call the cohere api using curl. 
I've chosen this solution to avoid the cohere API key to be visible in the network tab in chrome as a security measure.
However, as the task to be executed by the backend is just to proxy the request by now, I opted for a single php file instead of creating a more complex backend project.