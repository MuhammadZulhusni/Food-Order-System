<style>
    /* Modern Banner Section Styles */
    .modern-banner-section {
        background-color: #f7f7f7;
        padding: 5rem 0;
    }
    .modern-banner-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .modern-banner-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    .modern-banner-item img {
        display: block;
        width: 100%;
        height: auto;
        transition: transform 0.3s ease-in-out;
    }
    .modern-banner-item:hover img {
        transform: scale(1.05);
    }
    /* Responsive grid adjustments */
    @media (max-width: 767.98px) {
        .modern-banner-item {
            margin-bottom: 20px;
        }
    }
</style>

<section class="section modern-banner-section">
    <div class="container">
        <div class="row">
            @php
               // Fetch the 4 most recent banner records from the database
               $banner = App\Models\Banner::latest()->limit(4)->get();
            @endphp
            {{-- Loop through each banner record to create the items --}}
            @foreach ($banner as $item) 
                <div class="col-md-3 col-6 d-flex align-items-stretch">
                    <a href="{{ $item->url }}" class="modern-banner-item w-100">
                        <img alt="{{ $item->name ?? 'Banner image' }}" src="{{ asset($item->image) }}" class="img-fluid rounded">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
