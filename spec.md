# Laboratory / X-ray / Ultrasound Module Specification

## 1. Overview
This module facilitates the management of service requests for Laboratory, X-ray, and Ultrasound departments. It allows users to create, view, and manage requests, including printing and exporting to Excel.

## 2. User Requirements

### 2.1 Patient Information
- **Pre-requisite:** Patient information must be encoded first using the existing Patient Registration module.
- **Integration:** The module will link to existing patient records via `patient_no`.

### 2.2 Dashboard
- A central "Laboratory / X-ray / Ultrasound" dashboard.
- Displays navigation to the sub-modules (Service Request, Reports, etc.).

### 2.3 Service Request Menu
- **Display:** List of service requests.
- **Default Filter:** Date range from *Previous Day* to *Current Day*.
- **Columns:**
    - Date Request
    - Service Description
    - Qty
    - Unit Cost
    - Discount
    - Total
    - Status (Pending, Active, Cancelled)
    - Discount Remarks
- **Actions:**
    - Create Laboratory Request
    - Print List
    - Export to Excel
    - Change Status (Pending -> Active -> Cancelled)

### 2.4 Create Laboratory Request
- **Input Fields:**
    - **Patient Name:** Autocomplete (fetches `patient_no` and name).
    - **Laboratory No:** Auto-generated based on type:
        - `L` + 8 digits for Laboratory (e.g., L00000001)
        - `X` + 8 digits for X-ray (e.g., X00000001)
        - `U` + 8 digits for Ultrasound (e.g., U00000001)
    - **Date Request:** Defaults to `now()`.
    - **Service Category:** Dropdown/Selection (Laboratory, X-ray, Ultrasound) - *Determines the ID prefix*.
    - **Service Description:** Autocomplete (fetches from `bill_particular` table, filtered by selected category).
    - **Qty:** Quantity of the service.
    - **Amount:** Unit cost (fetched from `bill_particular`).
    - **Discount:** Amount or percentage to deduct.
    - **Discount Remarks:** Reason for discount.
    - **Total:** Auto-calculated (`(Qty * Amount) - Discount`).
- **Default Status:** `Pending`.

## 3. Technical Design

### 3.1 Database Schema

#### `lab_service_request`
Stores the header information for a service request.

| Column | Type | Description |
| :--- | :--- | :--- |
| `request_id` | INT (PK, Auto-inc) | Unique ID |
| `request_no` | VARCHAR(20) | Formatted ID (e.g., L00000001) |
| `patient_no` | VARCHAR(20) | Links to `patient_personal_info` |
| `request_date` | DATETIME | Date of request |
| `request_type` | VARCHAR(20) | 'Laboratory', 'X-ray', 'Ultrasound' |
| `doctor_id` | VARCHAR(20) | Requesting Doctor (Optional) |
| `remarks` | TEXT | General remarks |
| `status` | VARCHAR(20) | 'Pending', 'Active', 'Cancelled' |
| `created_by` | INT | User ID |
| `created_date` | DATETIME | Timestamp |
| `InActive` | INT | Soft delete flag (0=Active, 1=Deleted) |

#### `lab_service_request_details`
Stores the line items (particulars) for a request.

| Column | Type | Description |
| :--- | :--- | :--- |
| `detail_id` | INT (PK, Auto-inc) | Unique ID |
| `request_id` | INT | Links to `lab_service_request` |
| `particular_id` | INT | Links to `bill_particular` |
| `qty` | INT | Quantity |
| `amount` | DECIMAL(10,2) | Unit Price |
| `discount` | DECIMAL(10,2) | Discount Amount |
| `discount_remarks` | VARCHAR(255) | Remarks for discount |
| `total_amount` | DECIMAL(10,2) | Final line total |
| `InActive` | INT | Soft delete flag |

### 3.2 Controllers

#### `application/controllers/app/lab_services.php`
- `index()`: Loads the dashboard.
- `service_request()`: Loads the request list view.
- `add_request()`: Loads the form to create a new request.
- `save_request()`: Handles form submission.
- `get_patient_autocomplete()`: AJAX handler for patient search.
- `get_service_autocomplete()`: AJAX handler for service search (filtered by type).
- `update_status()`: AJAX handler to change status.
- `print_list()`: Generates the print view.
- `export_excel()`: Generates the Excel download.

### 3.3 Models

#### `application/models/app/Lab_services_model.php`
- `getRequests($filters)`: Fetches requests with filtering (date, status).
- `saveRequest($data, $details)`: Transactional save of header and details.
- `generateRequestNo($type)`: Generates the next `L/X/U` number.
    - Logic: `SELECT MAX(request_no) WHERE request_type = $type`. Parse, increment, and format.
- `getParticulars($search, $group_ids)`: Searches `bill_particular` joined with `bill_group_name`.

### 3.4 Views

- `application/views/app/lab_services/dashboard.php`: Main entry point.
- `application/views/app/lab_services/service_request_index.php`: The list view with filters.
- `application/views/app/lab_services/add_request.php`: The create form.
- `application/views/app/lab_services/print_request_list.php`: Print layout.

## 4. Workflows

### 4.1 ID Generation
The system must generate IDs based on the selected **Service Category**:
- If Category = "Laboratory" -> Prefix "L"
- If Category = "X-ray" -> Prefix "X"
- If Category = "Ultrasound" -> Prefix "U"

The number part (8 digits) should auto-increment based on the last record of that *specific prefix*.

### 4.2 Status Transition
- **Pending**: Initial state upon creation.
- **Active**: Can be set by user (implies currently being processed or approved).
- **Cancelled**: Can be set by user (voided).

### 4.3 Data Filters
- The "Service Request Menu" must default to showing records from `yesterday` to `today`.
