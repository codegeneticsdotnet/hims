# Hospital Information Management System (HIMS) - Process Flow Summary

## 1. System Overview
The HIMS manages the end-to-end flow of patient care, from registration to discharge and billing. It is divided into key modules: Patient Management (OPD/IPD), Clinical Services (Doctor/Nurse), Ancillary (Lab/Pharmacy), and Billing/Admin.

## 2. Process Flow

### A. Patient Registration
*   **Input**: Receptionist enters patient demographics (Name, Age, Address, Contact).
*   **Action**: System checks for existing records to avoid duplicates.
*   **Output**: A unique **Patient ID** is generated.
*   **Key Tables**: `patient_personal_info`.

### B. Out-Patient Department (OPD)
*   **Visit**: Patient walks in or has an appointment.
*   **Consultation**: Doctor reviews patient, records vitals (`iop_vital_parameters`) and diagnosis (`iop_diagnosis`).
*   **Orders**: Doctor prescribes medication or requests lab tests.
*   **Disposition**: Patient is either sent home (with prescription) or admitted to IPD.

### C. In-Patient Department (IPD)
*   **Admission**: Patient is assigned a Room/Ward and Bed (`iop_room_transfer`).
*   **Care & Monitoring**:
    *   Nurses record daily notes (`iop_nurse_notes`), vital signs, and intake/output.
    *   Doctors perform rounds and record progress (`iop_progress_note`).
*   **Procedures**: Bedside procedures (Oxygen, Nebulizer, etc.) are recorded for billing (`iop_bed_side_procedure`).
*   **Transfers**: Patient movement between rooms (e.g., Ward to ICU) is tracked for accurate room charging.

### D. Ancillary Services
*   **Laboratory**:
    *   Requests (`lab_service_request`) are received from Doctors.
    *   Results are entered and verified.
*   **Pharmacy**:
    *   Prescriptions (`iop_medication`) are received.
    *   Pharmacist dispenses items -> Stock is deducted from Inventory (`pharmacy_inventory_details`, `pharmacy_sales`).

### E. Billing & Discharge
*   **Charge Aggregation**: The system compiles all billable items:
    *   **Room Charges**: Calculated based on days spent in each room type.
    *   **Professional Fees**: Derived from Discharge Advice (`iop_discharge_advice`).
    *   **Services/Procedures**: Ambulance, Oxygen, Lab tests.
    *   **Medications**: From Pharmacy sales.
*   **Payment**: Bill is generated (`iop_billing`), payment is accepted, and receipt issued (`iop_receipt`).
*   **Discharge**: Patient is marked as discharged (`patient_details_iop`), releasing the bed.

---

## 3. Database Analysis

### Key Relationships
*   **Users** (`users`) are linked to **Roles** (`user_roles`) and **Departments** (`department`).
*   **Patients** (`patient_personal_info`) have multiple **Admissions/Visits** (`patient_details_iop`).
*   **Admissions** (`patient_details_iop`) are the central hub linking to:
    *   Doctors (`users`)
    *   Diagnosis (`iop_diagnosis`)
    *   Billing (`iop_billing`)
    *   Room Transfers (`iop_room_transfer`)

### Unused / Legacy Tables
The following tables appear to be unused (0 rows) or legacy artifacts (e.g., from an older system version) and could be candidates for cleanup/archiving:

1.  **Legacy Inventory Tables** (Prefix `o_`): `o_batch`, `o_binlocation`, `o_cart_trans`, `o_conversion`, `o_itemdetails`, `o_items`, `o_reference`, `o_transactions`, `o_unit`.
    *   *Note*: The active system uses `pharmacy_` tables for inventory.
2.  **Empty Functional Tables**:
    *   `cart_billing`
    *   `category_list`
    *   `declaredor`
    *   `department_stock`
    *   `doctors_fee` (Likely replaced by `iop_discharge_advice`)
    *   `inv_items`
    *   `patient_appointment` (If appointments are not being used)
    *   `surgical_package`
