<main class="container">
    <h1 class="mt-3">Detalle del producto</h1>
    <div class="row my-5">
        <!-- <pre>
            <?= print_r($products) ?>
        </pre> -->
        <?php if (!empty($products)) : ?>
            <div class="col-md-6 col-lg-4 text-center my-2 p-3">
                <div class="card" style="width: 18rem; max-width: 250px; margin: 0 auto;">
                    <img src="<?= URL_BACKEND . '/' . $products['image'] ?>" class="card-img-top" alt="<?= $products['name'] ?>" style="object-fit: contain;">
                    <div class="card-body bg-info-subtle">
                        <h5 class="card-title"><?= $products['name'] ?></h5>
                        <p class="card-text"><?= $products['description'] ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Altura: </b> <?= number_format($products['height'], 2, '.', '') ?> cm</li>
                        <li class="list-group-item"><b>Largo: </b> <?= number_format($products['length'], 2, '.', '') ?> cm</li>
                        <li class="list-group-item"><b>Ancho: </b> <?= number_format($products['width'] , 2, '.', '')?> cm</li>
                    </ul>
                </div>
                <form method="POST" class="form-submit-event-generate mt-3" action="<?= base_url('home/generate') ?>">
                    <textarea name="data_envia" class="d-none" id="data_envia"></textarea>
                    <button type="submit" id="btn_submit_envio" class="btn btn-primary submit_btn d-none">Generar envío</button>
                </form>
            </div>
            <div class="col-md-6 col-lg-8 my-2 bg-light p-3">
                <form method="POST" class="form-submit-event" id="form-submit-event" action="<?= base_url('home/quote') ?>">
                    <div class="row">
                        <div class="col-12">
                            <h3>Datos para el envio</h3>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Nombre</label>
                            <input class="form-control" type="text" name="name" required minlength="2" placeholder="Nombre">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Celular</label>
                            <input class="form-control validate_number" type="tel" name="phone" required minlength="10" maxlength="10" placeholder="Celular">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Código Postal</label>
                            <input class="form-control validate_number" type="tel" name="postalCode" required minlength="5" maxlength="5" placeholder="Código Postal">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Estados</label>
                            <input class="form-control" type="text" name="state" required minlength="2" maxlength="2" placeholder="Estado (dos digitos)">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Ciudad</label>
                            <input class="form-control" type="text" name="city" required minlength="5" maxlength="35" placeholder="Ciudad">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Colonia</label>
                            <input class="form-control" type="text" name="district" required minlength="5" maxlength="35" placeholder="Colonia">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Calle</label>
                            <input class="form-control" type="text" name="street" required minlength="5" maxlength="35" placeholder="Calle">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Número exterior</label>
                            <input class="form-control validate_number" type="tel" name="number" required minlength="1" maxlength="10" placeholder="Número exterior">
                        </div>
                        <input type="hidden" name="product_name" value="<?= $products['name'] ?>">
                        <input type="hidden" name="height" value="<?= $products['height'] ?>">
                        <input type="hidden" name="length" value="<?= $products['length'] ?>">
                        <input type="hidden" name="width" value="<?= $products['width'] ?>">
                        <input type="hidden" name="country" value="MX">
                    </div>
                    <button type="submit" class="btn btn-primary submit_btn mt-3">Cotizar</button>
                    <div class="d-flex justify-content-center mt-3">
                        <div class="form-group" id="error_box">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12 bg-light p-3 text-center d-none" id="data_generate_envia">
                <h4>Datos del envío</h4>
                <p id="carrier"></p>
                <p id="service"></p>
                <p id="trackingNumber"></p>
                <p id="trackUrl"></p>
                <p id="label"></p>
            </div>
        <?php else : ?>
            <h2>Products Not Found</h2>
        <?php endif; ?>
    </div>
</main>