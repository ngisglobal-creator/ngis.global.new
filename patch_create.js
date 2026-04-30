const fs = require('fs');

const filesToPatch = [
    'resources/views/company/products/create.blade.php',
    'resources/views/factory/products/create.blade.php',
    'resources/views/china/products/create.blade.php'
];

const UI_REPLACEMENT = `
                    <div style="text-align: center; margin-bottom: 50px;" class="no-print">
                        <button type="button" id="btnAddToList" class="btn btn-warning" style="width: 300px; height: 55px; border-radius: 30px; font-size: 20px; font-weight: bold; box-shadow: 0 10px 20px rgba(243, 156, 18, 0.3);">
                            <i class="fa fa-plus-circle"></i> إضافة المنتج للقائمة
                        </button>
                    </div>
                </form>

                <!-- Batch Products Table Section -->
                <div class="row mt-4" id="batch_section" style="display: none;">
                    <div class="col-md-12">
                        <div class="box box-solid" style="border: 2px solid #3c8dbc; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 25px;">
                            <div class="box-header with-border" style="background: #eef7ff;">
                                <h3 class="box-title" style="font-weight: bold; color: #3c8dbc;"><i class="fa fa-list"></i> قائمة المنتجات المُضافة</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center" id="batch_table" style="margin-bottom: 0; font-size: 14px;">
                                        <thead style="background: #3c8dbc; color: white;">
                                            <tr>
                                                <th style="vertical-align: middle;">#</th>
                                                <th style="vertical-align: middle;">الصورة</th>
                                                <th style="vertical-align: middle;">اسم المنتج والقسم</th>
                                                <th style="vertical-align: middle;">السعر</th>
                                                <th style="vertical-align: middle;">الكمية / وزن</th>
                                                <th style="vertical-align: middle;">CBM</th>
                                                <th style="vertical-align: middle; background: #2b6688;">حاوية 20</th>
                                                <th style="vertical-align: middle; background: #2b6688;">حاوية 40</th>
                                                <th style="vertical-align: middle; background: #1e4b66;">حاوية 40HC</th>
                                                <th style="vertical-align: middle;" class="no-print">إجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Rows dynamically added -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer text-center no-print" style="padding: 20px; background: #fcfcfc;">
                                <button type="button" class="btn btn-default btn-lg" onclick="window.print()" style="margin-left: 15px; border-radius: 30px; font-weight: bold; padding: 10px 30px;">
                                    <i class="fa fa-print"></i> طباعة القائمة كمعاينة
                                </button>
                                <button type="button" class="btn btn-success btn-lg" id="btnSaveAll" style="border-radius: 30px; font-weight: bold; padding: 10px 40px; box-shadow: 0 5px 15px rgba(0,166,90,0.3);">
                                    <i class="fa fa-check-circle"></i> حفظ جميع المنتجات ورفعها للسيرفر
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images Modal -->
                <div class="modal fade" id="imagesModal" tabindex="-1" role="dialog" style="z-index: 10000;">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
                            <div class="modal-header" style="background: #3c8dbc; color: white;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-image"></i> صور المنتج</h4>
                            </div>
                            <div class="modal-body text-center" style="background: #000; padding: 0;">
                                <div id="productImagesCarousel" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators" id="carouselIndicators"></ol>
                                    <div class="carousel-inner" id="carouselInner" role="listbox" style="height: 500px; display: flex; align-items: center; justify-content: center;"></div>
                                    <a class="left carousel-control" href="#productImagesCarousel" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#productImagesCarousel" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
`;

const CSS_REPLACEMENT = `
    /* Fix Select2 in Modal */
    .select2-container--open {
        z-index: 9999 !important;
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        #batch_section, #batch_section * {
            visibility: visible;
        }
        #batch_section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
        .main-header, .main-sidebar, .content-header, .box-header:not(#batch_section .box-header) {
            display: none !important;
        }
        body {
            background-color: white !important;
        }
        /* Make background colors print */
        th, td {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
`;

const JS_IMAGE_REPLACEMENT = `
    // Batch variables
    var productsBatch = [];
    var initialSelectedImages = [];

    // Image Preview & Store
    $('#product_images').on('change', function() {
        $('#image_preview').empty();
        var files = Array.from($(this)[0].files);
        initialSelectedImages = files;
        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_preview').append('<div class="col-md-2"><img src="' + e.target.result + '" class="img-responsive img-thumbnail" style="margin-bottom: 5px;"></div>');
            }
            reader.readAsDataURL(files[i]);
        }
    });

    // Add Product To Batch Logic
    $('#btnAddToList').on('click', function() {
        var form = $('#productForm')[0];
        
        // Manual validation since it's a type="button"
        if(!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        if(initialSelectedImages.length === 0) {
            alert('يجب اختيار صورة واحدة على الأقل للمنتج.');
            return;
        }

        var customInfo = JSON.stringify(getTableData('custom_info_table'));
        var productCatalog = JSON.stringify(getTableData('product_catalog_table'));
        var description = (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.editor) 
            ? CKEDITOR.instances.editor.getData() 
            : $('#editor').val();

        var priceStr = parseFloat($('#price').val()) || 0;
        var currency = $('#currency_code').val() || '';

        var product = {
            id: Date.now(),
            sector_id: $('#sector_id').val(),
            branch_id: $('#branch_id').val(),
            category_id: $('#category_id').val(),
            sector_name: $('#sector_id option:selected').text(),
            branch_name: $('#branch_id option:selected').text(),
            category_name: $('#category_id option:selected').text(),
            name: $('#name').val(),
            price: priceStr,
            currency_code: currency,
            min_order_quantity: $('#min_order_quantity').val(),
            piece_weight: $('#piece_weight').val(),
            product_piece_count: $('#product_piece_count').val(),
            carton_length: $('#carton_length').val(),
            carton_width: $('#carton_width').val(),
            carton_height: $('#carton_height').val(),
            carton_volume_cbm: $('#carton_volume_cbm').val(),
            description: description,
            custom_info: customInfo,
            product_catalog: productCatalog,
            images: initialSelectedImages,
            c20: $('#summary_c20').text(),
            c40: $('#summary_c40').text(),
            chc: $('#summary_chc').text()
        };

        productsBatch.push(product);
        renderBatchTable();
        
        // Reset form completely
        form.reset();
        $('#image_preview').empty();
        $('#branch_id').empty().append('<option value="">اختر الفرع</option>').prop('disabled', true);
        $('#category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
        initialSelectedImages = [];
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.editor) CKEDITOR.instances.editor.setData('');
        
        // Reset summaries
        calculateTotal();
        calculateManualResults();
        updateSummaryTable();

        // Scroll to batch table
        $('html, body').animate({
            scrollTop: $("#batch_section").offset().top - 50
        }, 500);
    });

    function renderBatchTable() {
        var tbody = $('#batch_table tbody');
        tbody.empty();
        
        if(productsBatch.length === 0) {
            $('#batch_section').hide();
            return;
        }

        $('#batch_section').show();

        productsBatch.forEach(function(p, index) {
            var imgUrl = URL.createObjectURL(p.images[0]);
            var row = \`
                <tr>
                    <td style="vertical-align: middle;">\${index + 1}</td>
                    <td style="vertical-align: middle;">
                        <img src="\${imgUrl}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid #ddd;" onclick="openImagesModal(\${p.id})" title="انقر لعرض جميع الصور">
                    </td>
                    <td style="vertical-align: middle; font-weight: bold;">
                        \${p.name} <br>
                        <span style="font-size: 11px; color: #888;">\${p.sector_name} > \${p.category_name}</span>
                    </td>
                    <td style="vertical-align: middle; color: #d9534f; font-weight: bold;" class="english-nums">\${p.price} \${p.currency_code}</td>
                    <td style="vertical-align: middle;" class="english-nums">\${p.product_piece_count} قط/كر <br> \${p.piece_weight} كجم</td>
                    <td style="vertical-align: middle; font-weight: bold; color: #3c8dbc;" class="english-nums">\${p.carton_volume_cbm}</td>
                    <td style="vertical-align: middle; background: #fafafa;" class="english-nums">\${p.c20}</td>
                    <td style="vertical-align: middle; background: #fafafa;" class="english-nums">\${p.c40}</td>
                    <td style="vertical-align: middle; background: #f0f7ff; font-weight: bold;" class="english-nums">\${p.chc}</td>
                    <td style="vertical-align: middle;" class="no-print">
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeProduct(\${p.id})" title="حذف"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            \`;
            tbody.append(row);
        });
    }

    window.removeProduct = function(id) {
        if(confirm('هل أنت متأكد من حذف هذا المنتج من القائمة؟')) {
            productsBatch = productsBatch.filter(p => p.id !== id);
            renderBatchTable();
        }
    };

    window.openImagesModal = function(id) {
        var product = productsBatch.find(p => p.id === id);
        if(!product) return;

        var indicators = $('#carouselIndicators');
        var inner = $('#carouselInner');
        indicators.empty();
        inner.empty();

        product.images.forEach(function(file, index) {
            var url = URL.createObjectURL(file);
            var activeClass = index === 0 ? 'active' : '';
            
            indicators.append('<li data-target="#productImagesCarousel" data-slide-to="'+index+'" class="'+activeClass+'"></li>');
            inner.append(\`
                <div class="item \${activeClass}" style="width: 100%;">
                    <img src="\${url}" style="margin: auto; max-height: 500px; object-fit: contain;">
                </div>
            \`);
        });

        $('#imagesModal').modal('show');
    };
`;

const JS_SUBMIT_REPLACEMENT = `
    // Prevent default form submission via enter key
    $('form#productForm').on('submit', function(e) {
        e.preventDefault();
        // Trigger generic ADD instead
        $('#btnAddToList').click();
    });

    // Save All Logic
    $('#btnSaveAll').on('click', async function() {
        if(productsBatch.length === 0) return;
        
        var btn = $(this);
        var originalText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ والرفع (' + productsBatch.length + ' منتج)... يرجى الانتظار').prop('disabled', true);
        
        var successCount = 0;
        
        for (var i = 0; i < productsBatch.length; i++) {
            var p = productsBatch[i];
            var formData = new FormData();
            
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('sector_id', p.sector_id);
            formData.append('branch_id', p.branch_id);
            formData.append('category_id', p.category_id);
            formData.append('name', p.name);
            formData.append('price', p.price);
            formData.append('currency_code', p.currency_code);
            formData.append('min_order_quantity', p.min_order_quantity);
            formData.append('piece_weight', p.piece_weight);
            formData.append('product_piece_count', p.product_piece_count);
            formData.append('carton_length', p.carton_length);
            formData.append('carton_width', p.carton_width);
            formData.append('carton_height', p.carton_height);
            formData.append('carton_volume_cbm', p.carton_volume_cbm);
            formData.append('description', p.description);
            formData.append('custom_info', p.custom_info);
            formData.append('product_catalog', p.product_catalog);
            
            p.images.forEach(function(file) {
                formData.append('images[]', file);
            });

            try {
                var res = await fetch('/products', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                var data = await res.json();
                if(res.ok && data.success) {
                    successCount++;
                } else {
                    console.error('Error saving product:', p.name, data);
                }
            } catch (err) {
                console.error('Network Error:', err);
            }
        }
        
        if(successCount === productsBatch.length) {
            alert('تم حفظ ' + successCount + ' منتج بنجاح!');
            window.location.href = '/products';
        } else {
            alert('تم حفظ ' + successCount + ' من أصل ' + productsBatch.length + ' منتجات. يرجى التحقق من الشبكة والمحاولة مرة أخرى.');
            btn.html(originalText).prop('disabled', false);
        }
    });

    function getTableData(tableId) {
        var data = { headers: [], rows: [] };
        $('#' + tableId + ' thead tr th input').each(function() { data.headers.push($(this).val()); });
        $('#' + tableId + ' tbody tr').each(function() {
            var row = [];
            $(this).find('td input').each(function() { row.push($(this).val()); });
            if (row.length > 0) data.rows.push(row);
        });
        return data;
    }
`;

for (let file of filesToPatch) {
    if (!fs.existsSync(file)) {
        console.log("Not found:", file);
        continue;
    }
    
    let content = fs.readFileSync(file, 'utf8');

    // 1. Replace UI button block
    const oldUiBtn = \`                    <div style="text-align: center; margin-bottom: 50px;">
                        <button type="submit" class="btn btn-primary" style="width: 300px; height: 55px; border-radius: 30px; font-size: 20px; font-weight: bold; box-shadow: 0 10px 20px rgba(60, 141, 188, 0.3);">
                            <i class="fa fa-save"></i> حفظ جميع البيانات وانهاء
                        </button>
                    </div>
                </form>\`;
                
    if(content.includes(oldUiBtn)) {
        content = content.replace(oldUiBtn, UI_REPLACEMENT);
    } else {
        console.log("UI block not found in:", file);
    }

    // 2. CSS Replacement
    const oldCssEnd = \`    .select2-container--open {
        z-index: 9999 !important;
    }
</style>\`;
    if(content.includes(oldCssEnd)) {
        content = content.replace(oldCssEnd, CSS_REPLACEMENT + '\n</style>');
    }

    // 3. JS Image Replacement
    const oldImgJs = \`    // Image Preview
    $('#product_images').on('change', function() {
        $('#image_preview').empty();
        var files = $(this)[0].files;
        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_preview').append('<div class="col-md-2"><img src="' + e.target.result + '" class="img-responsive img-thumbnail" style="margin-bottom: 5px;"></div>');
            }
            reader.readAsDataURL(files[i]);
        }
    });\`;
    if(content.includes(oldImgJs)) {
        content = content.replace(oldImgJs, JS_IMAGE_REPLACEMENT);
    }

    // 4. JS Form Sync Replace
    const oldSyncJs = \`    // Form submission sync
    $('form').on('submit', function() {
        $('#custom_info_input').val(JSON.stringify(getTableData('custom_info_table')));
        $('#product_catalog_input').val(JSON.stringify(getTableData('product_catalog_table')));
    });

    function getTableData(tableId) {
        var data = { headers: [], rows: [] };
        $('#' + tableId + ' thead tr th input').each(function() { data.headers.push($(this).val()); });
        $('#' + tableId + ' tbody tr').each(function() {
            var row = [];
            $(this).find('td input').each(function() { row.push($(this).val()); });
            if (row.length > 0) data.rows.push(row);
        });
        return data;
    }\`;
    if(content.includes(oldSyncJs)) {
        content = content.replace(oldSyncJs, JS_SUBMIT_REPLACEMENT);
    }

    fs.writeFileSync(file, content);
    console.log("Patched:", file);
}
