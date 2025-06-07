/* style.css */

body {
  font-family: Arial, sans-serif;
  background-color: #f0f8ff;  /* light blue background */
  color: #003366;             /* dark blue text */
  margin: 0;
  padding: 20px;
}

h1, h2 {
  color: #004080;  /* deep blue for headings */
}

a {
  color: #004080;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

nav {
  background-color: #007acc; /* medium blue nav background */
  padding: 10px 20px;
  margin-bottom: 30px;
}

nav a {
  color: white;
  margin-right: 20px;
  font-weight: bold;
}

nav a:hover {
  color: #cce6ff;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 40px;
  background: white;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

th, td {
  padding: 10px;
  border: 1px solid #b3d9ff;
  text-align: left;
}

th {
  background-color: #cce6ff;
}

button, input[type="submit"] {
  background-color: #007acc;
  color: white;
  border: none;
  padding: 10px 18px;
  cursor: pointer;
  font-size: 16px;
  border-radius: 4px;
  margin-top: 10px;
}

button:hover, input[type="submit"]:hover {
  background-color: #005f99;
}

form {
  background: white;
  padding: 20px;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
  max-width: 500px;
  margin-bottom: 40px;
  border-radius: 6px;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="tel"],
select,
textarea {
  width: 100%;
  padding: 8px 10px;
  margin: 8px 0 15px;
  border: 1px solid #b3d9ff;
  border-radius: 4px;
  box-sizing: border-box;
}

img {
  border-radius: 4px;
  max-width: 100%;
}

.error {
  color: red;
  font-weight: bold;
}

.success {
  color: green;
  font-weight: bold;
}
