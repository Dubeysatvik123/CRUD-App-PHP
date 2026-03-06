# PHP CRUD Application

A simple web application demonstrating Create, Read, Update, and Delete (CRUD) operations using PHP and MySQL. This project features a responsive design with Bootstrap 5 and includes basic form validation.

## Features

- **Create:** Add new users with name, gender, email, mobile number, and address.
- **Read:** View a list of all users in a responsive 
- **Update:** Edit user information.
- **Delete:** Remove a user from the database.
- **Validation:** Basic validation for form inputs.

  

## Technologies Used

- PHP
- MySQL
- JavaScript
- Bootstrap 5
- Font Awesome


### Installation

- **Clone the repository:**

   ```bash
   git clone https://github.com/yourusername/php-crud-application.git
   cd php-crud-application
   ```

- **Import the database:**

  Import the **`database.sql`** file into your MySQL database.


- **Configure the database connection:**
  
  Update the **`connect.php`** file with your database credentials:

  ```
  <?php
  $host = "localhost";
  $username = "root";
  $password = ""; // Update if you have a password set
  $database = "crud";
  
  $conn = mysqli_connect($host, $username, $password, $database);
  
  if (!$conn) {
      die("Error in connection" . mysqli_connect_error());
  }
  ?>
  ```

- **Run the application:**
  Start your web server and navigate to the project directory in your browser. For example, if you are using Apache, you       might go to **http://localhost/php-crud-application.**



## Usage

- Click on the "**New users**" button to open a modal and add a new user.
- Use the **edit** and **delete** icons to update or remove users.
- **Success** and **error** messages will be displayed based on the operation performed.

## Screenshots

  Home page
  
  <img width="959" alt="Screenshot 2024-07-24 211803" src="https://github.com/user-attachments/assets/f0600ad2-d5c4-4c58-af03-e69f3f65cb3f">


  New user
  
  <img width="959" alt="Screenshot 2024-07-24 204136" src="https://github.com/user-attachments/assets/605eb930-0494-4eea-b7bc-9e0b200e5dc1">


  Insert Message
  
  <img width="959" alt="Screenshot 2024-07-24 204214" src="https://github.com/user-attachments/assets/ecadb624-220a-454d-9126-4e949030b365">


  Update
  
  <img width="959" alt="Screenshot 2024-07-24 204308" src="https://github.com/user-attachments/assets/550ac174-cf3a-4bf7-a396-141d3f11e8b9">


  Delete
  
  <img width="959" alt="Screenshot 2024-07-24 204234" src="https://github.com/user-attachments/assets/487b098e-a02f-47b0-b132-fbd2cbe99aa9">


  



