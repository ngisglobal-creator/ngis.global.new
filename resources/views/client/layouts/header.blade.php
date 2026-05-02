<header class="main-header">
    <div class="d-flex align-items-center w-100">
        <!-- Sidebar Toggle -->
        <button id="sidebarToggle" class="btn btn-link text-dark d-lg-none me-2">
            <i class="fa-solid fa-bars fs-4"></i>
        </button>

        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- Wallet -->
            <a href="{{ route('client.wallet') }}" class="text-decoration-none d-flex align-items-center gap-2 px-3 py-2 rounded bg-light border">
                <i class="fa-solid fa-wallet text-primary fs-5"></i>
                <span class="fw-bold english-nums">{{ number_format(auth()->user()->wallet_balance, 2, '.', '') }}</span>
            </a>

            <!-- Language Dropdown -->
            <div class="dropdown">
                <button class="btn btn-light border dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-language text-secondary"></i>
                    <span class="badge bg-secondary">{{ strtoupper(app()->getLocale()) }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li class="dropdown-header">{{ __('dashboard.language') }}</li>
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('lang-ar').submit();">{{ __('dashboard.arabic') }}</a></li>
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('lang-en').submit();">{{ __('dashboard.english') }}</a></li>
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('lang-zh').submit();">{{ __('dashboard.chinese') }}</a></li>
                </ul>
                <form id="lang-ar" action="{{ route('language.set') }}" method="POST" class="d-none">@csrf<input type="hidden" name="locale" value="ar"></form>
                <form id="lang-en" action="{{ route('language.set') }}" method="POST" class="d-none">@csrf<input type="hidden" name="locale" value="en"></form>
                <form id="lang-zh" action="{{ route('language.set') }}" method="POST" class="d-none">@csrf<input type="hidden" name="locale" value="zh"></form>
            </div>

            <!-- CBM Cart -->
            <button class="btn btn-light border position-relative" data-bs-toggle="modal" data-bs-target="#cbmInfoModal" style="height: 38px;">
                @if(in_array(Auth::user()->type ?? '', ['merchant', 'company_owner']))
                    <i class="fa-solid fa-cart-shopping text-dark"></i>
                @else
                    <span class="fw-bold text-dark">CBM</span>
                @endif
                <span id="cbm-cart-badge" class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger shadow" style="display: none;">0</span>
            </button>
        </div>
    </div>
</header>

<!-- CBM Info Modal (Bootstrap 5) -->
<div class="modal fade" id="cbmInfoModal" tabindex="-1" aria-labelledby="cbmInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-light">
            <div class="modal-header bg-primary text-white border-0 py-3 px-4">
                <h5 class="modal-title fw-bold" id="cbmInfoModalLabel"><i class="fa-solid fa-cube me-2"></i> السلة اللوجستية</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 bg-white">
                <ul class="nav nav-tabs nav-justified bg-light border-bottom" id="cbmTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold text-primary py-3 border-0" id="cart-tab" data-bs-toggle="tab" data-bs-target="#tab_cart" type="button" role="tab"><i class="fa-solid fa-cart-shopping me-2"></i> تفاصيل السلة اللوجستية</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-danger py-3 border-0" id="heavy-tab" data-bs-toggle="tab" data-bs-target="#tab_heavy" type="button" role="tab"><i class="fa-solid fa-truck me-2"></i> طلبات المعدات الثقيلة <span id="heavy-cart-count" class="badge bg-danger ms-1" style="display: none;">0</span></button>
                    </li>
                </ul>

                <div class="tab-content" id="cbmTabsContent">
                    <!-- Cart Tab -->
                    <div class="tab-pane fade show active" id="tab_cart" role="tabpanel">
                        <div id="cbm-cart-empty" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-basket-shopping fa-4x opacity-25 mb-3"></i>
                            <h4 class="fw-bold">سلتك فارغة حالياً</h4>
                            <p>قم بإضافة منتجات لتظهر هنا.</p>
                        </div>
                        <div id="cbm-cart-content" style="display: none;" class="p-4">
                            <div class="table-responsive bg-white rounded shadow-sm border">
                                <table class="table table-hover table-bordered mb-0 text-center align-middle" style="font-size: 13px;">
                                    <thead class="table-primary text-dark">
                                        <tr>
                                            <th>الصورة</th>
                                            <th>المنتج</th>
                                            <th>ID المنتج</th>
                                            <th>سعر الوحدة</th>
                                            <th>وزن الوحدة</th>
                                            <th>CBM الوحدة</th>
                                            <th>الكمية</th>
                                            <th class="bg-primary text-white">إجمالي CBM</th>
                                            <th class="bg-primary text-white">إجمالي الوزن</th>
                                            <th class="bg-primary text-white">إجمالي السعر</th>
                                            <th class="bg-primary text-white">النوع</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cbm-cart-items"></tbody>
                                    <tfoot class="table-light fw-bold border-top-2 border-primary">
                                        <tr>
                                            <td colspan="7" class="text-start px-3">إجمالي السلة:</td>
                                            <td class="text-primary fs-6"><span id="cart-total-cbm" class="english-nums">0</span></td>
                                            <td class="text-danger fs-6"><span id="cart-total-weight" class="english-nums">0 KG</span></td>
                                            <td class="text-warning fs-6"><span id="cart-total-price" class="english-nums">0</span></td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Heavy Tab -->
                    <div class="tab-pane fade" id="tab_heavy" role="tabpanel">
                        <div id="heavy-cart-empty" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-truck fa-4x opacity-25 mb-3"></i>
                            <h4 class="fw-bold">لا توجد طلبات معدات ثقيلة</h4>
                        </div>
                        <div id="heavy-cart-content" style="display: none;" class="p-4">
                            <div class="table-responsive bg-white rounded shadow-sm border">
                                <table class="table table-hover table-bordered mb-0 text-center align-middle" style="font-size: 13px;">
                                    <thead class="table-danger text-dark">
                                        <tr>
                                            <th>الصورة</th>
                                            <th>المنتج</th>
                                            <th>الأبعاد</th>
                                            <th>الكمية</th>
                                            <th>إجمالي الوزن</th>
                                            <th>إجمالي السعر</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody id="heavy-cart-items"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-3 px-4">
                <a href="{{ route('cbm.print.preview') }}" target="_blank" class="btn btn-outline-secondary rounded-pill me-auto fw-bold px-4"><i class="fa-solid fa-print me-2"></i> طباعة</a>
                <button type="button" class="btn btn-secondary rounded-pill fw-bold px-4" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" id="btnCompleteOrder" class="btn btn-success rounded-pill fw-bold px-5" onclick="CBMCart.submitBulkOrder()"><i class="fa-solid fa-circle-check me-2"></i> إتمام الطلب</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.CBMCart = {
        key: 'cbm_cart_items',
        get() { return JSON.parse(localStorage.getItem(this.key)) || []; },
        add(item) {
            let cart = this.get();
            const existingIndex = cart.findIndex(i => i.id == item.id && i.shipping_unit_type == item.shipping_unit_type);
            if(existingIndex >= 0) {
                cart[existingIndex].qty = parseInt(cart[existingIndex].qty) + parseInt(item.qty);
                cart[existingIndex].cartons = parseInt(cart[existingIndex].cartons) + parseInt(item.cartons || 0);
                cart[existingIndex].total_weight = parseFloat(cart[existingIndex].total_weight) + parseFloat(item.total_weight || 0);
                cart[existingIndex].total_cbm = parseFloat(cart[existingIndex].total_cbm) + parseFloat(item.total_cbm || 0);
            } else {
                cart.push(item);
            }
            localStorage.setItem(this.key, JSON.stringify(cart));
            this.updateUI();
        },
        updateUI() {
            const cart = this.get();
            const badge = document.getElementById('cbm-cart-badge');
            if(badge) {
                badge.innerText = cart.length;
                badge.style.display = cart.length > 0 ? 'inline-block' : 'none';
            }
            this.renderTable();
        },
        remove(index) {
            let cart = this.get();
            cart.splice(index, 1);
            localStorage.setItem(this.key, JSON.stringify(cart));
            this.updateUI();
        },
        renderTable() {
            const cart = this.get();
            const body = document.getElementById('cbm-cart-items');
            if(!body) return;
            if(cart.length === 0) {
                document.getElementById('cbm-cart-empty').style.display = 'block';
                document.getElementById('cbm-cart-content').style.display = 'none';
                return;
            }
            document.getElementById('cbm-cart-empty').style.display = 'none';
            document.getElementById('cbm-cart-content').style.display = 'block';
            let html = '';
            let totalCbm = 0, totalWeight = 0, totalPrice = 0, cur = '';
            cart.forEach((item, index) => {
                totalCbm += parseFloat(item.total_cbm) || 0;
                totalWeight += parseFloat(item.total_weight) || 0;
                totalPrice += (parseFloat(item.qty) * parseFloat(item.unit_price)) || 0;
                if(index === 0) cur = item.currency || '';
                let img = item.images && item.images.length ? item.images[0] : item.image;
                html += `<tr>
                    <td><img src="${img}" class="rounded border shadow-sm" style="width:40px;height:40px;object-fit:cover;"></td>
                    <td class="fw-bold">${item.name}</td>
                    <td>${item.sku}</td>
                    <td class="english-nums text-danger">${parseFloat(item.unit_price).toFixed(2)} ${cur}</td>
                    <td class="english-nums">${parseFloat(item.unit_weight).toFixed(2)} KG</td>
                    <td class="english-nums">${parseFloat(item.unit_cbm).toFixed(4)}</td>
                    <td class="fw-bold english-nums">${item.qty}</td>
                    <td class="fw-bold text-primary english-nums">${parseFloat(item.total_cbm).toFixed(3)}</td>
                    <td class="fw-bold text-danger english-nums">${parseFloat(item.total_weight).toFixed(2)} KG</td>
                    <td class="fw-bold text-warning english-nums">${(item.qty * item.unit_price).toLocaleString()} ${cur}</td>
                    <td><span class="badge bg-primary">${item.shipping_unit_type || 'CBM'}</span></td>
                    <td><button onclick="CBMCart.remove(${index})" class="btn btn-sm btn-link text-danger"><i class="fa-solid fa-trash"></i></button></td>
                </tr>`;
            });
            body.innerHTML = html;
            document.getElementById('cart-total-cbm').innerText = totalCbm.toFixed(3);
            document.getElementById('cart-total-weight').innerText = totalWeight.toFixed(2) + ' KG';
            document.getElementById('cart-total-price').innerText = totalPrice.toLocaleString() + ' ' + cur;
        },
        submitBulkOrder() {
            // Simplified for Bootstrap 5 execution
            const standardItems = this.get();
            const heavyItems = window.HeavyCart ? window.HeavyCart.get() : [];
            if(standardItems.length === 0 && heavyItems.length === 0) {
                Swal.fire({icon:'warning', title:'السلة فارغة'});
                return;
            }
            const btn = document.getElementById('btnCompleteOrder');
            const orig = btn.innerHTML;
            btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> جاري الإرسال...';
            
            // Logic to collect all items
            let allItems = [];
            standardItems.forEach(i => allItems.push({id: i.id, qty: i.qty, shipping_unit_type: i.shipping_unit_type, cartons: i.cartons, total_weight: i.total_weight, total_cbm: i.total_cbm, unit_price: i.unit_price, total_cost: i.qty * i.unit_price, notes: i.notes||''}));
            heavyItems.forEach(i => allItems.push({id: i.id, qty: i.qty, shipping_unit_type: i.shipping_unit_type||'RoRo', total_weight: i.totalWeight, total_cost: i.totalPrice, notes: i.notes||''}));

            $.post("{{ route('orders.bulk-store') }}", { _token: "{{ csrf_token() }}", items: allItems }, function(res) {
                if(res.success) {
                    localStorage.removeItem(CBMCart.key);
                    if(window.HeavyCart) localStorage.removeItem(window.HeavyCart.key);
                    Swal.fire({icon:'success', title:'تم!', text:res.message}).then(() => window.location.href = "{{ route('client.orders.index') }}");
                }
            }).fail(function() {
                btn.disabled = false; btn.innerHTML = orig;
                Swal.fire({icon:'error', title:'خطأ', text:'فشل إرسال الطلب'});
            });
        }
    };
    
    // Minimal HeavyCart logic to prevent undefined errors
    window.HeavyCart = {
        key: 'heavy_equipment_cart',
        get() { return JSON.parse(localStorage.getItem(this.key)) || []; },
        add(item) {
            let cart = this.get();
            cart.push(item);
            localStorage.setItem(this.key, JSON.stringify(cart));
            this.updateUI();
        },
        remove(index) {
            let cart = this.get();
            cart.splice(index, 1);
            localStorage.setItem(this.key, JSON.stringify(cart));
            this.updateUI();
        },
        updateUI() {
            const cart = this.get();
            const badge = document.getElementById('heavy-cart-count');
            if(badge) { badge.innerText = cart.length; badge.style.display = cart.length > 0 ? 'inline-block' : 'none'; }
            const body = document.getElementById('heavy-cart-items');
            if(!body) return;
            if(cart.length === 0) {
                document.getElementById('heavy-cart-empty').style.display = 'block';
                document.getElementById('heavy-cart-content').style.display = 'none';
                return;
            }
            document.getElementById('heavy-cart-empty').style.display = 'none';
            document.getElementById('heavy-cart-content').style.display = 'block';
            let html = '';
            cart.forEach((i, idx) => {
                html += `<tr>
                    <td><img src="${i.image}" class="rounded border" style="width:40px;height:40px;object-fit:cover;"></td>
                    <td class="fw-bold">${i.name}</td>
                    <td class="english-nums">${i.L}x${i.W}x${i.H}</td>
                    <td class="fw-bold english-nums">${i.qty}</td>
                    <td class="fw-bold text-danger english-nums">${parseFloat(i.totalWeight).toLocaleString()} KG</td>
                    <td class="fw-bold text-warning english-nums">${parseFloat(i.totalPrice).toLocaleString()} ${i.currency}</td>
                    <td><button onclick="HeavyCart.remove(${idx})" class="btn btn-sm btn-link text-danger"><i class="fa-solid fa-trash"></i></button></td>
                </tr>`;
            });
            body.innerHTML = html;
        }
    };

    document.addEventListener('DOMContentLoaded', () => { CBMCart.updateUI(); HeavyCart.updateUI(); });
</script>
@endpush
