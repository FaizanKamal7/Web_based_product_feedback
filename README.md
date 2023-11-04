
---

# Web_based_product_feedback

## Project Overview

This README provides an overview of the Installation of Web_based_product_feedback project.

## Installation

To get started with this Laravel project, follow these steps:

1. Clone the repository to your local machine:

   ```shell
   git clone https://github.com/FaizanKamal7/Web_based_product_feedback.git
   ```

2. Navigate to the project directory:

   ```shell
   cd Web_based_product_feedback
   ```

3. Install Composer dependencies:

   ```shell
   composer install
   ```

4. Copy the `.env.example` file to `.env` and configure your environment variables, such as database settings and email providers for `Comment Notifier`:

   ```shell
    DB_DATABASE=<your_db>
 
    MAIL_MAILER=smtp
    MAIL_HOST=mail.example.com
    MAIL_PORT=587
    MAIL_USERNAME=your_username
    MAIL_PASSWORD=your_password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=noreply@example.com
    MAIL_FROM_NAME="${APP_NAME}   
   ```

5. Generate an application key:

   ```shell
   php artisan key:generate
   ```

6. Migrate the database:

   ```shell
   php artisan migrate
   ```

7. Start the development server:

   ```shell
   php artisan serve
   ```

You can now access the application at `http://localhost:8000` in your web browser.

---
