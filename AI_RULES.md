# AI_RULES.md

## Tech Stack Overview

- **Language:** PHP (primary backend language)
- **Framework:** CodeIgniter (MVC PHP framework)
- **Frontend:** HTML, CSS, JavaScript (with jQuery and AngularJS)
- **UI Libraries:** Bootstrap, AdminLTE, Font Awesome, Ionicons
- **Database:** MySQL (configured via `application/config/database.php`)
- **Asset Management:** Static assets (CSS, JS, images) in `public/`
- **Views:** PHP-based templates in `application/views/`
- **Controllers/Models:** Organized in `application/controllers/` and `application/models/`
- **Third-party Plugins:** Select2, DataTables, iCheck, Datepicker, FullCalendar, etc.
- **Legacy/Custom Modules:** May exist in `x container/` and `application/views/app/`

## Library Usage Rules

1. **UI Components:**
   - Use **Bootstrap** for layout, grid, and responsive design.
   - Use **AdminLTE** for dashboard and admin panel UI elements.
   - Use **Font Awesome** and **Ionicons** for icons.

2. **JavaScript Functionality:**
   - Use **jQuery** for DOM manipulation and AJAX unless AngularJS is already used in the module.
   - Use **AngularJS** only in modules where SPA-like behavior or two-way data binding is required (e.g., `application/controllers/Angular.php`).

3. **Forms and Inputs:**
   - Use **Select2** for enhanced select dropdowns.
   - Use **iCheck** for custom checkbox/radio styling.
   - Use **Bootstrap Datepicker** for date inputs.

4. **Tables and Data:**
   - Use **DataTables** for interactive tables (sorting, filtering, pagination).

5. **Calendar/Scheduling:**
   - Use **FullCalendar** for calendar views and scheduling features.

6. **Backend Logic:**
   - Place business logic in **models** (`application/models/`).
   - Place request handling and routing in **controllers** (`application/controllers/`).
   - Place presentation logic in **views** (`application/views/`).

7. **Configuration:**
   - Store all configuration in `application/config/`.
   - Do not hardcode credentials or environment-specific values in code files.

8. **Custom/Legacy Code:**
   - Place custom modules in `application/views/app/` or `x container/` only if they do not fit the standard MVC structure.

9. **Third-party Libraries:**
   - Place all third-party PHP libraries in `application/third_party/`.
   - Place all third-party JS/CSS in `public/` under appropriate subfolders.

10. **Error Handling:**
    - Use `application/errors/` for custom error pages.

---

_This document defines the technology stack and rules for consistent library usage in this application._
