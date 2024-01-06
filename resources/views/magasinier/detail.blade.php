<x-app-layout>
    <div class="py-12">
        <div class="">
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <h2 class="content-header-title float-start mb-0">Historique produit</h2>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="content-body">
                    <!-- Card Advance -->
                    <div class="row match-height">
                        <div class="col-lg-8 col-12">
                            <div class="card card-user-timeline">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <i data-feather="list" class="user-timeline-title-icon"></i>
                                        <h4 class="card-title">Produit Timeline</h4>
                                    </div>
                                    {{-- <i data-feather="more-vertical" class="font-medium-3 cursor-pointer"></i> --}}
                                    <h4>En Stock : <span class="badge bg-success">100</span></h4>
                                </div>
                                <div class="card-body">
                                    <ul class="timeline ms-50">
                                        <li class="timeline-item">
                                            <span class="timeline-point timeline-point-indicator"></span>
                                            <div class="timeline-event">
                                                <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                    <h6>Creation</h6>
                                                    <span class="timeline-event-time me-1">12 min ago</span>
                                                </div>
                                                <p>Creation du produit </p>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="avatar me-50">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-9.jpg" alt="Avatar" width="38" height="38" />
                                                    </div>
                                                    <div class="user-info">
                                                        <h6 class="mb-0">Safidy Mahafaly (Magasinier)</h6>
                                                        <p class="mb-0">Mshop Gagdet</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <span class="timeline-point timeline-point-success timeline-point-indicator"></span>
                                            <div class="timeline-event">
                                                <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                    <h6>Entrée nouveaux produit <span class="badge bg-success">10</span></h6>
                                                    <span class="timeline-event-time me-1">45 min ago</span>
                                                </div>
                                                <p>date : 12-05-2024</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <span class="timeline-point timeline-point-danger timeline-point-indicator"></span>
                                            <div class="timeline-event">
                                                <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                    <h6>Sortie produit <span class="badge bg-danger">10</span></h6>
                                                    <span class="timeline-event-time me-1">45 min ago</span>
                                                </div>
                                                <p>date : 12-05-2024, raison : livraison</p>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card card-payment">
                                <div class="card-header">
                                    <h4 class="card-title">Nouvelle entré</h4>
                                    {{-- <h4 class="card-title text-primary">$455.60</h4> --}}
                                </div>
                                <div class="card-body">
                                    <form action="javascript:void(0);" class="form">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <label class="form-label" for="payment-card-number">Unité</label>
                                                    <input type="number" id="payment-card-number" class="form-control" placeholder="211" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <label class="form-label" for="payment-expiry">Date</label>
                                                    <input type="date" id="payment-expiry" class="form-control" placeholder="MM / YY" />
                                                </div>
                                            </div>
                                            <div class="d-grid col-12">
                                                <button type="button" class="btn btn-primary">Valider</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card card-payment">
                                <div class="card-header">
                                    <h4 class="card-title">Nouvelle sortie</h4>
                                    {{-- <h4 class="card-title text-primary">$455.60</h4> --}}
                                </div>
                                <div class="card-body">
                                    <form action="javascript:void(0);" class="form">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-2">
                                                    <label class="form-label" for="payment-card-number">Unité</label>
                                                    <input type="number" id="payment-card-number" class="form-control" placeholder="211" />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-2">
                                                    <label class="form-label" for="payment-expiry">Date</label>
                                                    <input type="date" id="payment-expiry" class="form-control" placeholder="MM / YY" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <label class="form-label" for="payment-expiry">Raison</label>
                                                    <input type="text" id="payment-expiry" class="form-control" placeholder="Livraison" />
                                                </div>
                                            </div>
                                            <div class="d-grid col-12">
                                                <button type="button" class="btn btn-danger">Valider</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--/ Payment Card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
