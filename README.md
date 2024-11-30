<a id="readme-top"></a>

<!-- HEADER -->
<div align="center">
  <h3 align="center">Database website</h1>
  <p align="center">
    Website displaying data about nobel prize winners extracted from database.
  </p>
</div>

<!-- ABOUT THE PROJECT -->
## About The Project

This web application provides an overview of Nobel Prize winners, showcasing detailed information about laureates in an easy-to-navigate interface.
It displays a list of Nobel Prize winners, including their name, country of representation, the year they received the award, and the category for which they won.
The application supports both a public and a private section where users can log in to access additional features.

## Key Features
### Public Section:
A table displaying Nobel Prize winners with the following columns:

**Name:** The laureate's first name.

**Surname:** The laureate's surname.

**Year:** The year the Nobel Prize was awarded.

**Category:** The category of the award (e.g., Physics, Chemistry, Literature, Peace).

**Table funcionalities:**

**Filters:** Drop-down lists that allow users to filter the data based on the year and category. When a filter is applied, the respective column (year or category) is hidden.

**Sorting:** Columns such as "Name", "Year", and "Category" can be clicked to sort the table data in ascending or descending order.

Pagination: The table supports pagination, with 10 or 20 records per page, and allows users to view all records at once using the DataTables library.

Detailed View: Clicking on a laureate's name opens a detailed page with more information about the individual, including all relevant data.

### Private Section (requires login):
Users can log in via either a custom registration form (using email and password) or by using their Google account.
Authentication and Two-Factor Authentication (2FA) are handled using Firebase.

The custom registration includes email validation and password encryption (using secure hashing algorithms),
and Firebase manages the authentication flow..

Once logged in, the user can:

**Add new laureates:** Input new laureates into the database along with their full details.

**Edit laureates:** information: Modify existing entries in the database with pre-filled forms based on the selected laureate.

**Delete laureates:** Remove entries from the database along with all related information.

Data validation is performed both on the front-end and back-end to ensure the integrity of the records.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- TOOLS -->
### Built With

* [![PHP][PHP.com]][PHP-url]
* [![HTML][HTML.com]][HTML-url]
* [![CSS][CSS.com]][CSS-url]
* [![JavaScript][JS.com]][JS-url]
* [![Firebase][Firebase.com]][Firebase-url]
* [![SQL][SQL.com]][SQL-url]
* [![DataTables][DataTables.com]][DataTables-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- LINKS -->
[HTML.com]: https://img.shields.io/badge/HTML-E34F26?style=for-the-badge&logo=html5&logoColor=white
[HTML-url]: https://developer.mozilla.org/en-US/docs/Web/HTML
[CSS.com]: https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white
[CSS-url]: https://developer.mozilla.org/en-US/docs/Web/CSS
[JS.com]: https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black
[JS-url]: https://developer.mozilla.org/en-US/docs/Web/JavaScript
[PHP.com]: https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white
[PHP-url]: https://www.php.net/
[SQL.com]: https://img.shields.io/badge/SQL-006B3F?style=for-the-badge&logo=sql&logoColor=white
[SQL-url]: https://www.mysql.com/
[DataTables.com]: https://img.shields.io/badge/DataTables-1A82FF?style=for-the-badge&logo=datatables&logoColor=white
[DataTables-url]: https://datatables.net/
[Firebase.com]: https://img.shields.io/badge/Firebase-FFCA28?style=for-the-badge&logo=firebase&logoColor=black
[Firebase-url]: https://firebase.google.com/

### Created
2024
