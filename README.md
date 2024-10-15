# Versão em Português 


# VacciLife

**VacciLife** is a vaccine management system designed to facilitate the registration and management of vaccination information. The project provides users with an easy and effective way to manage their vaccination data, allowing quick access to relevant information, scheduling vaccines, and receiving automated reminders.

## Table of Contents

- [About the Project](#about-the-project)
- [Key Features](#key-features)
- [Technologies Used](#technologies-used)
- [Installation and Setup](#installation-and-setup)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## About the Project

VacciLife was created to improve the management of vaccination records in communities with high functional literacy rates. The system offers an intuitive interface that helps users register and track their vaccinations efficiently.

## Key Features

- **User Registration and Management**: Users can create accounts, log in, and update their personal information.
- **Vaccine Scheduling**: Allows users to schedule their vaccinations according to their needs.
- **Vaccine Information Lookup**: Access to detailed information about various available vaccines.
- **Email Notifications**: Automated reminders for scheduled vaccinations.
- **Responsive Interface**: Optimized design to work on both mobile devices and desktops.

## Technologies Used

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **CSS Framework**: Bootstrap
- **Email Sending**: PHPMailer

## Installation and Configuration

### Prerequisites

- Local server (ex.: XAMPP ou WAMP)
- PHP 7.0 or higher
- MySQL

### Installation Steps

1. **Clone the repository or download the Zip [here](https://codeload.github.com/psilvagg/VacciLife/zip/refs/heads/main?token=AZI7DN33BRMFMT2WIKIKLY3HB2TGO)**

   ```bash
   git clone https://github.com/psilvagg/VacciLife.git

   ```

2. **Navigate to the project directory:**

   ```bash
   cd VacciLife

   ```

3. **Set up the database:**

   > Execute the SQL script located in `sql/Vacina.sql`

   ```bash
    cd VacciLife/sql/Vacina.sql

   ```

4. **Server Configuration**
   > Place the contents of the cloned directory in the `htdocs` folder of XAMPP or at the root of your local server.

## Note

- Configure PHPMailer as needed.
