# Excel-BDD-to-MySQL

This PHP script allows importing data from a CSV file to a MySQL database. The CSV file must be in XLSX format and must contain data in the first sheet of the file. The first row will be skipped as it is expected to contain column headers.

## Requirements

This script uses the **PhpSpreadsheet** library to read XLSX files. To use this library, you must have PHP 7.2 or higher installed, along with the php_zip and php_xml extensions.

A MySQL database and a web server that supports PHP are also required.

## Configuration

To use this script, you need to edit the following line in the csv.php file and replace **put_db_name_without_quotation_marks** with the name of the database you want to import the data to:

$this->db = new PDO("mysql:host=localhost;dbname=put_db_name_without_quotation_marks;charset=utf8","root","");

## Usage

To use this script, place the csv.php and index.php files in the root directory of your web server. Then, navigate to index.php in your web browser.

- Click the "Import" button.
- Select an XLSX file that contains the data you want to import.
- The script will import the data into the specified MySQL database.

## Notes

- This script has been tested with XLSX files created with Microsoft Excel and LibreOffice Calc.
- If a cell in the XLSX file is empty and represents a value that should be inserted into the database, a NULL value will be inserted instead.
- The data will be inserted into the magazine table of the specified database. If you want to change this, you need to edit the SQL query in the csv.php file.

** Note**: This file is written in markdown format (.md) and can be viewed using any text editor that supports markdown, or can be rendered to HTML for better viewing.
