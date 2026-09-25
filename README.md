# Event Registration System

A simple PHP-based event registration application for managing participant details such as name, email, phone number, and event name.

## Features

- Add new event registrations
- View all registrations in a table
- Search registrations by name, email, or event
- Edit existing records
- Delete records
- Data stored locally in a JSON file

## Project Structure

- `index.php` – main UI for registration and listing
- `save.php` – handles adding new registrations
- `fetch.php` – reads all saved registrations
- `update.php` – updates an existing registration
- `delete.php` – removes a registration
- `data.json` – local storage file for registered users
- `script.js` – frontend behavior and AJAX calls
- `style.css` – styling for the app

## Requirements

- PHP 7.4 or later
- A local web server such as XAMPP, WAMP, or the built-in PHP server

## Run Locally

1. Open the project folder in your local PHP server environment.
2. Start Apache/PHP.
3. Open the project in a browser:
   - `http://localhost/event-registration/`

If you are running from the project directory directly with PHP, you can also use:

```bash
php -S localhost:8000
```

Then visit:

```text
http://localhost:8000
```

## Notes

This project stores records in `data.json` and is intended as a lightweight demo or learning project for PHP and front-end form handling.
