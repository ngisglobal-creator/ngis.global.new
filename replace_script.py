import re

file_path = 'c:/Users/Abdo/Herd/ngis/resources/views/welcome.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

replacements = {
    '>GLOBAL ECOSYSTEM<': '>{{ __(\'home.global_ecosystem\') }}<',
    '>AUTOMOTIVE DIVISION<': '>{{ __(\'home.automotive_division\') }}<',
    '>PARTNER FACTORIES<': '>{{ __(\'home.partner_factories\') }}<',
    '>LOGISTICS HUB<': '>{{ __(\'home.logistics_hub\') }}<',
    '>ACTIVE GLOBAL TRADE ROUTES<': '>{{ __(\'home.active_global_trade_routes\') }}<',
    'GLOBAL INTEGRATED SERVICES': '{{ __(\'home.global_integrated_services\') }}',
    'CHINA HUB ': '{{ __(\'home.china_hub\') }} ',
    'RIYADH HUB': '{{ __(\'home.riyadh_hub\') }}',
    '>FACTORIES PORTAL<': '>{{ __(\'home.factories_portal\') }}<',
    '>Join & Get Certified. Access direct manufacturing lines globally.<': '>{{ __(\'home.factories_portal_desc\') }}<',
    '>REGISTER FACTORY<': '>{{ __(\'home.register_factory\') }}<',
    '>VENDORS PORTAL<': '>{{ __(\'home.vendors_portal\') }}<',
    '>Expand Your Business. Connect with verified strategic partners.<': '>{{ __(\'home.vendors_portal_desc\') }}<',
    '>REGISTER VENDOR<': '>{{ __(\'home.register_vendor\') }}<',
    '>TRADERS PORTAL<': '>{{ __(\'home.traders_portal\') }}<',
    '>Buy Wholesale. Direct access to verified product catalogs.<': '>{{ __(\'home.traders_portal_desc\') }}<',
    '>REGISTER TRADER<': '>{{ __(\'home.register_trader\') }}<',
    '>Verified <span class="text-gold">Products</span> Showcase<': '>{!! __(\'home.verified_products\') !!}<',
    '>Vehicles<': '>{{ __(\'home.tab_vehicles\') }}<',
    '>Heavy Equipment<': '>{{ __(\'home.tab_heavy_equipment\') }}<',
    '>General Goods<': '>{{ __(\'home.tab_general_goods\') }}<',
    '>Electronics<': '>{{ __(\'home.tab_electronics\') }}<',
    '>Shanghai Stock<': '>{{ __(\'home.shanghai_stock\') }}<',
    '>REQUEST SPECS<': '>{{ __(\'home.request_specs\') }}<',
    '>Strategic <span class="text-gold">Partner</span> Factories<': '>{!! __(\'home.strategic_partner\') !!}<',
    '>Direct manufacturing lines with verified NGIS quality control.<': '>{{ __(\'home.strategic_partner_desc\') }}<',
    '>VIEW ALL<': '>{{ __(\'home.view_all\') }}<',
    '>VERIFIED FACTORY<': '>{{ __(\'home.verified_factory\') }}<',
    '>Supplier <span class="text-gold">Market</span> Hub<': '>{!! __(\'home.supplier_market_hub\') !!}<',
    '>Premium wholesale sourcing and distribution for global traders.<': '>{{ __(\'home.supplier_market_hub_desc\') }}<',
    '>EXPLORE MARKET<': '>{{ __(\'home.explore_market\') }}<',
    '>STRATEGIC VENDOR<': '>{{ __(\'home.strategic_vendor\') }}<',
    'MOQ: ': '{{ __(\'home.moq\') }} ',
    '>Track Your <span class="text-gold">Shipment</span><': '>{!! __(\'home.track_your_shipment\') !!}<',
    'placeholder="Enter Bill of Lading / Tracking No."': 'placeholder="{{ __(\'home.track_placeholder\') }}"',
    '>TRACK NOW<': '>{{ __(\'home.track_now\') }}<',
    '> BENGHAZI<': '> {{ __(\'home.benghazi\') }}<',
    '>IN TRANSIT<': '>{{ __(\'home.in_transit\') }}<',
    'JEDDAH <': '{{ __(\'home.jeddah\') }} <',
    'COMPLETED<': '{{ __(\'home.completed\') }}<'
}

for k, v in replacements.items():
    content = content.replace(k, v)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)
print('Replacements done successfully.')
