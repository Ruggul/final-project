<!DOCTYPE html>
<html>
<head>
    <title>Edit Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3>Edit Payment</h3>
            </div>

            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label>Invoice Number</label>
                        <input type="text" 
                               name="invoice_number" 
                               class="form-control" 
                               value="INV-2024-001"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Payment Status</label>
                        <select name="payment_status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="pending" selected>Pending</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">Select Method</option>
                            <option value="credit_card" selected>Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="e-wallet">E-Wallet</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Payment Date</label>
                        <input type="date" 
                               name="payment_date" 
                               class="form-control" 
                               value="2024-03-01"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Due Date</label>
                        <input type="date" 
                               name="due_date" 
                               class="form-control" 
                               value="2024-03-15"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" 
                                  class="form-control" 
                                  rows="3">Payment for March 2024</textarea>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="btn btn-secondary">Back</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>