# Multi-Restaurant Food Order Application

This is a complete, advanced multi-restaurant food ordering application built with **Laravel**. It's designed to be a comprehensive e-commerce solution for a food delivery platform, featuring a multi-layered user system, multi-authentication, and a variety of advanced functionalities.

---

### Features

* **Multi-Layered User System**: Three distinct user roles:
    * **User (Customer)**: Can browse restaurants, place orders, apply coupons, and leave reviews.
    * **Client (Restaurant)**: Manages their own store, products, and incoming orders.
    * **Super Admin**: Manages the entire platform, including user roles, coupons, and payments.
* **Multi-Authentication**: Secure login for different user types using the **Breeze** package.
* **Advanced Features**:
    * **Coupon System**: Admins and restaurant owners can create and apply coupons.
    * **Review & Rating System**: Customers can review and rate restaurants.
    * **Dynamic Discounts**: Restaurants can offer special discount prices on items.
    * **Payment Gateways**: Integration with multiple online payment gateways.
    * **Mailing System**: Automated email notifications for orders and other events.
    * **Favorite Restaurants**: Users can save their favorite restaurants.
    * **Shopping Cart**: An advanced, custom-built shopping cart system without external packages.
    * **Image Uploads**: Both single and multiple image uploads for products and profiles.
    * **PDF Invoice Generation**: Generates professional-looking PDF invoices for orders.
    * **Data Import/Export**: Import and export data from CSV or Excel files.
    * **Custom Pagination**: Tailored pagination for a seamless user experience.

---

### Installation & Setup

1.  **Clone the repository**:
    ```bash
    git clone [https://github.com/MuhammadZulhusni/Multi-Restaurant-Food-Ordering.git](https://github.com/MuhammadZulhusni/Multi-Restaurant-Food-Ordering.git)
    cd Multi-Restaurant-Food-Ordering
    ```

2.  **Install PHP dependencies**:
    ```bash
    composer install
    ```

3.  **Set up the environment**:
    * Copy the `.env.example` file to `.env`:
        ```bash
        cp .env.example .env
        ```
    * Generate a new application key:
        ```bash
        php artisan key:generate
        ```
    * Update your database credentials in the `.env` file.

4.  **Run migrations and seed the database**:
    ```bash
    php artisan migrate --seed
    ```

5.  **Install NPM dependencies and build assets**:
    ```bash
    npm install
    npm run build
    ```

6.  **Run the local development server**:
    ```bash
    php artisan serve
    ```
