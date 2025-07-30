<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_code }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 15px;
            color: #333;
            line-height: 1.4;
            font-size: 14px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #00A99D;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #00A99D;
            margin-bottom: 2px;
        }
        .company-tagline {
            font-size: 14px;
            color: #666;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        .customer-info, .invoice-details {
            width: 48%;
            min-width: 250px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #00A99D;
            margin-bottom: 5px;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }
        .info-row {
            margin-bottom: 3px;
            font-size: 14px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th {
            background-color: #00A99D;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
        }
        td {
            padding: 6px 8px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .payment-info {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 3px;
            margin-top: 15px;
        }
        .payment-title {
            font-size: 16px;
            font-weight: bold;
            color: #00A99D;
            margin-bottom: 8px;
        }
        .bank-info {
            margin-bottom: 8px;
        }
        .bank-name {
            font-weight: bold;
            font-size: 14px;
        }
        .account-number {
            font-family: monospace;
            font-size: 16px;
            color: #333;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-quotation { background-color: #e3f2fd; color: #1976d2; }
        .status-waiting_payment { background-color: #fff3e0; color: #f57c00; }
        .status-in_production { background-color: #fff8e1; color: #fbc02d; }
        .status-completed { background-color: #e8f5e8; color: #388e3c; }
        .status-cancelled { background-color: #ffebee; color: #d32f2f; }
        
        /* Print styles */
        @media print {
            body { 
                margin: 0; 
                padding: 10px; 
                font-size: 13px;
                line-height: 1.3;
            }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
            @page { 
                margin: 0.8cm; 
                size: A4;
            }
            .header {
                margin-bottom: 10px;
                padding-bottom: 5px;
            }
            .company-name {
                font-size: 20px;
            }
            .invoice-info {
                margin-bottom: 10px;
            }
            .section-title {
                margin-bottom: 3px;
                font-size: 14px;
            }
            .info-row {
                margin-bottom: 2px;
                font-size: 12px;
            }
            .label {
                font-size: 12px;
            }
            table {
                margin-bottom: 8px;
            }
            th, td {
                padding: 4px 6px;
                font-size: 12px;
            }
            .payment-info {
                margin-top: 10px;
                padding: 8px;
            }
            .payment-title {
                font-size: 14px;
            }
            .bank-name {
                font-size: 12px;
            }
            .account-number {
                font-size: 14px;
            }
            .footer {
                margin-top: 15px;
                padding-top: 8px;
                font-size: 12px;
            }
        }
        
        /* Screen styles */
        @media screen {
            .print-button { 
                position: fixed; top: 20px; right: 20px; 
                background: #00A99D; color: white; padding: 10px 20px; 
                border: none; border-radius: 5px; cursor: pointer; 
                z-index: 1000;
                font-size: 14px;
            }
            .download-button {
                position: fixed; top: 20px; right: 150px; 
                background: #28a745; color: white; padding: 10px 20px; 
                border: none; border-radius: 5px; cursor: pointer; 
                z-index: 1000;
                font-size: 14px;
            }
            .back-button {
                position: fixed; top: 20px; left: 20px; 
                background: #6c757d; color: white; padding: 10px 20px; 
                border: none; border-radius: 5px; cursor: pointer; 
                z-index: 1000;
                font-size: 14px;
                text-decoration: none;
            }
        }
    </style>
</head>
<body>
    <!-- Print/Download Buttons -->
    <button class="print-button no-print" onclick="window.print()">🖨️ Print Invoice</button>
    <button class="download-button no-print" onclick="downloadAsPDF()">📄 Save as PDF</button>
    <a href="{{ route('invoice.show', $order->order_code) }}" class="back-button no-print">← Kembali</a>

    <div class="header">
        <div class="company-name">PT. Multi Karya Grafika Utama</div>
        <div class="company-tagline">Solusi Printing & Digital Marketing Terpercaya</div>
    </div>

    <div class="invoice-info">
        <div class="customer-info">
            <div class="section-title">Informasi Pelanggan</div>
            <div class="info-row">
                <span class="label">Nama:</span>
                <span>{{ $order->customer_name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Email:</span>
                <span>{{ $order->customer_email }}</span>
            </div>
            <div class="info-row">
                <span class="label">WhatsApp:</span>
                <span>{{ $order->customer_phone }}</span>
            </div>
        </div>
        
        <div class="invoice-details">
            <div class="section-title">Detail Invoice</div>
            <div class="info-row">
                <span class="label">Kode Order:</span>
                <span>{{ $order->order_code }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tanggal:</span>
                <span>{{ $order->created_at->format('d M Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Status Order:</span>
                <span class="status-badge status-{{ $order->status }}">
                    {{ $order->status_label }}
                </span>
            </div>
            <div class="info-row">
                <span class="label">Status Bayar:</span>
                <span class="status-badge status-{{ $order->payment_status }}">
                    {{ $order->payment_status_label }}
                </span>
            </div>
        </div>
    </div>

    <div class="section-title">Detail Produk</div>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->details as $detail)
            <tr>
                <td>{{ $detail->product->name ?? 'Produk' }}</td>
                <td>{{ $detail->quantity }}</td>
                                        <td>Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-row" style="text-align: right; font-size: 16px; padding: 10px;">
                        <strong>Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
    </div>

    <div class="payment-info">
        <div class="bank-info">
            <div class="bank-name">Bank Mandiri</div>
            <div class="account-number">006-00-1297862-7</div>
            <div>a.n. PT.IDOLA MULIA UTAMA KCP. Jakarta Matraman</div>
        </div>
        <div style="font-size: 14px; color: #666; margin-top: 8px;">
            <strong>Catatan:</strong> Mohon transfer sesuai total di atas. Upload bukti transfer melalui halaman invoice ini.
        </div>
    </div>

    <div class="footer">
        <p style="margin: 5px 0; font-size: 14px;">Terima kasih telah mempercayakan kebutuhan printing & digital marketing Anda kepada kami.</p>
        <p style="margin: 5px 0; font-size: 14px;">PT. Multi Karya Grafika Utama - Solusi Printing & Digital Marketing Terpercaya</p>
        <p style="margin: 5px 0; font-size: 14px;">Email: info@ptmku.com | WhatsApp: +62 812-3456-7890</p>
    </div>

    <script>
    function downloadAsPDF() {
        // Create a new window for printing
        var printWindow = window.open("", "_blank");
        printWindow.document.write(document.documentElement.outerHTML);
        printWindow.document.close();
        
        // Wait a bit for content to load, then print
        setTimeout(function() {
            printWindow.print();
        }, 500);
    }
    
    // Auto-print when page loads (optional)
    // window.onload = function() {
    //     setTimeout(function() {
    //         window.print();
    //     }, 1000);
    // }
    </script>
</body>
</html> 