<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        
        .invoice-header h1 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .transaction-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .info-item {
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .purchase-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .purchase-table th {
            background-color: #2c3e50;
            color: white;
            text-align: left;
            padding: 12px;
        }
        
        .purchase-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .purchase-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #e8f4f8 !important;
        }
        
        .status-paid {
            color: #27ae60;
            font-weight: bold;
        }
        
        .status-pending {
            color: #e67e22;
            font-weight: bold;
        }
        
        .status-arrears {
            color: #e74c3c;
            font-weight: bold;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
            
            .invoice-header {
                border-bottom: 2px solid #000;
            }
        }
        
        .print-button {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px 0;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>INVOICE</h1>
        <p>This invoice was created on {{\Carbon\Carbon::parse(now())->format('D-M-Y')}}</p>
    </div>
    
    <div class="transaction-info">
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Transaction ID:</span> {{\Carbon\Carbon::parse($item->date)->format('Y-M') }}-{{$item->id}}
            </div>
            <div class="info-item">
                <span class="info-label">Date:</span>{{\Carbon\Carbon::parse($item->date)->format('d-M-Y') }} 
            </div>
            <div class="info-item">
                <span class="info-label">Total Amount:</span> Rp. {{$item->total_price}}
            </div>
            <div class="info-item">
                <span class="info-label">Status:</span> <span class="{{$item->status == "paid" ? "status-paid" : "status-arrears"}}">{{$item->status}}</span>
            </div>
        </div>
    </div>
    
    <table class="purchase-table">
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
            $groupedMedicines = $item->transactionsItem->groupBy(function($item) {
                return $item->batchDrug->medicineMaster->name;
            })->map(function($group) {
                return [
                    'quantity' => $group->sum('item_amount'),
                    'price' => $group->first()->batchDrug->medicineMaster->price,
                    'total' => $group->sum('total_price')
                ];
            });
        @endphp

        @foreach ($groupedMedicines as $medicineName => $details)
        <tr>
            <td>{{ $medicineName }}</td>
            <td>{{ $details['quantity'] }}</td>
            <td>Rp {{ $details['price'] }}</td>
            <td>Rp {{ $details['total'] }}</td>
        </tr>
        @endforeach
           
            
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">Grand Total:</td>
                <td>Rp {{$item->total_price}}</td>
            </tr>
        </tbody>
    </table>

    <hr>
    <br>
    <br>
            
</body>
</html>