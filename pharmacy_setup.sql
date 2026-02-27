CREATE TABLE IF NOT EXISTS pharmacy_sales (
    sale_id INT AUTO_INCREMENT PRIMARY KEY, 
    invoice_no VARCHAR(50), 
    date_sale DATETIME, 
    patient_no VARCHAR(50) DEFAULT NULL, 
    patient_name VARCHAR(100) DEFAULT NULL, 
    sub_total DECIMAL(10,2), 
    discount DECIMAL(10,2), 
    total_amount DECIMAL(10,2), 
    remarks TEXT, 
    payment_type VARCHAR(20) DEFAULT 'Cash',
    InActive INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS pharmacy_sales_details (
    detail_id INT AUTO_INCREMENT PRIMARY KEY, 
    sale_id INT, 
    drug_id INT, 
    item_name VARCHAR(255), 
    qty INT, 
    price DECIMAL(10,2), 
    total DECIMAL(10,2), 
    InActive INT DEFAULT 0
);

INSERT IGNORE INTO system_option (cCode, cValue, cDesc) VALUES ('pharmacy_invoice_no', '0', 'Pharmacy Invoice Number');
