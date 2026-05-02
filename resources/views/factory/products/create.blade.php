@extends('factory.layouts.master')

@section('title', __('dashboard.upload_new_products'))

@section('content')
<section class="content-header">
    <h1>
        {{ __('dashboard.upload_new_products') }}
        <small>{{ __('dashboard.add_product_to_store') }}</small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Mode Selection Hero -->
            <div id="mode_selection_hero" style="background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%); padding: 80px 20px; border-radius: 15px; border: 1px solid #eee; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 30px;">
                <h2 style="margin-top: 0; margin-bottom: 40px; font-weight: 800; color: #333; font-size: 32px;">{{ __('dashboard.how_to_upload') }}</h2>
                <div style="display: flex; gap: 30px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('products.create.carton') }}" id="btnHeroCarton" class="btn mode-hero-btn" style="flex: 1; min-width: 300px; max-width: 450px; padding: 50px; font-size: 28px; font-weight: bold; border-radius: 25px; background: #eef7ff; color: #3c8dbc; border: 4px solid #3c8dbc; text-decoration: none;">
                        <i class="fa fa-cubes" style="font-size: 60px; display: block; margin-bottom: 20px;"></i> 
                        {{ __('dashboard.upload_by_carton') }}
                        <p style="font-size: 15px;">{{ __('dashboard.upload_by_carton_desc') }}</p>
                    </a>
                    
                    <a href="{{ route('products.create.special') }}" id="btnHeroSpecial" class="btn mode-hero-btn" style="flex: 1; min-width: 300px; max-width: 450px; padding: 50px; font-size: 28px; font-weight: bold; border-radius: 25px; background: #fffcf0; color: #f39c12; border: 4px solid #f39c12; text-decoration: none;">
                        <i class="fa fa-star" style="font-size: 60px; display: block; margin-bottom: 20px;"></i>
                        {{ __('dashboard.upload_special') }}
                        <p style="font-size: 15px;">{{ __('dashboard.upload_special_desc') }}</p>
                    </a>
                </div>
            </div>

            <div id="full_page_content" style="display: none;">
                <div style="text-align: left; margin-bottom: 20px;" class="no-print">
                    <button type="button" class="btn btn-default" onclick="returnToHero()" style="border-radius: 20px; font-weight: bold; border: 2px solid #ddd; transition: all 0.3s; padding: 8px 25px;">
                        <i class="fa fa-undo"></i> {{ __('dashboard.return_to_selection') }}
                    </button>
                </div>

                <div class="box box-primary" style="border-radius: 15px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <div class="box-header with-border">
                        <h3 class="box-title" id="page_mode_title">{{ __('dashboard.product_info') }}</h3>
                    </div>
                    
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        <input type="hidden" name="custom_order_id" value="{{ request('custom_order_id') }}">
                        
                        <!-- Section 1: General Information -->
                        <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc; border-radius: 12px 12px 0 0;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-info-circle text-primary"></i> {{ __('dashboard.basic_info') }}</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">{{ __('dashboard.sector') }}</label>
                                        <button type="button" class="btn btn-link pull-left" style="font-size: 13px; padding: 0;" data-toggle="modal" data-target="#sectorModal">
                                            <i class="fa fa-plus-circle"></i> {{ __('dashboard.add_sectors') }}
                                        </button>
                                        <button type="button" class="btn btn-link pull-left" style="font-size: 13px; padding: 0 10px 0 0;" data-toggle="modal" data-target="#quickSectorModal">
                                            <i class="fa fa-magic"></i> {{ __('dashboard.add_new_sector') }}
                                        </button>
                                        <select name="sector_id" id="sector_id" class="form-control select2" required>
                                            <option value="">{{ __('dashboard.select_sector') }}</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}">{{ app()->getLocale() == 'ar' ? $sector->name_ar : $sector->name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <label style="font-weight: 600;">{{ __('dashboard.branch') }}</label>
                                            <button type="button" id="btnAddBranch" class="btn btn-link" style="font-size: 13px; padding: 0; display: none;" data-toggle="modal" data-target="#quickBranchModal">
                                                <i class="fa fa-plus-circle"></i> {{ __('dashboard.add_new_branch') }}
                                            </button>
                                        </div>
                                        <select name="branch_id" id="branch_id" class="form-control select2" required disabled>
                                            <option value="">{{ __('dashboard.select_branch') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <label style="font-weight: 600;">{{ __('dashboard.category') }}</label>
                                            <button type="button" id="btnAddCategory" class="btn btn-link" style="font-size: 13px; padding: 0; display: none;" data-toggle="modal" data-target="#quickCategoryModal">
                                                <i class="fa fa-plus-circle"></i> {{ __('dashboard.add_new_category') }}
                                            </button>
                                        </div>
                                        <select name="category_id" id="category_id" class="form-control select2" required disabled>
                                            <option value="">{{ __('dashboard.select_category') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">{{ __('dashboard.product_name') }}</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('dashboard.enter_product_name') }}" required style="height: 45px; font-size: 16px;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">{{ __('dashboard.product_sku') }}</label>
                                        <input type="text" name="sku_main" id="sku_main" class="form-control" placeholder="{{ __('dashboard.enter_sku') }}" style="height: 45px; font-size: 16px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Section 2: Description (Moved Up) -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-file-text-o text-warning"></i> {{ __('dashboard.product_description') }}</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="form-group">
                                <textarea name="description" id="editor" class="form-control" rows="6" placeholder="{{ __('dashboard.description_placeholder') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Section 3: Pricing & Details (Moved Down) -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-money text-success"></i> {{ __('dashboard.pricing_details') }}</h3>
                        </div>
                        <div class="box-body" style="padding: 20px;">
                            <input type="hidden" name="upload_mode" id="upload_mode" value="carton">

                            <div class="table-responsive">
                                <table class="table table-bordered text-center" style="margin-bottom: 0; min-width: 1000px;">
                                    <thead style="background: #f9f9f9; font-weight: bold;">
                                        <tr>
                                            <th style="width: 150px;">{{ __('dashboard.product_name') }}</th>
                                            <th style="width: 100px;">{{ __('dashboard.product_sku') }}</th>
                                            <th style="width: 120px;" id="lbl_unit_price">{{ __('dashboard.unit_price') }}</th>
                                            <th style="width: 100px;" id="lbl_unit_weight">{{ __('dashboard.unit_weight') }}</th>
                                            <th style="width: 110px; display: none;" id="lbl_gross_weight">{{ __('dashboard.gross_weight') }}</th>
                                            <th style="width: 90px;" id="lbl_carton_length">{{ __('dashboard.carton_length_m') }}</th>
                                            <th style="width: 90px;" id="lbl_carton_width">{{ __('dashboard.carton_width_m') }}</th>
                                            <th style="width: 90px;" id="lbl_carton_height">{{ __('dashboard.carton_height_m') }}</th>
                                            <th style="width: 100px; background: #fff9e6;" id="lbl_unit_cbm">{{ __('dashboard.unit_cbm') }}</th>
                                            <th style="width: 120px;" id="lbl_units_per_carton">{{ __('dashboard.units_per_carton') }}</th>
                                            <th style="width: 100px; background: #fff9e6;" id="lbl_carton_cbm">{{ __('dashboard.carton_cbm') }}</th>
                                            <th style="width: 100px; background: #fff9e6;" id="lbl_carton_weight_col">{{ __('dashboard.carton_weight_kg') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" id="table_product_name" class="form-control" placeholder="{{ __('dashboard.product_name') }}" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td>
                                                <input type="text" id="sku" class="form-control" placeholder="ID" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" id="price" class="form-control english-nums" placeholder="0.00" oninput="this.value=toWesternNums(this.value)" style="border: none; border-bottom: 1px solid #ddd;">
                                                    <span class="input-group-addon" style="padding: 0; border: none; background: transparent;">
                                                        <select id="currency_code" style="border: none; background: transparent; font-size: 10px; height: 100%;">
                                                            <option value="USD">$</option>
                                                            <option value="EUR">€</option>
                                                            <option value="CNY">¥</option>
                                                            <option value="SAR">{{ __('dashboard.sar') }}</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" id="piece_weight" class="form-control english-nums" placeholder="0.5" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td style="display: none;" id="col_gross_weight">
                                                <input type="text" id="gross_weight_input" class="form-control english-nums" placeholder="0.6" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td>
                                                <input type="text" id="carton_length" class="form-control english-nums dimension-input" placeholder="0.5" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td>
                                                <input type="text" id="carton_width" class="form-control english-nums dimension-input" placeholder="0.4" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td>
                                                <input type="text" id="carton_height" class="form-control english-nums dimension-input" placeholder="0.4" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td style="background: #fff9e6;">
                                                <input type="text" id="carton_volume_cbm" class="form-control english-nums" readonly style="background: transparent; border: none; text-align: center; font-weight: bold; color: #b8860b;">
                                            </td>
                                            <td>
                                                <input type="text" id="product_piece_count" class="form-control english-nums" placeholder="{{ __('dashboard.quantity') }}" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td style="background: #fff9e6;" id="col_total_cbm">
                                                <input type="text" id="total_cbm" class="form-control english-nums" readonly style="background: transparent; border: none; text-align: center; font-weight: bold; color: #b8860b;">
                                            </td>
                                            <td style="background: #fff9e6;">
                                                <input type="text" id="total_weight" class="form-control english-nums" readonly style="background: transparent; border: none; text-align: center; font-weight: bold; color: #b8860b;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <div class="alert alert-info" style="background: #f0f7ff !important; color: #3c8dbc !important; border: 1px dashed #3c8dbc;">
                                        <i class="fa fa-info-circle"></i> <strong>{{ __('dashboard.calculation_formula') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div style="padding: 10px; background: #f9f9f9; border-radius: 8px; border: 1px solid #eee;">
                                        <span style="font-weight: bold; color: #666;">{{ __('dashboard.moq') }}:</span>
                                        <input type="text" id="min_order_quantity" class="form-control english-nums" placeholder="100" style="display: inline-block; width: 100px; height: 30px; margin-right: 10px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Container Stats Widgets -->
                            <div class="row" style="margin-top: 30px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; padding: 0 15px;">
                                <!-- CBM 1 -->
                                <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <span style="font-weight: bold; font-size: 14px;">CBM 1</span>
                                        <i class="fa fa-cube" style="font-size: 18px; opacity: 0.8;"></i>
                                    </div>
                                    <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                                <!-- 20FT -->
                                <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <span style="font-weight: bold; font-size: 14px;">20FT (28 CBM)</span>
                                        <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                    </div>
                                    <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                                <!-- 40FT -->
                                <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <span style="font-weight: bold; font-size: 14px;">40FT (40 CBM)</span>
                                        <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                    </div>
                                    <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                                <!-- 40HQ -->
                                <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <span style="font-weight: bold; font-size: 14px;">40HQ (68 CBM)</span>
                                        <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                    </div>
                                    <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                                <!-- 45FT -->
                                <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <span style="font-weight: bold; font-size: 14px;">45FT (78 CBM)</span>
                                        <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                    </div>
                                    <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Section 5: Media -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-camera text-danger"></i> {{ __('dashboard.image') }} {{ __('dashboard.and') ?? '&' }} {{ __('dashboard.videos') ?? 'Videos' }}</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="upload-zone" style="border: 2px dashed #ccc; border-radius: 12px; padding: 40px; text-align: center; background: #fafafa; cursor: pointer;" onclick="document.getElementById('product_images').click()">
                                <i class="fa fa-cloud-upload" style="font-size: 48px; color: #bbb;"></i>
                                <h4 style="color: #666; font-weight: 600;">{{ __('dashboard.upload_zone_title') }}</h4>
                                <p style="color: #999;">{{ __('dashboard.upload_zone_desc') }}</p>
                                <input type="file" name="images[]" id="product_images" class="hidden" multiple required accept="image/*">
                            </div>
                            <div id="image_preview" class="row" style="margin-top: 20px;"></div>
                        </div>
                    </div>
                    
                    <div style="text-align: center; margin-top: 30px; margin-bottom: 50px;" class="no-print">
                        <button type="button" id="btnAddToList" class="btn btn-warning" style="width: 300px; height: 55px; border-radius: 30px; font-size: 20px; font-weight: bold; box-shadow: 0 10px 20px rgba(243, 156, 18, 0.3);">
                            <i class="fa fa-plus-circle"></i> {{ __('dashboard.add_to_list') }}
                        </button>
                    </div>
                </form>
            </div> <!-- End full_page_content -->

                <!-- Batch Products Table Section -->
                <div class="row" id="batch_section" style="display: none; margin-top: 30px;">
                    <div class="col-md-12">
                        <div class="box box-solid" style="border: 2px solid #3c8dbc; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 25px;">
                            <div class="box-header with-border" style="background: #eef7ff;">
                                <h3 class="box-title" style="font-weight: bold; color: #3c8dbc;"><i class="fa fa-list"></i> {{ __('dashboard.added_products_list') }}</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center" id="batch_table" style="margin-bottom: 0; font-size: 14px;">
                                        <thead style="background: #3c8dbc; color: white;">
                                            <tr>
                                                <th style="vertical-align: middle;">{{ __('dashboard.image') }}</th>
                                                <th style="vertical-align: middle;">{{ __('dashboard.product_name') }}</th>
                                                <th style="vertical-align: middle;">{{ __('dashboard.product_sku') }}</th>
                                                <th style="vertical-align: middle;" id="lbl_batch_price">{{ __('dashboard.unit_price') }}</th>
                                                <th style="vertical-align: middle;" id="lbl_batch_weight">{{ __('dashboard.unit_weight') }}</th>
                                                <th style="vertical-align: middle; display: none;" id="lbl_batch_gross_weight">{{ __('dashboard.gross_weight') }}</th>
                                                <th style="vertical-align: middle;">{{ __('dashboard.carton_length_m') }}</th>
                                                <th style="vertical-align: middle;">{{ __('dashboard.carton_width_m') }}</th>
                                                <th style="vertical-align: middle;">{{ __('dashboard.carton_height_m') }}</th>
                                                <th style="vertical-align: middle;">{{ __('dashboard.unit_cbm') }}</th>
                                                <th style="vertical-align: middle;" id="lbl_batch_units">{{ __('dashboard.units_per_carton') }}</th>
                                                <th style="vertical-align: middle;" id="lbl_batch_total_cbm">{{ __('dashboard.carton_cbm') }}</th>
                                                <th style="vertical-align: middle;" id="lbl_batch_total_weight">{{ __('dashboard.carton_weight_kg') }}</th>
                                                <th style="vertical-align: middle;" class="no-print">{{ __('dashboard.actions') }}</th>
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
                                    <i class="fa fa-print"></i> {{ __('dashboard.print_preview') }}
                                </button>
                                <button type="button" class="btn btn-success btn-lg" id="btnSaveAll" style="border-radius: 30px; font-weight: bold; padding: 10px 40px; box-shadow: 0 5px 15px rgba(0,166,90,0.3);">
                                    <i class="fa fa-check-circle"></i> {{ __('dashboard.save_all_products') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <!-- Amazon Style Images Modal -->
                <div class="modal fade" id="imagesModal" tabindex="-1" role="dialog" style="z-index: 10000; background: rgba(0,0,0,0.85);">
                    <div class="modal-dialog modal-lg" role="document" style="width: 90%; max-width: 1100px; margin-top: 50px;">
                        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; background: #fff; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
                            <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #eee; padding: 15px 25px; display: flex; align-items: center; justify-content: space-between;">
                                <h4 class="modal-title" style="color: #333; font-weight: 700; font-size: 18px;">
                                    <i class="fa fa-image text-primary"></i> <span style="margin-right: 10px;">معرض الصور (أسلوب أمازون)</span>
                                    <span id="gallery-counter" style="background: #3c8dbc; color: white; padding: 3px 12px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-right: 15px;">1 / 1</span>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #333; opacity: 1; text-shadow: none; font-size: 28px; margin: 0;">&times;</button>
                            </div>
                            <div class="modal-body" style="padding: 0; display: flex; height: 650px;">
                                <!-- Left Sidebar: Thumbnails -->
                                <div class="gallery-sidebar" style="width: 120px; border-left: 1px solid #eee; background: #fdfdfd; overflow-y: auto; padding: 15px; display: flex; flex-direction: column; gap: 10px;">
                                    <div id="gallery-thumbnails-container" style="display: flex; flex-direction: column; gap: 10px;"></div>
                                </div>
                                
                                <!-- Main Display -->
                                <div class="gallery-main-container" style="flex: 1; background: #fff; position: relative; display: flex; align-items: center; justify-content: center; padding: 20px; overflow: hidden;">
                                    <img id="gallery-main-image" src="" style="max-width: 100%; max-height: 100%; object-fit: contain; transition: all 0.3s ease-in-out; border-radius: 4px; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
</section>

</div>

<!-- Quick Sector Modal -->
<div class="modal fade" id="quickSectorModal" tabindex="-1" role="dialog" aria-labelledby="quickSectorModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #3c8dbc 0%, #2b6688 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="quickSectorModalLabel" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-bolt"></i> اضافة قطاع وفرع وقسم جديد
                </h4>
            </div>
            <form id="quickSectorForm">
                @csrf
                <div class="modal-body" style="padding: 30px; background: #fefefe;">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اسم القطاع</label>
                            <input type="text" name="sector_name" class="form-control english-nums" placeholder="مثال: مواد البناء" required style="height: 45px; border-radius: 6px;">
                        </div>
                    </div>
                    
                    <div class="form-group row" style="margin-top: 15px;">
                        <div class="col-md-6">
                            <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اسم الفرع</label>
                            <input type="text" name="branch_name" class="form-control english-nums" placeholder="مثال: حديد" required style="height: 45px; border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اسم القسم</label>
                            <input type="text" name="category_name" class="form-control english-nums" placeholder="مثال: حديد تسليح" required style="height: 45px; border-radius: 6px;">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal" style="border-radius: 30px; padding: 8px 30px; font-weight: 600;">إلغاء</button>
                    <button type="submit" class="btn btn-primary btn-lg" id="btnSaveQuick" style="background: #3c8dbc; border: none; border-radius: 30px; padding: 8px 40px; font-weight: bold; box-shadow: 0 4px 10px rgba(60, 141, 188, 0.3);">
                        موافقة وإضافة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Sector Modal -->
<div class="modal fade" id="sectorModal" tabindex="-1" role="dialog" aria-labelledby="sectorModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #3c8dbc 0%, #2b6688 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="sectorModalLabel" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-plus-circle"></i> إضافة قطاعات لملفك
                </h4>
            </div>
            <form id="ajaxSectorForm">
                @csrf
                <div class="modal-body" style="padding: 30px; background: #fefefe;">
                    <div class="form-group">
                        <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اختر القطاعات التي تعمل بها</label>
                        <select name="sector_ids[]" id="modal_sector_ids" class="form-control select2" multiple="multiple" style="width: 100%;">
                            @foreach($allSectors as $s)
                                <option value="{{ $s->id }}" {{ in_array($s->id, $sectors->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $s->name_ar }}
                                </option>
                            @endforeach
                        </select>
                        <p class="help-block" style="margin-top: 10px; color: #888;">يمكنك اختيار أكثر من قطاع ليتم عرض الفروع والأقسام التابعة لها.</p>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal" style="border-radius: 30px; padding: 8px 30px; font-weight: 600;">إلغاء</button>
                    <button type="submit" class="btn btn-primary btn-lg" id="saveSectorsBtn" style="background: #3c8dbc; border: none; border-radius: 30px; padding: 8px 40px; font-weight: bold; box-shadow: 0 4px 10px rgba(60, 141, 188, 0.3);">
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Branch Modal -->
<div class="modal fade" id="quickBranchModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #00a65a 0%, #008d4c 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-plus-circle"></i> إضافة فرع جديد للقطاع
                </h4>
            </div>
            <form id="quickBranchForm">
                @csrf
                <input type="hidden" name="sector_id" id="modal_sector_id">
                <div class="modal-body" style="padding: 30px; background: #fefefe;">
                    <div class="form-group">
                        <label id="selectedSectorName" style="display: block; margin-bottom: 10px; font-weight: bold; color: #3c8dbc;"></label>
                        <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اسم الفرع الجديد</label>
                        <input type="text" name="branch_name" class="form-control" placeholder="مثال: حديد" required style="height: 45px; border-radius: 6px;">
                    </div>
                </div>
                <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success" id="btnSaveQuickBranch" style="border-radius: 30px; padding: 8px 40px; font-weight: bold;">حفظ وإضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Category Modal -->
<div class="modal fade" id="quickCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-plus-circle"></i> إضافة قسم جديد للفرع
                </h4>
            </div>
            <form id="quickCategoryForm">
                @csrf
                <input type="hidden" name="branch_id" id="modal_branch_id">
                <div class="modal-body" style="padding: 30px; background: #fefefe;">
                    <div class="form-group">
                        <label id="selectedBranchName" style="display: block; margin-bottom: 10px; font-weight: bold; color: #f39c12;"></label>
                        <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اسم القسم الجديد</label>
                        <input type="text" name="category_name" class="form-control" placeholder="مثال: حديد تسليح" required style="height: 45px; border-radius: 6px;">
                    </div>
                </div>
                <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning" id="btnSaveQuickCategory" style="border-radius: 30px; padding: 8px 40px; font-weight: bold; color: white;">حفظ وإضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #3c8dbc 0%, #2b6688 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-edit"></i> تعديل بيانات المنتج في القائمة
                </h4>
            </div>
            <div class="modal-body" style="padding: 25px; background: #fff;">
                <input type="hidden" id="edit_product_idx">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">القطاع</label>
                            <select id="edit_sector_id" class="form-control select2" style="width: 100%;">
                                @foreach($sectors as $s)
                                    <option value="{{ $s->id }}">{{ $s->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">الفرع</label>
                            <select id="edit_branch_id" class="form-control select2" style="width: 100%"></select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">القسم</label>
                            <select id="edit_category_id" class="form-control select2" style="width: 100%"></select>
                        </div>
                    </div>
                    
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label style="font-weight: 700;">اسم المنتج</label>
                            <input type="text" id="edit_name" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">ID المنتج (SKU)</label>
                            <input type="text" id="edit_sku" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">السعر</label>
                            <div class="input-group">
                                <input type="number" id="edit_price" class="form-control" step="0.01">
                                <span class="input-group-addon" id="edit_currency_label"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">وزن القطعة (kg)</label>
                            <input type="number" id="edit_piece_weight" class="form-control" step="0.01">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">عدد القطع في الكرتونة</label>
                            <input type="number" id="edit_product_piece_count" class="form-control">
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">طول الكرتونة (m)</label>
                            <input type="number" id="edit_carton_length" class="form-control dimension-input-edit" step="0.01">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">عرض الكرتونة (m)</label>
                            <input type="number" id="edit_carton_width" class="form-control dimension-input-edit" step="0.01">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">ارتفاع الكرتونة (m)</label>
                            <input type="number" id="edit_carton_height" class="form-control dimension-input-edit" step="0.01">
                        </div>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label style="font-weight: 700;">وصف المنتج</label>
                    <textarea id="edit_description" class="form-control" rows="4"></textarea>
                </div>
                <hr>
                <div class="form-group">
                    <label style="font-weight: 700;">الصور الحالية</label>
                    <div id="edit_images_preview" class="row" style="margin-bottom: 10px;"></div>
                    <label style="font-weight: 700; display: block; margin-top: 15px;">إضافة صور جديدة</label>
                    <input type="file" id="edit_new_images" class="form-control" multiple accept="image/*">
                </div>
            </div>
            <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" onclick="saveBatchProductEdit()" style="border-radius: 30px; padding: 8px 40px; font-weight: bold;">حفظ التعديلات</button>
            </div>
        </div>
    </div>
</div>
@push('css')
<style>
    /* Polished Hero Buttons (Synced with Cars Layout) */
    .mode-hero-btn {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
        border-width: 4px !important;
        text-decoration: none !important;
    }
    .mode-hero-btn:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
    }
    .mode-hero-btn i {
        transition: transform 0.4s ease;
    }
    .mode-hero-btn:hover i {
        transform: scale(1.15);
    }
    .mode-hero-btn.active {
        background: #fff !important;
        border-color: currentColor !important;
    }
    .mode-hero-btn p {
        font-weight: normal;
        margin-top: 15px;
        opacity: 0.8;
    }

    .upload-zone:hover {
        border-color: #3c8dbc !important;
        background: #f0f7ff !important;
    }
    
    .upload-zone:hover i {
        color: #3c8dbc !important;
    }
    
    input::placeholder {
        color: #ccc !important;
        opacity: 0.6;
    }
    
    .nav-tabs-custom > .nav-tabs > li.active {
        border-top-color: #3c8dbc;
    }

    #btnAddToList {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        border: none;
        color: white;
        transition: all 0.3s;
    }

    #btnAddToList:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(230, 126, 34, 0.4);
    }
    
    #batch_table thead th {
        background: linear-gradient(135deg, #1e3a5f 0%, #3c8dbc 100%);
        color: white;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
        border: none;
    }

    #batch_table tbody td {
        vertical-align: middle !important;
        border: 1px solid #f4f4f4;
    }

    /* Premium Cinema Mode Carousel Styles */
    #carouselInner .item {
        background: #0a0a0a;
        height: 600px;
        position: relative;
        overflow: hidden;
    }
    
    .item-bg-blur {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: blur(25px) brightness(0.35);
        transform: scale(1.1);
        z-index: 1;
        pointer-events: none;
    }
    
    #carouselInner .item > img.main-img {
        max-height: 560px;
        max-width: 90%;
        width: auto;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        border: 2px solid rgba(255,255,255,0.05);
        border-radius: 4px;
        object-fit: contain;
    }
    
    .carousel-indicators li {
        width: 10px;
        height: 10px;
        background: rgba(255,255,255,0.3);
        border: none;
        margin: 0 5px;
    }
    
    .carousel-indicators .active {
        width: 12px;
        height: 12px;
        background: #3c8dbc;
        margin: -1px 5px;
    }
    
    .carousel-control:hover .fa {
        color: #3c8dbc !important;
        transform: translateY(-50%) scale(1.1);
        transition: all 0.2s;
    }

    .batch-img {
        width: 45px !important;
        height: 45px !important;
        object-fit: cover !important;
        border-radius: 8px !important;
        border: 1px solid #eee !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05) !important;
    }

    .cbm-badge {
        background: #f0f7ff;
        color: #3c8dbc;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: bold;
    }

    .container-badge {
        font-weight: 800;
        font-size: 16px;
        color: #333;
    }
    
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
        th, td {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
    .gallery-sidebar::-webkit-scrollbar {
        width: 5px;
    }
    .gallery-sidebar::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
    .gallery-thumb {
        width: 100%;
        height: 90px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s;
        background: #fff;
    }
    .gallery-thumb:hover {
        border-color: #3c8dbc;
        transform: scale(1.02);
    }
    /* Mode Card Styling */
    .mode-card.active {
        background: #f0f7ff !important;
        border-color: #3c8dbc !important;
        box-shadow: 0 4px 15px rgba(60, 141, 188, 0.15);
    }
    .mode-card.active h4 {
        color: #3c8dbc !important;
    }
    .mode-card.active .mode-icon i {
        color: #3c8dbc !important;
        opacity: 1 !important;
    }
    .mode-card:hover:not(.active) {
        border-color: #3c8dbc !important;
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<!-- TinyMCE 6 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
    var productsBatch = [];

    function selectMode(mode) {
        $('#mode_selection_hero').fadeOut(400, function() {
            $('#full_page_content').fadeIn(600);
            
            // Update UI based on mode
            if (mode === 'carton') {
                $('#page_mode_title').html('<i class="fa fa-cubes text-primary"></i> رفع منتجات بالكرتونة (Standard Mode)');
            } else {
                $('#page_mode_title').html('<i class="fa fa-star text-orange"></i> رفع منتج خاص (Specialized Mode)');
            }
            
            switchUploadMode(mode);
            
            $('html, body').animate({
                scrollTop: $("#full_page_content").offset().top - 20
            }, 800);
        });
    }

    function returnToHero() {
        $('#full_page_content').fadeOut(400, function() {
            $('#mode_selection_hero').fadeIn(600);
        });
    }

    function switchUploadMode(mode) {
        $('#upload_mode').val(mode);
        $('.mode-card').removeClass('active');
        $('.mode-card .check-mark').hide();
        $('.mode-card .mode-icon i').css('color', '#999');
        
        $(`#mode_${mode}`).addClass('active');
        $(`#mode_${mode} .check-mark`).show();
        $(`#mode_${mode} .mode-icon i').css('color', '#3c8dbc');

        if (mode === 'special') {
            $('#lbl_unit_price').text('سعر المنتج');
            $('#lbl_unit_weight').text('وزن المنتج قبل التغليف / N.W.(KG)');
            $('#lbl_gross_weight').text('وزن المنتج بعد التغليف / G.W.(KG)');
            $('#lbl_unit_cbm').text('حجم المنتج CBM');
            $('#lbl_gross_weight, #col_gross_weight').show();
            $('#lbl_carton_weight_col').hide();
            
            $('#lbl_batch_price').text('سعر المنتج');
            $('#lbl_batch_weight').text('وزن المنتج N.W');
            $('#lbl_batch_gross_weight').show();
            $('#lbl_carton_length').text('طول المنتج (m)');
            $('#lbl_carton_width').text('عرض المنتج (m)');
            $('#lbl_carton_height').text('ارتفاع المنتج (m)');
            $('#lbl_units_per_carton').text('حجم المنتج مع التغليف / Total CBM');
            $('#lbl_batch_units').text('حجم المنتج مع التغليف / Total CBM');
            
            $('#lbl_carton_cbm, #col_total_cbm').show();
            $('#lbl_batch_total_cbm').show();
            
            $('#lbl_batch_total_weight').show();
            $('#product_piece_count').attr('placeholder', 'مثال: 0.5');
        } else {
            $('#lbl_unit_price').text('سعر الوحدة');
            $('#lbl_unit_weight').text('وزن الوحدة');
            $('#lbl_gross_weight').text('وزن المنتج G.W(KG)');
            $('#lbl_unit_cbm').text('CBM الوحدة');
            $('#lbl_gross_weight, #col_gross_weight').hide();
            $('#lbl_carton_weight_col').show();

            $('#lbl_batch_price').text('سعر الوحدة');
            $('#lbl_batch_weight').text('وزن الوحدة');
            $('#lbl_batch_gross_weight').hide();
            $('#lbl_carton_length').text('طول الكرتونة (m)');
            $('#lbl_carton_width').text('عرض الكرتونة (m)');
            $('#lbl_carton_height').text('ارتفاع الكرتونة (m)');
            $('#lbl_units_per_carton').text('عدد الوحدات في الكرتونة');
            $('#lbl_batch_units').text('عدد الوحدات في الكرتونة');
            
            $('#lbl_carton_cbm, #col_total_cbm').show();
            $('#lbl_batch_total_cbm').show();

            $('#lbl_batch_total_weight').show();
            $('#product_piece_count').attr('placeholder', 'عدد القطع');
        }
    }

    // TinyMCE Initialization
    function initTinyMCE(selector, height = 250, isTableOnly = false) {
        let plugins = 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount';
        let toolbar = 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | table help';
        
        if (isTableOnly) {
            toolbar = 'table | undo redo | bold italic forecolor backcolor | alignleft aligncenter alignright | removeformat';
        }

        tinymce.init({
            selector: selector,
            height: height,
            language: 'ar',
            directionality: 'rtl',
            plugins: plugins,
            toolbar: toolbar,
            branding: false,
            promotion: false,
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    }

    $(document).ready(function() {
        // Auto-collapse sidebar for more space
        $('body').addClass('sidebar-collapse');
        
        initTinyMCE('#editor', 300);

        @if(isset($mode))
            selectMode('{{ $mode }}');
        @endif
    });

    // CSRF Token workaround
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Dynamic Dropdowns
    $('#sector_id').on('change', function() {
        var sectorId = $(this).val();
        $('#branch_id').empty().append('<option value="">اختر الفرع</option>').prop('disabled', true);
        $('#category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
        $('#btnAddBranch').hide();
        $('#btnAddCategory').hide();
        
        if (sectorId) {
            $('#btnAddBranch').show();
            $('#modal_sector_id').val(sectorId);
            $('#selectedSectorName').text('القطاع: ' + $('#sector_id option:selected').text());

            $.ajax({
                url: '/api/branches/' + sectorId,
                type: 'GET',
                success: function(data) {
                    $('#branch_id').prop('disabled', false);
                    $.each(data, function(key, value) {
                        $('#branch_id').append('<option value="' + value.id + '">' + value.name_ar + '</option>');
                    });
                }
            });
        }
    });

    $('#branch_id').on('change', function() {
        var branchId = $(this).val();
        $('#category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
        $('#btnAddCategory').hide();
        
        if (branchId) {
            $('#btnAddCategory').show();
            $('#modal_branch_id').val(branchId);
            $('#selectedBranchName').text('الفرع: ' + $('#branch_id option:selected').text());

            $.ajax({
                url: '/api/categories/' + branchId,
                type: 'GET',
                success: function(data) {
                    $('#category_id').prop('disabled', false);
                    $.each(data, function(key, value) {
                        $('#category_id').append('<option value="' + value.id + '">' + value.name_ar + '</option>');
                    });
                }
            });
        }
    });

    // Quick Branch Ajax Submission
    $('#quickBranchForm').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#btnSaveQuickBranch');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ...');
        
        $.ajax({
            url: "{{ route('api.quick-branch') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (res.success) {
                    var newOption = new Option(res.branch.name_ar, res.branch.id, true, true);
                    $('#branch_id').append(newOption).trigger('change');
                    $('#quickBranchModal').modal('hide');
                    $('#quickBranchForm')[0].reset();
                }
                btn.prop('disabled', false).html('حفظ وإضافة');
            },
            error: function() {
                alert('حدث خطأ أثناء حفظ الفرع الجديد.');
                btn.prop('disabled', false).html('حفظ وإضافة');
            }
        });
    });

    // Quick Category Ajax Submission
    $('#quickCategoryForm').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#btnSaveQuickCategory');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ...');
        
        $.ajax({
            url: "{{ route('api.quick-category') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (res.success) {
                    var newOption = new Option(res.category.name_ar, res.category.id, true, true);
                    $('#category_id').append(newOption).trigger('change');
                    $('#quickCategoryModal').modal('hide');
                    $('#quickCategoryForm')[0].reset();
                }
                btn.prop('disabled', false).html('حفظ وإضافة');
            },
            error: function() {
                alert('حدث خطأ أثناء حفظ القسم الجديد.');
                btn.prop('disabled', false).html('حفظ وإضافة');
            }
        });
    });

    // Batch variables
    var productsBatch = [];
    var initialSelectedImagesData = [];

    // Image Preview & Store
    $('#product_images').on('change', function() {
        $('#image_preview').empty();
        var files = Array.from($(this)[0].files);
        initialSelectedImagesData = [];

        for (var i = 0; i < files.length; i++) {
            (function(file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_preview').append('<div class="col-md-2"><img src="' + e.target.result + '" class="img-responsive img-thumbnail" style="margin-bottom: 5px;"></div>');
                    initialSelectedImagesData.push({
                        name: file.name,
                        dataURL: e.target.result
                    });
                }
                reader.readAsDataURL(file);
            })(files[i]);
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

        var description = (typeof tinymce !== 'undefined' && tinymce.get('editor')) 
            ? tinymce.get('editor').getContent() 
            : $('#editor').val();

        var plainDesc = description.replace(/(<([^>]+)>)/ig, "").replace(/&nbsp;/ig, "").trim();
        if (!plainDesc) {
            alert('يجب إدخال التفاصيل في خانة وصف المنتج.');
            return;
        }

        if(initialSelectedImagesData.length === 0) {
            alert('يجب اختيار صورة واحدة على الأقل، (يرجى الانتظار ثانية ليتم تحميل الصورة في المتصفح).');
            return;
        }

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
            name: $('#table_product_name').val() || $('#name').val(),
            sku: $('#sku').val() || $('#sku_main').val(),
            price: priceStr,
            currency_code: currency,
            min_order_quantity: $('#min_order_quantity').val() || 1,
            piece_weight: $('#piece_weight').val(),
            product_piece_count: $('#product_piece_count').val(),
            carton_length: $('#carton_length').val(),
            carton_width: $('#carton_width').val(),
            carton_height: $('#carton_height').val(),
            carton_volume_cbm: $('#carton_volume_cbm').val(),
            total_cbm: $('#total_cbm').val(),
            total_weight: $('#total_weight').val(),
            description: description,
            custom_info: '',
            product_catalog: '',
            images: initialSelectedImagesData,
        };

        productsBatch.push(product);
        renderBatchTable();
        
        // Reset table inputs
        $('#table_product_name').val('');
        $('#sku').val('');
        $('#price').val('');
        $('#piece_weight').val('');
        $('#product_piece_count').val('');
        $('#carton_length').val('');
        $('#carton_width').val('');
        $('#carton_height').val('');
        $('#carton_volume_cbm').val('');
        $('#total_cbm').val('');
        $('#total_weight').val('');

        if (typeof tinymce !== 'undefined') {
            if(tinymce.get('editor')) tinymce.get('editor').setContent('');
        }
        
        calculateNewTable();
        
        // Reset images
        initialSelectedImagesData = [];
        $('#image_preview').empty();
        $('#product_images').val('');

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
            var imgUrl = p.images[0] ? p.images[0].dataURL : '';
            var row = `
                <tr>
                    <td style="text-align: center; width: 60px;">
                        <img src="${imgUrl}" class="batch-img" style="width: 45px !important; height: 45px !important;" onclick="openImagesModal(${p.id})">
                    </td>
                    <td style="text-align: right;">
                        <div style="font-weight: bold; color: #333; font-size: 14px;">${p.name}</div>
                        <div style="font-size: 10px; color: #777;">${p.sector_name} > ${p.category_name}</div>
                    </td>
                    <td style="text-align: center;">
                        <div style="font-weight: bold; color: #333;">${p.sku || '-'}</div>
                    </td>
                    <td style="text-align: center;">
                        <div style="color: #d9534f; font-weight: bold;">
                            ${p.currency_code} <span class="english-nums">${Number(p.price).toLocaleString()}</span>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="english-nums">${p.piece_weight} كجم</div>
                    </td>
                    <td style="text-align: center; ${p.upload_mode === 'special' ? '' : 'display: none;'}">
                        <div class="english-nums">${p.total_weight} كجم</div>
                    </td>
                    <td style="text-align: center;">
                        <div class="english-nums">${Number(p.carton_length).toFixed(2)}</div>
                    </td>
                    <td style="text-align: center;">
                        <div class="english-nums">${Number(p.carton_width).toFixed(2)}</div>
                    </td>
                    <td style="text-align: center;">
                        <div class="english-nums">${Number(p.carton_height).toFixed(2)}</div>
                    </td>
                    <td style="text-align: center; ${p.upload_mode === 'special' ? 'display: none;' : ''}">
                        <div class="english-nums">${p.carton_volume_cbm}</div>
                    </td>
                    <td style="text-align: center; ${p.upload_mode === 'special' ? 'display: none;' : ''}">
                        <div class="english-nums">${p.total_weight} كجم</div>
                    </td>
                    <td style="text-align: center;">
                        <div class="english-nums" style="font-weight: bold;">${p.product_piece_count}</div>
                    </td>
                    <td style="text-align: center; background: #fff9e6;">
                        <div class="cbm-badge english-nums">${p.total_cbm}</div>
                    </td>
                    <td style="text-align: center; background: #fff9e6;">
                        <div class="english-nums" style="font-weight: bold; color: #b8860b;">${p.total_weight} كجم</div>
                    </td>
                    <td style="text-align: center;" class="no-print">
                        <button type="button" class="btn btn-sm btn-primary btn-flat" style="border-radius: 5px; margin-bottom: 5px;" onclick="openEditProductModal(${p.id})">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btn-flat" style="border-radius: 5px;" onclick="removeProduct(${p.id})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
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

        var thumbContainer = $('#gallery-thumbnails-container');
        var mainImg = $('#gallery-main-image');
        thumbContainer.empty();

        var total = product.images.length;
        $('#gallery-counter').text('1 / ' + total);

        product.images.forEach(function(imgData, index) {
            var activeClass = index === 0 ? 'active' : '';
            var thumb = $(`<img src="${imgData.dataURL}" class="gallery-thumb ${activeClass}" data-index="${index}">`);
            
            thumb.on('click hover', function() {
                $('.gallery-thumb').removeClass('active');
                $(this).addClass('active');
                mainImg.attr('src', imgData.dataURL);
                $('#gallery-counter').text((index + 1) + ' / ' + total);
            });

            thumbContainer.append(thumb);
            
            if(index === 0) {
                mainImg.attr('src', imgData.dataURL);
            }
        });

        $('#imagesModal').modal('show');
    };

    // Dynamic Dropdowns Fix for Select2 in modals
    $('#sectorModal').on('shown.bs.modal', function() {
        $('#modal_sector_ids').select2({
            dropdownParent: $('#sectorModal'),
            width: '100%'
        });
    });

    // Sector Modal Ajax Submission
    $('#ajaxSectorForm').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#saveSectorsBtn');
        btn.prop('disabled', true).text('جاري الحفظ...');
        
        $.ajax({
            url: "{{ route('user-sectors.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                btn.prop('disabled', false).text('حفظ التغييرات');
                $('#sectorModal').modal('hide');
                location.reload(); 
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('حفظ التغييرات');
                alert('حدث خطأ أثناء حفظ القطاعات.');
            }
        });
    });

    // Quick Sector Ajax Submission
    $('#quickSectorForm').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#btnSaveQuick');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ...');
        
        $.ajax({
            url: "{{ route('api.quick-sector') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (res.success) {
                    var newOption = new Option(res.sector.name_ar, res.sector.id, true, true);
                    $('#sector_id').append(newOption).trigger('change');
                    
                    setTimeout(function() {
                        $('#branch_id').empty().append(new Option(res.branch.name_ar, res.branch.id, true, true)).prop('disabled', false).trigger('change');
                        $('#category_id').empty().append(new Option(res.category.name_ar, res.category.id, true, true)).prop('disabled', false).trigger('change');
                    }, 500);

                    $('#quickSectorModal').modal('hide');
                    $('#quickSectorForm')[0].reset();
                }
                btn.prop('disabled', false).html('موافقة وإضافة');
            },
            error: function() {
                alert('حدث خطأ أثناء الحفظ السريع.');
                btn.prop('disabled', false).html('موافقة وإضافة');
            }
        });
    });

    // Calculation logic
    function calculateNewTable() {
        var length = parseFloat($('#carton_length').val()) || 0;
        var width = parseFloat($('#carton_width').val()) || 0;
        var height = parseFloat($('#carton_height').val()) || 0;
        var qty = parseFloat($('#product_piece_count').val()) || 0;
        var unitWeight = parseFloat($('#piece_weight').val()) || 0;
        var unitPrice = parseFloat($('#price').val()) || 0;

        // (L * W * H) is the Volume of ONE Unit (PIECE)
        var unitCbm = (length * width * height);
        $('#carton_volume_cbm').val(unitCbm.toFixed(6));

        // Carton Volume is (Unit CBM * Units per Carton)
        var cartonCbm = unitCbm * qty;
        $('#total_cbm').val(cartonCbm.toFixed(6));

        // Total weight per carton (Unit weight * Units per Carton)
        var cartonTotalWeight = unitWeight * qty;
        
        if ($('#upload_mode').val() === 'special') {
            var gw = parseFloat($('#gross_weight_input').val()) || unitWeight;
            $('#total_weight').val(gw.toFixed(2));
        } else {
            $('#total_weight').val(cartonTotalWeight.toFixed(2));
        }

        // Trigger calculations if Unit CBM > 0
        if (unitCbm > 0) {
            const widgets = $('.widget-cbm-calc');
            const currency = $('#currency_code').val() || '$';

            // Base comparison: how many of these CARTONS fit in the container
            // If qty is 0, we treat the unit itself as the object to fit for preview
            const effectiveCartonCbm = cartonCbm > 0 ? cartonCbm : unitCbm;
            const effectiveQty = qty > 0 ? qty : 1;

            // Containers with requested factors
            const containers = [
                { label: 'CBM 1', factor: 1,  weightNote: null,                              maxWeightKg: null  },
                { label: '20ft',  factor: 28, weightNote: 'الحد الأقصى للوزن: 18 - 22 طن', maxWeightKg: 22000 },
                { label: '40ft',  factor: 40, weightNote: 'الحد الأقصى للوزن: 20 - 24 طن', maxWeightKg: 24000 },
                { label: '40HQ',  factor: 68, weightNote: 'الحد الأقصى للوزن: 20 - 24 طن', maxWeightKg: 24000 },
                { label: '45ft',  factor: 78, weightNote: 'الحد الأقصى للوزن: 15 - 20 طن', maxWeightKg: 20000 },
            ];

            // حساب النتائج الأساسية لـ 1 CBM (استخدام الكسور لدعم الأحجام الكبيرة)
            const baseCartons = 1 / effectiveCartonCbm;
            const baseUnits = baseCartons * effectiveQty;
            const baseWeight = baseUnits * unitWeight;
            const basePrice = baseUnits * unitPrice;

            let anyOverweight = false;

            containers.forEach((c, index) => {
                const totalCartonsVal = baseCartons * c.factor;
                const totalUnitsVal = baseUnits * c.factor;
                const totalWeight = baseWeight * c.factor;
                const totalPriceByProduct = basePrice * c.factor;

                const isOverweight = c.maxWeightKg !== null && totalWeight > c.maxWeightKg;
                if (isOverweight) anyOverweight = true;

                const weightNoteHtml = c.weightNote && !isOverweight ? `
                    <div style="margin-top: 6px; padding: 5px 8px; background: rgba(255,220,0,0.2); border-radius: 5px; border: 1px solid rgba(255,220,0,0.4); display: flex; align-items: center; gap: 5px;">
                        <i class="fa fa-exclamation-triangle" style="font-size: 11px; color: #ffe066;"></i>
                        <span style="font-size: 11px; color: #ffe066;">${c.weightNote}</span>
                    </div>` : '';

                const overweightHtml = isOverweight ? `
                    <div style="margin-top: 6px; padding: 6px 10px; background: rgba(255,193,7,0.25); border-radius: 5px; border: 1px solid rgba(255,193,7,0.6); display: flex; align-items: center; gap: 6px;">
                        <i class="fa fa-exclamation-triangle" style="font-size: 13px; color: #ffc107;"></i>
                        <span style="font-size: 11px; color: #ffc107; font-weight: bold;">تنبيه: تجاوز الوزن القياسي! (${(totalWeight/1000).toFixed(1)} طن)</span>
                    </div>` : '';

                widgets.eq(index).html(`
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <div style="display: flex; justify-content: space-between;">
                            <span>عدد الكراتين:</span>
                            <span style="font-weight: bold;">${c.factor === 1 ? totalCartonsVal.toFixed(3) : Math.floor(totalCartonsVal).toLocaleString()}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>إجمالي القطع:</span>
                            <span style="font-weight: bold;">${c.factor === 1 ? totalUnitsVal.toFixed(3) : Math.floor(totalUnitsVal).toLocaleString()}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>الوزن الكلي:</span>
                            <span style="font-weight: bold; color: ${isOverweight ? '#ff6b6b' : 'inherit'};">${totalWeight.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})} kg</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 4px; padding-top: 4px; border-top: 1px solid rgba(255,255,255,0.2);">
                            <span>السعر الإجمالي:</span>
                            <span style="font-weight: bold;">${totalPriceByProduct.toLocaleString()} ${currency}</span>
                        </div>
                        ${weightNoteHtml}
                        ${overweightHtml}
                    </div>
                `);

                widgets.eq(index).closest('div[style*="background"]').css(
                    'background', isOverweight ? 'linear-gradient(135deg, #f39c12, #e67e22)' : '#007bff'
                );
            });

            $('#btnAddToList')
                .prop('disabled', false)
                .html('<i class="fa fa-plus-circle"></i> إضافة المنتج للقائمة')
                .css({ 'background': '' });
        } else {
            $('.widget-cbm-calc').html('');
            $('#btnAddToList').prop('disabled', false).html('<i class="fa fa-plus-circle"></i> إضافة المنتج للقائمة').css({ 'background': '' });
        }
    }

    $('#name').on('input', function() { $('#table_product_name').val($(this).val()); });
    $('#table_product_name').on('input', function() { $('#name').val($(this).val()); });
    $('#sku_main').on('input', function() { $('#sku').val($(this).val()); });
    $('#sku').on('input', function() { $('#sku_main').val($(this).val()); });
    $('input.english-nums, .dimension-input').on('input change', calculateNewTable);

    $('.dimension-input').on('blur', function() {
        var val = parseFloat($(this).val());
        if (!isNaN(val)) {
            $(this).val(val.toFixed(2));
        }
    });

    // Edit Batch Product Logic
    var currentEditImages = [];
    
    window.openEditProductModal = function(id) {
        var product = productsBatch.find(p => p.id === id);
        if(!product) return;

        $('#edit_product_idx').val(id);
        $('#edit_sector_id').val(product.sector_id).trigger('change');
        $('#edit_name').val(product.name);
        $('#edit_sku').val(product.sku);
        $('#edit_price').val(product.price);
        $('#edit_currency_label').text(product.currency_code);
        $('#edit_piece_weight').val(product.piece_weight);
        $('#edit_product_piece_count').val(product.product_piece_count);
        $('#edit_carton_length').val(product.carton_length);
        $('#edit_carton_width').val(product.carton_width);
        $('#edit_carton_height').val(product.carton_height);
        $('#edit_description').val(product.description.replace(/(<([^>]+)>)/ig, "")); // Simple text for modal textarea
        
        currentEditImages = JSON.parse(JSON.stringify(product.images)); // Clone
        renderEditImages();

        // Handle dependent dropdowns for edit modal
        setTimeout(function() {
            $('#edit_branch_id').val(product.branch_id).trigger('change');
            setTimeout(function() {
                $('#edit_category_id').val(product.category_id).trigger('change');
            }, 300);
        }, 300);

        $('#editProductModal').modal('show');
    };

    $('#edit_sector_id').on('change', function() {
        var sid = $(this).val();
        $('#edit_branch_id').empty().append('<option value="">اختر الفرع</option>').prop('disabled', true);
        if(sid) {
            $.ajax({
                url: '/api/branches/' + sid,
                type: 'GET',
                success: function(data) {
                    $('#edit_branch_id').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#edit_branch_id').append('<option value="' + v.id + '">' + v.name_ar + '</option>');
                    });
                }
            });
        }
    });

    $('#edit_branch_id').on('change', function() {
        var bid = $(this).val();
        $('#edit_category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
        if(bid) {
            $.ajax({
                url: '/api/categories/' + bid,
                type: 'GET',
                success: function(data) {
                    $('#edit_category_id').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#edit_category_id').append('<option value="' + v.id + '">' + v.name_ar + '</option>');
                    });
                }
            });
        }
    });

    function renderEditImages() {
        var container = $('#edit_images_preview');
        container.empty();
        currentEditImages.forEach(function(img, idx) {
            container.append(`
                <div class="col-md-3" style="position: relative; margin-bottom: 15px;">
                    <img src="${img.dataURL}" class="img-responsive img-thumbnail" style="height: 80px; width: 100%; object-fit: cover;">
                    <button type="button" class="btn btn-xs btn-danger" style="position: absolute; top: 0; right: 15px; border-radius: 0 0 0 8px;" onclick="removeEditImage(${idx})">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            `);
        });
    }

    window.removeEditImage = function(idx) {
        currentEditImages.splice(idx, 1);
        renderEditImages();
    };

    $('#edit_new_images').on('change', function() {
        var files = Array.from($(this)[0].files);
        files.forEach(function(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                currentEditImages.push({
                    name: file.name,
                    dataURL: e.target.result
                });
                renderEditImages();
            }
            reader.readAsDataURL(file);
        });
        $(this).val('');
    });

    window.saveBatchProductEdit = function() {
        var id = parseInt($('#edit_product_idx').val());
        var idx = productsBatch.findIndex(p => p.id === id);
        if(idx === -1) return;

        var length = parseFloat($('#edit_carton_length').val()) || 0;
        var width = parseFloat($('#edit_carton_width').val()) || 0;
        var height = parseFloat($('#edit_carton_height').val()) || 0;
        var qty = parseFloat($('#edit_product_piece_count').val()) || 0;
        var unitWeight = parseFloat($('#edit_piece_weight').val()) || 0;
        
        var unitCbm = (length * width * height);
        var cartonCbm = unitCbm * qty;
        var cartonTotalWeight = unitWeight * qty;

        productsBatch[idx] = {
            ...productsBatch[idx],
            sector_id: $('#edit_sector_id').val(),
            branch_id: $('#edit_branch_id').val(),
            category_id: $('#edit_category_id').val(),
            sector_name: $('#edit_sector_id option:selected').text(),
            branch_name: $('#edit_branch_id option:selected').text(),
            category_name: $('#edit_category_id option:selected').text(),
            name: $('#edit_name').val(),
            sku: $('#edit_sku').val(),
            price: $('#edit_price').val(),
            piece_weight: $('#edit_piece_weight').val(),
            product_piece_count: $('#edit_product_piece_count').val(),
            carton_length: $('#edit_carton_length').val(),
            carton_width: $('#edit_carton_width').val(),
            carton_height: $('#edit_carton_height').val(),
            carton_volume_cbm: unitCbm.toFixed(6),
            total_cbm: cartonCbm.toFixed(6),
            total_weight: cartonTotalWeight.toFixed(2),
            description: $('#edit_description').val(),
            images: currentEditImages
        };

        renderBatchTable();
        $('#editProductModal').modal('hide');
    };

    $('.dimension-input-edit').on('blur', function() {
        var val = parseFloat($(this).val());
        if (!isNaN(val)) $(this).val(val.toFixed(2));
    });
    $('#btnSaveAll').on('click', async function() {
        if(productsBatch.length === 0) return;
        
        var btn = $(this);
        var originalText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ والرفع (' + productsBatch.length + ' منتج)... يرجى الانتظار').prop('disabled', true);
        
        var successCount = 0;
        var token = $('input[name="_token"]').first().val();
        
        for (var i = 0; i < productsBatch.length; i++) {
            var p = productsBatch[i];
            var formData = new FormData();
            
            formData.append('_token', token);
            formData.append('sector_id', p.sector_id);
            formData.append('branch_id', p.branch_id);
            formData.append('category_id', p.category_id);
            formData.append('name', p.name);
            formData.append('sku', p.sku);
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
            
            p.images.forEach(function(imgData) {
                var arr = imgData.dataURL.split(','),
                    mime = arr[0].match(/:(.*?);/)[1],
                    bstr = atob(arr[1]), 
                    n = bstr.length, 
                    u8arr = new Uint8Array(n);
                while(n--){ u8arr[n] = bstr.charCodeAt(n); }
                var blob = new Blob([u8arr], {type: mime});
                formData.append('images[]', blob, imgData.name);
            });

            try {
                var res = await fetch('{{ route("products.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token
                    }
                });
                
                var data = await res.json();
                
                if(res.ok && data.success) { 
                    successCount++; 
                } else {
                    var errorMsg = 'خطأ في المنتج رقم ' + (i+1) + ': ' + (p.name || '');
                    if (data.errors) {
                        var details = Object.values(data.errors).flat().join('\n- ');
                        errorMsg += '\n\nالأخطاء:\n- ' + details;
                    } else if (data.message) {
                        errorMsg += '\n\n' + data.message;
                    }
                    alert(errorMsg);
                    console.error('Save Error:', data);
                }
            } catch (err) { 
                console.error('Network Error:', err);
                alert('خطأ في الاتصال بالخادم عند حفظ المنتج رقم ' + (i+1));
            }
        }
        
        if(successCount === productsBatch.length) {
            alert('تم حفظ ' + successCount + ' منتج بنجاح!');
            window.location.href = '{{ route("products.index") }}';
        } else {
            alert('اكتملت العملية: تم حفظ ' + successCount + ' من أصل ' + productsBatch.length + ' منتجات.\nيرجى مراجعة الأخطاء المذكورة أعلاه.');
            btn.html(originalText).prop('disabled', false);
            
            // Optional: remove already saved products from batch
            // if (successCount > 0) { ... }
        }
    });

</script>
@endpush
