<!-- Button trigger modal cek ongkir -->
<button id="coModalButton" type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#coModal"></button>

<!-- Modal cek ongkir -->
<div class="modal fade co-modal" id="coModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="coModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="coModalBody" class="modal-body">
                
                <figure class="mb-4 m-0">
                    <img id="coModalLogo" class="co-modal-logo" src="" alt="">
                </figure>

                <section class="row row-cols-1 row-cols-sm-2 mb-4 g-3">
                    <div class="col">
                        <p class="fw-bold mb-0">Asal:</p>
                        <p id="coModalAsal" class="mb-0"></p>
                    </div>
                    <div class="col">
                        <p class="fw-bold mb-0">Tujuan:</p>
                        <p id="coModalTujuan" class="mb-0"></p>
                    </div>
                    <div class="col">
                        <p class="fw-bold mb-0">Berat Paket:</p>
                        <p id="coModalBerat" class="mb-0"></p>
                    </div>
                    <div class="col">
                        <p class="fw-bold mb-0">Dimensi:</p>
                        <p id="coModalDimensi" class="mb-0"></p>
                    </div>
                </section>

                <section id="coModalTarifWrapper"></section>

            </div>
            <div class="modal-footer">
                <button id="coModalClose" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>