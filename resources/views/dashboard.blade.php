<x-app-layout>
    <style>
        .flatpickr-prev-month, .flatpickr-next-month{
            display: none;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="">
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}
            <section id="dashboard-analytics mt-4">
                <div class="row match-height">
                    <!-- Greetings Card starts -->

                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-congratulations">
                            <div class="card-body text-center">
                                <img src="{{asset('app-assets/images/elements/decore-left.png')}}" class="congratulations-img-left" alt="card-img-left" />
                                <img src="{{asset('app-assets/images/elements/decore-right.png')}}" class="congratulations-img-right" alt="card-img-right" />
                                <div class="avatar avatar-xl bg-primary shadow">
                                    <div class="avatar-content">
                                        <i data-feather="award" class="font-large-1"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h1 class="mb-1 text-white">Bienvenue ,{{Auth::user()->name}}</h1>
                                    <p class="card-text m-auto w-75">
                                        Passez une bonne journé chez mshop.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Greetings Card ends -->
                    @role('superadministrator')

                    <!-- Subscribers Chart Card starts -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header flex-column align-items-start pb-0">
                                <div class="avatar bg-light-primary p-50 m-0">
                                    <div class="avatar-content">
                                        <i data-feather="users" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder mt-1">{{$client}}</h2>
                                <p class="card-text">Client inscrit</p>
                            </div>
                            <div id="gained-chart"></div>
                        </div>
                    </div>
                    <!-- Subscribers Chart Card ends -->

                    <!-- Orders Chart Card starts -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header flex-column align-items-start pb-0">
                                <div class="avatar bg-light-warning p-50 m-0">
                                    <div class="avatar-content">
                                        <i data-feather="package" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder mt-1">{{$commande}}</h2>
                                <p class="card-text">Commande journalier</p>
                            </div>
                            <div id="order-chart"></div>
                        </div>
                    </div>
                    <!-- Orders Chart Card ends -->
                </div>

                <div class="row match-height">
                    <!-- Avg Sessions Chart Card starts -->
                    <section id="chartjs-chart">
                        <div class="row">
                            <div class="col-xl-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                                        <div class="header-left">
                                            <p class="card-subtitle text-muted mb-25">Benefice Journalier</p>
                                            <h4 class="card-title">74,123 Ar</h4>
                                        </div>
                                        {{-- <div class="header-right d-flex align-items-center mt-sm-0 mt-1">
                                            <i data-feather="calendar"></i>
                                            <input type="text" class="form-control flat-picker border-0 shadow-none bg-transparent pe-0" placeholder="YYYY-MM-DD" />
                                        </div> --}}
                                    </div>
                                    <div class="card-body">
                                        <canvas class="horizontal-bar-chart-ex chartjs" data-height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between pb-0">
                                        <h4 class="card-title">Historique commande</h4>
                                        <div class="dropdown chart-dropdown">
                                            <button class="btn btn-sm border-0 dropdown-toggle p-50" type="button" id="dropdownItem4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                7 dernier jour
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownItem4">
                                                <a class="dropdown-item" href="#">Last 28 Days</a>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                                <a class="dropdown-item" href="#">Last Year</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                                <h1 class="font-large-2 fw-bolder mt-2 mb-0">{{$nombreDeCommandes}}</h1>
                                                <input type="hidden" id="pourcentage" value="{{$pourcentageLivre}}">
                                                <p class="card-text">Tickets</p>
                                            </div>
                                            <div class="col-sm-10 col-12 d-flex justify-content-center">
                                                <div id="support-trackers-chart"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <div class="text-center">
                                                <p class="card-text mb-50">En attente</p>
                                                <span class="font-large-1 fw-bold text-warning">{{$commandesEnAttente}}</span>
                                            </div>
                                            <div class="text-center">
                                                <p class="card-text mb-50">Livré</p>
                                                <span class="font-large-1 fw-bold text-success">{{$commandesLivre}}</span>
                                            </div>
                                            <div class="text-center">
                                                <p class="card-text mb-50">Annulé</p>
                                                <span class="font-large-1 fw-bold">{{$commandesAnnule}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Avg Sessions Chart Card ends -->

                    <!-- Support Tracker Chart Card starts -->

                    <!-- Support Tracker Chart Card ends -->
                </div>
                @endrole



                <!-- List DataTable -->

                <!--/ List DataTable -->
            </section>
        </div>
    </div>
    @push('scripts-bottom')
        <script src="{{asset('app-assets/js/scripts/charts/chart-chartjs.js')}}"></script>
        <script src="{{asset('app-assets/vendors/js/charts/chart.min.js')}}"></script>
        <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
        <!-- END: Page Vendor JS-->

        <!-- BEGIN: Theme JS-->
        <script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
        <script src="{{asset('app-assets/js/core/app.js')}}"></script>
    @endpush
</x-app-layout>
