
# Project Name: Dynamic Tree and Nested Cms

## Table of Contents
- [Project Setup](#project-setup)
- [Running the Project](#running-the-project)
- [Running Tests](#running-tests)
- [Assumptions](#assumptions)
- [Solution Overview](#solution-overview)
- [File Structure](#file-structure)

---

## Project Setup

### Prerequisites

Make sure you have the following software installed:

- **PHP 8.x** or higher
- **Laravel 8.x** or higher (used Laravel 11)
- **Node.js** (for Vue.js)
- **Composer** (for managing PHP dependencies)

### Installation

1. Clone the repository to your local machine:

    ```bash
    git clone https://github.com/monikapanchal11/new-cms.git
    cd new-cms 
    ```

2. Install PHP dependencies using Composer:

    ```bash
    composer install
    ```

3. Install frontend dependencies using npm or yarn:

    ```bash
    npm install
    ```

4. Set up your `.env` file:

    ```bash
    cp .env.example .env
    ```

    Then, update the `.env` file with your database name and other configurations.

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Run migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```

7. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

8. Start the Npm dev/vite:

    ```bash
    npm run dev
    ```

    The application will be available at `http://localhost:8000`.

---

# Project Overview

## Assumptions

1. **Tree Data Structure**: The page data is retrieved from an local JSON data from back end controller method in a nested format. Each page may contain a list of child pages (`children`).
  
2. **Slug Structure**: Slugs are unique identifiers for each page. They are used in the API URL as a path, which can include nested values (e.g., `page1/page2/page3`).
  
3. **Vue Router**: used Vue Router for page navigation. 

4. **Dynamic Page Rendering**: Pages and their subpages are dynamically rendered by fetching data from the backend. A recursive component structure is used to display the nested tree.

## Solution Overview

### Dynamic Tree and Nested Complexity

This solution enables the dynamic rendering of a tree structure with an arbitrary depth of nesting. Each page can have child pages, which in turn can have their own subpages, all of which are rendered recursively using Vue components.

1. **Recursive Tree Rendering**: The nested structure is rendered using a recursive Vue component (`TreeView.vue`). Each page node can have children, and if a page has children, the component calls itself to render them in a nested fashion.

   Example:
   ```
   Page1
     └── Page2
         ├── Page1
         └── Page3
             ├── Page4
             └── Page5
   ```

2. **Dynamic Routing**: The page slugs are used to construct the URL paths for each page. When navigating, the slug is parsed from the URL to fetch the correct page data from the API.

3. **UI Components**: The UI features each page title and it's slug. Edit and delete buttons are available next to each title for easy interaction.

4. **Error Handling**: If a page is not found (e.g., due to an invalid slug or API error), the UI displays a clear error message stating "Page not found."
```

---

## File Structure

Here is a brief overview of the important files in the project:

```
/app
  /Http
    /Controllers
      PageController.php        # Handles page data fetching logic (API endpoint for pages including dynamic content page)
/resources
    /components
      TreeView.vue              # The recursive component that renders the tree structure
    /js
        /views
            PageManager.vue     # Renders CRUD viee (Page Management)  
            PageView.vue        # Renders a single page with subpages (children)
        /router
            index.js            #define routes with vue-router
        app.js                  # to define create vue-app
        App.vue                 # to include vue-app 
  /views
    /app.blade.php            # The recursive component that renders the tree structure
    /welcome.blade.php        # The file is updated to render Page management UI on welcome screen
/routes
    web.php / api.php                  # Routes for the application

```

### Example Routes

1. **Home Page**:  
   The main page for Page Management is accessible by visiting the root URL:

2. **Accessing Nested Pages**:  
    Each page has a **slug** that forms part of the URL path. The page structure is hierarchical, so nested pages are accessible through a path like:
/page1 (First page) 
/page1/page2 (Page 2 under Page 1) 
/page1/page2/page3 (Page 3 under Page 2)