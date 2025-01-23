# React Inertia Laravel Tailwind (RILT) with Mantine UI Starter Project

## About The Project

This project is a comprehensive starter template designed to simplify and accelerate the development of modern web
applications. It integrates key technologies like React, Inertia.js, Laravel, and Tailwind CSS, providing a clean and
organized authentication pipeline setup out of the box. Whether you're starting a new project or looking for a flexible,
scalable auth system, this boilerplate provides a solid foundation for rapid development and customization.

### Key Features:

- Easy authentication pipeline using **Laravel Fortify**.
- Clean, organized architecture with actions-based controllers for better maintainability.
- Ready-to-go auth routes and views with **Inertia.js** and **React** for a seamless SPA experience.
- **Tailwind CSS** for responsive, customizable UI design.
- Pre-configured **Mantine UI** for polished, user-friendly interfaces.
- Scalable architecture for adding new features and extending functionality.

## Tech Stack:

- **React**: A powerful JavaScript library for building dynamic user interfaces with a component-based architecture.
- **Inertia.js**: A framework-agnostic tool that allows you to build modern, single-page apps (SPAs) using server-side
  routing and controllers.
- **Laravel**: A robust PHP framework for building web applications with an elegant syntax.
- **Laravel Fortify**: A package for building the authentication layer in Laravel applications.
- **Tailwind CSS**: A utility-first CSS framework for creating responsive and customizable designs.
- **Mantine UI**: A React component library for building beautiful user interfaces with a rich set of pre-built
  components.

## Installation

To get started with the project, follow these steps:

1. Clone the repository:
   ```bash
   git clone https://github.com/IsaacHatilima/rilt-mantine-starter.git
   cd rilt-mantine-starter

2. Install dependencies
    ```bash
    composer install
    npm install

3. Configure your ```.env``` file with the necessary credentials.
4. Run migrations and seed the database:
    ```bash
   php artisan migrate --seed
5. Start the development server:

    ```bash
   php artisan serve
   npm run dev

Visit http://localhost:8000 to see the app in action.

## Architecture Decisions

**Actions-based Controllers:** The project moves business logic into action classes to keep controllers focused on
request
handling. This leads to a cleaner, more maintainable structure.

**Inertia.js + React:** Combining Inertia.js with React allows for a seamless SPA experience with minimal client-side
routing and more intuitive server-side controller integration.

**Tailwind + Mantine UI:** Tailwind provides utility-first styling, while Mantine UI offers rich, pre-designed
components
that enhance the user experience out of the box. Together, they allow for rapid UI development.
