<x-app-layout>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">LISTA FIRM</h1>
    </header>
    <section class="page-section portfolio" id="portfolio">
        <div class="container">

            <!-- Portfolio Section Heading-->
            <div class="row justify-content-center">
                <!-- Portfolio Items-->
                @foreach($companies as $company)
                    <div class="col-md-3 col-lg-3 mb-3">
                        <div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal{{$company->id}}">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div><img style="width: 100%" class="img-fluid" src="{{ asset('/storage/logos/logo_'.$company->id.'.png') }}" alt="{{ $company->name }}" />
                        </div>
                    </div>
                @endforeach
            </div>
            @foreach($companies as $company)
                <div class="portfolio-modal modal fade" id="portfolioModal{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="#portfolioModal{{$company->id}}Label" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                            <div class="modal-body text-center">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <!-- Portfolio Modal - Title-->
                                            <h2 class="portfolio-modal-title text-secondary mb-0">{{ $company->name }}</h2>
                                            <!-- Portfolio Modal - Image--><img class="img-fluid rounded mb-5" src="{{ asset('/storage/logos/logo_'.$company->id.'.png') }}" alt="{{ $company->name }}"/>
                                            <!-- Portfolio Modal - Text-->
                                            <p class="mb-5">{{ $company->description }}</p>
                                            <button class="btn btn-primary" href="#" data-dismiss="modal"><i class="fas fa-times fa-fw"></i>Close Window</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
</x-app-layout>
