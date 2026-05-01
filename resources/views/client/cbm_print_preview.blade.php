<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معاينة فاتورة CBM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap');
        
        * {
            box-sizing: border-box;
            font-family: 'Cairo', 'Arial', sans-serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #525659;
            display: flex;
            justify-content: center;
        }

        .a4-page {
            width: 210mm;
            min-height: 297mm;
            max-height: 297mm;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        .header-section {
            padding: 10mm 15mm 0 15mm;
        }

        .header-brand {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 10px;
        }

        .header-img {
            max-height: 70px;
            width: auto;
            max-width: 200px;
            object-fit: contain;
        }
        
        .header-title {
            color: #1e3a5f;
            margin: 8px 0 0 0;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: 0.5px;
        }

        .content {
            padding: 5mm 15mm;
            flex-grow: 1;
        }

        .client-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .client-info .label {
            color: #1e3a5f;
            font-weight: bold;
        }

        .table-responsive {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #1e3a5f;
            color: white;
            padding: 6px 4px;
            border: 1px solid #102540;
            font-size: 11px;
        }
        
        td {
            padding: 5px 3px;
            border: 1px solid #ddd;
            color: #333;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        .summary-row td {
            background-color: #fff9e6 !important;
            font-size: 12px;
            font-weight: bold;
        }

        .vis-panel {
            background: linear-gradient(145deg, #ffffff, #f0f4f8);
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #dce4ec;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .vis-icon {
            font-size: 45px;
            color: #3c8dbc;
        }

        .vis-stats {
            display: flex;
            gap: 10px;
            flex-grow: 1;
        }

        .stat-box {
            flex: 1;
            background: #fff;
            padding: 10px;
            border-radius: 6px;
            border-right: 4px solid #ccc;
            border-left: 1px solid #eee;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .stat-box.cbm { border-right-color: #3c8dbc; color: #3c8dbc; }
        .stat-box.weight { border-right-color: #d9534f; color: #d9534f; }
        .stat-box.price { border-right-color: #28a745; color: #28a745; }

        .stat-title {
            font-size: 10px;
            color: #888;
            margin-bottom: 3px;
        }

        .stat-value {
            font-size: 15px;
            font-weight: bold;
            direction: ltr;
            text-align: right;
        }

        .safe-alert, .warning-alert {
            display: flex;
            border-radius: 6px;
            padding: 10px;
            font-weight: bold;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .safe-alert {
            background: #f0fdf4;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .warning-alert {
            background: #fff3f3;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .controls {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.8);
            padding: 15px 30px;
            border-radius: 50px;
            display: flex;
            gap: 20px;
            z-index: 1000;
        }

        .controls button {
            background: #fff;
            border: none;
            padding: 8px 18px;
            font-size: 15px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: bold;
            color: #333;
        }

        .controls button.print-btn {
            background: #007bff;
            color: #fff;
        }
        
        .controls button:hover {
            opacity: 0.9;
        }

        @media print {
            body {
                background: none;
                margin: 0;
            }
            .a4-page {
                box-shadow: none;
                margin: 0;
                width: 100%;
                min-height: auto;
                max-height: none;
            }
            .controls {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 0;
            }
        }
        
        .english-nums {
            font-family: Arial, sans-serif;
            direction: ltr;
            display: inline-block;
        }
    </style>
</head>
<body>

    <div class="a4-page">
        <!-- Compact Header -->
        <div class="header-section">
            <div class="header-brand">
                <img src="{{ asset('storage/invoices.JPG') }}" class="header-img" alt="NGIS Header Image">
                <h2 class="header-title">نكس قلوبال | NexGlobal | NGIS</h2>
            </div>
        </div>

        <div class="content">
            <h3 style="text-align: center; color: #1e3a5f; margin: 0 0 15px 0; font-size: 16px;">LOGISTICS & CBM DETAILS / مسودة شحنات مبدئية</h3>
            
            <!-- Client Info Row -->
            <div class="client-info">
                <div>
                    <div class="label">CLIENT / العميل:</div>
                    <div style="font-size: 15px; margin-top: 3px;">{{ Auth::user()->name ?? 'N/A' }}</div>
                </div>
                <div style="text-align: left; direction: ltr;">
                    <div class="label">Invoice No.:</div>
                    <div style="font-size: 12px;">NGIS-CBM-{{ date('Y') }}-{{ rand(1000,9999) }}</div>
                    <div class="label" style="margin-top: 3px;">Date:</div>
                    <div style="font-size: 12px;">{{ date('Y-m-d') }}</div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>الصورة</th>
                            <th>المنتج</th>
                            <th>ID المنتج</th>
                            <th>سعر الوحدة</th>
                            <th>وزن الوحدة</th>
                            <th style="font-size:9px;">CBM للوحدة</th>
                            <th>الكمية</th>
                            <th>إجمالي CBM</th>
                            <th>إجمالي الوزن</th>
                        </tr>
                    </thead>
                    <tbody id="cart-rows">
                        <!-- Filled statically by JS -->
                    </tbody>
                    <tfoot>
                        <tr class="summary-row">
                            <td colspan="7" style="text-align: right; padding-right: 15px;">إجمالي سلة الشحن المخطط لها:</td>
                            <td style="color: #3c8dbc;"><span id="total-cbm-val" class="english-nums">0</span></td>
                            <td style="color: #d9534f;"><span id="total-weight-val" class="english-nums">0 KG</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Visualization / Summary Panel -->
            <div class="vis-panel">
                <div style="text-align: center;">
                    <i class="fa fa-cubes vis-icon" id="vis-cube"></i>
                    <div style="font-size: 11px; font-weight: bold; margin-top: 3px; color: #1e3a5f;">CBM Tracker</div>
                </div>
                
                <div style="flex-grow: 1;">
                    <h4 style="margin: 0 0 8px 0; color: #1e3a5f; font-size: 14px;">الإحصائيات اللوجستية للسلة بالمجمل</h4>
                    
                    <div class="vis-stats">
                        <div class="stat-box cbm">
                            <div class="stat-title">الحجم (CBM)</div>
                            <div class="stat-value" id="card-cbm">0.000</div>
                        </div>
                        <div class="stat-box weight">
                            <div class="stat-title">الوزن</div>
                            <div class="stat-value" id="card-weight">0 KG</div>
                        </div>
                        <div class="stat-box price">
                            <div class="stat-title">القيمة</div>
                            <div class="stat-value" id="card-price">0.00</div>
                        </div>
                    </div>

                    <!-- Alerts -->
                    <div id="safe-alert" class="safe-alert">
                        <i class="fa fa-check-circle" style="font-size: 20px;"></i>
                        <div>
                            <div style="font-size: 12px;">حجم الشحنة مثالي وآمن</div>
                            <div style="font-size: 10px; color: #666; font-weight: normal;">الكتلة الحجمية الحالية قيد الحد المسموح (≤ 1 CBM).</div>
                        </div>
                    </div>

                    <div id="warning-alert" class="warning-alert" style="display: none;">
                        <i class="fa fa-exclamation-triangle" style="font-size: 20px;"></i>
                        <div>
                            <div style="font-size: 12px;">تنبيه: سعة الشحنة تتجاوز 1 متر مكعب!</div>
                            <div style="font-size: 10px; color: #666; font-weight: normal;">تحتاج مسار شحن موسع لتفادي التكدس.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Stamp -->
            <div style="margin-top: 15px; text-align: center; color: #888; font-size: 10px;">
                <p>مستخرج إلكترونياً من منصة NGIS. الأرقام تعد تقديراً أولياً لحساب المساحات اللوجستية وتخطيط الشحنات.</p>
            </div>
        </div>
    </div>

    <div class="controls">
        <button onclick="window.close()"><i class="fa fa-times"></i> إغلاق الصفحة</button>
        <button class="print-btn" onclick="window.print()"><i class="fa fa-print"></i> التوجه للطباعة</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const raw = localStorage.getItem('cbm_cart_items');
            if(!raw) {
                document.getElementById('cart-rows').innerHTML = '<tr><td colspan="9">سلة المشتريات فارغة.</td></tr>';
                return;
            }
            
            try {
                const items = JSON.parse(raw);
                if(!items || !items.length) {
                    document.getElementById('cart-rows').innerHTML = '<tr><td colspan="9">سلة المشتريات فارغة.</td></tr>';
                    return;
                }

                let html = '';
                let tCbm = 0;
                let tWgt = 0;
                let tPrice = 0;
                let fCurr = '';

                items.forEach((item, index) => {
                    tCbm += parseFloat(item.total_cbm);
                    tWgt += parseFloat(item.total_weight);
                    tPrice += (parseFloat(item.qty) || 0) * (parseFloat(item.unit_price) || 0);
                    if(index === 0) fCurr = item.currency || '';

                    const img = item.images && item.images.length ? item.images[0] : item.image;
                    
                    html += `
                        <tr>
                            <td>
                                <img src="${img}" style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td style="font-weight: bold;">${item.name}</td>
                            <td>${item.sku}</td>
                            <td><span class="english-nums">${item.currency} ${parseFloat(item.unit_price).toFixed(2)}</span></td>
                            <td><span class="english-nums">${parseFloat(item.unit_weight).toFixed(2)}</span> كجم</td>
                            <td><span class="english-nums">${parseFloat(item.unit_cbm).toFixed(4)}</span></td>
                            <td><span class="english-nums">${item.qty}</span><br><small style="font-size:8px;">(${item.cartons} كرتونة)</small></td>
                            <td style="font-weight: bold; color: #3c8dbc; background: #fafafa;"><span class="english-nums">${parseFloat(item.total_cbm).toFixed(3)}</span></td>
                            <td style="font-weight: bold; color: #d9534f; background: #fafafa;"><span class="english-nums">${parseFloat(item.total_weight).toFixed(2)}</span> كجم</td>
                        </tr>
                    `;
                });

                document.getElementById('cart-rows').innerHTML = html;
                
                // Set Totals
                document.getElementById('total-cbm-val').innerText = tCbm.toFixed(3);
                document.getElementById('total-weight-val').innerText = tWgt.toFixed(2) + ' KG';
                
                document.getElementById('card-cbm').innerText = tCbm.toFixed(3);
                document.getElementById('card-weight').innerText = tWgt.toFixed(2) + ' KG';
                document.getElementById('card-price').innerText = fCurr + ' ' + tPrice.toFixed(2);

                if(tCbm > 1) {
                    document.getElementById('safe-alert').style.display = 'none';
                    document.getElementById('warning-alert').style.display = 'flex';
                    document.getElementById('vis-cube').style.color = '#dc3545';
                }

                setTimeout(() => window.print(), 500);

            } catch (e) {
                document.getElementById('cart-rows').innerHTML = '<tr><td colspan="9">حدث خطأ في استرجاع البيانات.</td></tr>';
            }
        });
    </script>
</body>
</html>
