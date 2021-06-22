<x-app-layout>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">LISTA FIRM</h1>
    </header>
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <div class="row" style="margin-top: -80px; margin-bottom: 100px">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form class="form-inline" role="form" action="{{ route('oferta') }}">
                                <div class="form-group" style="margin-right:10px; margin-left: 10px">
                                    <label class="filter-col"
                                           for="pref-perpage">Województwo:</label>
                                    <select id="pref-perpage" class="form-control" name="area_id">
                                        <option value="0" selected>Dowolne</option>

                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->county }}</option>
                                        @endforeach
                                    </select>
                                </div> <!-- form group [rows] -->
                                <div class="form-group" style="margin-right:10px; margin-left: 10px">
                                    <label class="filter-col" for="pref-search">Nazwa:</label>
                                    <input type="text" class="form-control input-sm" id="pref-search" name="name">
                                </div><!-- form group [search] -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-warning">
                                        <span class="glyphicon glyphicon-record"></span>FILTRUJ
                                    </button>
                                </div>
                            </form>
                            <form class="form-inline" role="form" action="{{ route('map') }}" >
                                <button type="submit" class="btn btn-secondary" style="margin-top: 10px;">SPRAWDŹ DOSTĘPNOŚĆ NA MAPIE</button>
                            </form>
                        </div>
                    </div>
            </div>

                <!-- Portfolio Section Heading-->
                <div class="row justify-content-center" style="margin-top: 50px">
                    <!-- Portfolio Items-->
                    @foreach($companies as $company)
                        <div class="col-md-3 col-lg-3 mb-3">
                            <div class="portfolio-item mx-auto" data-toggle="modal"
                                 data-target="#portfolioModal{{$company->id}}">
                                <div
                                    class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                    <div class="portfolio-item-caption-content text-center text-white"><i
                                            class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img style="width: 100%; max-width:200px; max-height: 200px" class="img-fluid"
                                     src="{{ asset('/storage/logos/logo_'.$company->id.'.png') }}"
                                     alt="{{ $company->name }}"/>
                            </div>
                        </div>
                    @endforeach
                </div>
                @foreach($companies as $company)
                    <div class="portfolio-modal modal fade" id="portfolioModal{{$company->id}}" tabindex="-1"
                         role="dialog" aria-labelledby="#portfolioModal{{$company->id}}Label" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true"><i class="fas fa-times"></i></span></button>
                                <div class="modal-body text-center">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-8">
                                                <!-- Portfolio Modal - Title-->
                                                <h2 class="portfolio-modal-title text-secondary mb-0">{{ $company->name }}</h2>
                                                <!-- Portfolio Modal - Image--><img class="img-fluid rounded mb-5"
                                                                                    style="width: 100%; max-width:300px; max-height: 400px"
                                                                                    src="{{ asset('/storage/logos/logo_'.$company->id.'.png') }}"
                                                                                    alt="{{ $company->name }}"/>
                                                <!-- Portfolio Modal - Text-->
                                                <p class="mb-5">{{ $company->description }}</p>
                                                <form action="{{ route('uslugi') }}">
                                                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                                                    <button class="btn btn-primary" type="submit">
                                                        Przejrzyj ofertę
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    @endforeach
</x-app-layout>
