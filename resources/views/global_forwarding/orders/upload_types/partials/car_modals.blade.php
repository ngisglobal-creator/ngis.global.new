<!-- Quick Sector Modal -->
<div class="modal fade" id="quickSectorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #3c8dbc 0%, #2b6688 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 20px;"><i class="fa fa-bolt"></i> اضافة قطاع وفرع وقسم جديد</h4>
            </div>
            <form id="quickSectorForm">
                @csrf
                <div class="modal-body" style="padding: 30px; background: #fefefe;">
                    <div class="form-group"><label>اسم القطاع</label><input type="text" name="sector_name" class="form-control" required></div>
                    <div class="form-group row"><div class="col-md-6"><label>اسم الفرع</label><input type="text" name="branch_name" class="form-control" required></div><div class="col-md-6"><label>اسم القسم</label><input type="text" name="category_name" class="form-control" required></div></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">حفظ وإضافة</button></div>
            </form>
        </div>
    </div>
</div>

<!-- Logistics Details Modal -->
<div class="modal fade" id="logisticsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: #3c8dbc; color: white; padding: 15px 20px;">
                <h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-ship"></i> تفاصيل الحاويات ومعايير الأمان</h4>
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;">&times;</button>
            </div>
            <div class="modal-body" id="logistics_modal_body" style="background: #f4f7f6; padding: 25px; max-height: 70vh; overflow-y: auto;"></div>
        </div>
    </div>
</div>

<!-- Images Modal -->
<div class="modal fade" id="imagesModal" tabindex="-1" role="dialog" style="z-index: 10000; background: rgba(0,0,0,0.85);">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%; max-width: 1100px; margin-top: 50px;">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; background: #fff;">
            <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #eee; padding: 15px 25px;">
                <h4 class="modal-title" style="color: #333; font-weight: 700;">معرض الصور</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding: 0; display: flex; height: 650px;">
                <div class="gallery-sidebar" style="width: 120px; border-left: 1px solid #eee; background: #fdfdfd; overflow-y: auto; padding: 15px; display: flex; flex-direction: column; gap: 10px;">
                    <div id="gallery-thumbnails-container" style="display: flex; flex-direction: column; gap: 10px;"></div>
                </div>
                <div class="gallery-main-container" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 20px;">
                    <img id="gallery-main-image" src="" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</div>
