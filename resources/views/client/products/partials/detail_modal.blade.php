<!-- Product Detail Modal -->
<div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog" aria-labelledby="productDetailModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background-color: #3c8dbc; color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalProductName" style="font-weight: bold; font-size: 24px;">اسم المنتج</h4>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="row">
                    <!-- Image Gallery Column -->
                    <div class="col-md-6">
                        <div id="mainImageContainer" style="margin-bottom: 20px; border: 1px solid #eee; border-radius: 8px; overflow: hidden; height: 350px;">
                            <img id="modalMainImage" src="" alt="Main Image" style="width: 100%; height: 100%; object-fit: contain; background: #fafafa;">
                        </div>
                        <div id="thumbnailContainer" class="row" style="margin-left: -5px; margin-right: -5px;">
                            <!-- Thumbnails will be injected here -->
                        </div>
                    </div>
                    <!-- Details Column -->
                    <div class="col-md-6">
                        <div style="margin-bottom: 25px;">
                            <h3 style="color: #3c8dbc; font-size: 36px; font-weight: 900; margin: 0;">
                                <span id="modalProductPrice">0</span> <small style="font-size: 18px; color: #777;" id="modalProductCurrency">SAR</small>
                            </h3>
                            <div id="modalProductSector" class="label label-info" style="font-size: 16px; margin-top: 10px; display: inline-block; padding: 5px 15px;">القطاع</div>
                        </div>

                        <div style="background: #fff; padding: 0;">
                            <h5 style="font-weight: bold; color: #2c3e50; font-size: 22px; margin-bottom: 15px; border-bottom: 3px solid #3c8dbc; display: inline-block; padding-bottom: 5px;">وصف المنتج</h5>
                            <div id="modalProductDesc" style="font-size: 18px; line-height: 1.8; color: #444; text-align: justify; margin-bottom: 25px;">
                                تفاصيل المنتج ستظهر هنا...
                            </div>
                        </div>

                        <div style="padding: 20px; background: #f9f9f9; border-radius: 10px; border: 1px dashed #ccc;">
                            <p style="margin: 0; font-size: 18px; color: #666;">
                                <i class="fa fa-cubes text-primary"></i> الكمية المتاحة في المخزن: 
                                <strong id="modalProductQty" style="color: #333; font-size: 22px;">0</strong> وحدة
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #f4f7f6; border-top: 1px solid #eee; padding: 25px 30px;">
                <button type="button" class="btn btn-default btn-lg" data-dismiss="modal" style="border-radius: 6px; padding: 10px 30px;">إلغاء</button>
                <button type="button" id="btnConfirmOrder" class="btn btn-success btn-lg" style="border-radius: 6px; padding: 10px 50px; font-weight: bold; font-size: 20px;">
                    <i class="fa fa-check-circle"></i> تأكيد طلب المنتج الآن
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let currentProductId = null;

$(document).ready(function() {
    // Shared detail modal logic
    $('body').on('click', '.btn-detail-modal', function() {
        const btn = $(this);
        currentProductId = btn.data('id');
        const name = btn.data('name');
        const price = btn.data('price');
        const currency = btn.data('currency');
        const desc = btn.data('desc');
        const qty = btn.data('qty');
        const sector = btn.data('sector');
        const images = btn.data('images');

        // Populate Modal Fields
        $('#modalProductName').text(name);
        $('#modalProductPrice').text(price);
        $('#modalProductCurrency').text(currency || 'SAR');
        $('#modalProductDesc').html(desc);
        $('#modalProductQty').text(qty);
        $('#modalProductSector').text(sector);

        // Populate Image Gallery
        if (images && images.length > 0) {
            $('#modalMainImage').attr('src', images[0]);
            
            let thumbHtml = '';
            images.forEach((img, index) => {
                thumbHtml += `
                    <div class="col-xs-3" style="padding: 5px;">
                        <img src="${img}" class="img-thumbnail img-gallery-thumb" 
                             style="width: 100%; height: 75px; object-fit: cover; cursor: pointer; border: 2px solid ${index === 0 ? '#3c8dbc' : '#eee'}" 
                             onclick="changeModalImage(this, '${img}')">
                    </div>
                `;
            });
            $('#thumbnailContainer').html(thumbHtml);
        } else {
            $('#modalMainImage').attr('src', "{{ asset('dist/img/boxed-bg.jpg') }}");
            $('#thumbnailContainer').html('');
        }
        
        $('#productDetailModal').modal('show');
    });

    $('#btnConfirmOrder').on('click', function() {
        if (!currentProductId) return;
        
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الطلب...');

        $.ajax({
            url: "{{ route('orders.store') }}",
            type: "POST",
            data: {
                product_id: currentProductId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم بنجاح!',
                        text: response.message,
                        confirmButtonText: 'حسناً'
                    });
                    $('#productDetailModal').modal('hide');
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ ما أثناء إرسال الطلب، يرجى المحاولة مرة أخرى.'
                });
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> تأكيد طلب المنتج الآن');
            }
        });
    });
});

function changeModalImage(el, src) {
    $('#modalMainImage').attr('src', src);
    $('.img-gallery-thumb').css('border-color', '#eee');
    $(el).css('border-color', '#3c8dbc');
}
</script>
