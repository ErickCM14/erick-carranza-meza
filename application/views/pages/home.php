<main class="container">
    <h1 class="mt-3">Tienda en línea</h1>
    <h3 class="text-center">Los últimos productos</h3>
    <div class="row my-5">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $key => $value) : ?>
                <div class="col-md-6 col-lg-4 text-center my-2">
                    <div class="card" style="width: 18rem; max-width: 250px; margin: 0 auto;">
                        <img src="<?= URL_BACKEND . '/' . $value['image'] ?>" class="card-img-top" alt="<?= $value['name'] ?>" style="object-fit: contain;">
                        <div class="card-body bg-info-subtle">
                            <h5 class="card-title"><?= $value['name'] ?></h5>
                            <p class="card-text"><?= $value['description'] ?></p>
                            <a href="<?= base_url('home/details/' . $value['_id']) ?>" class="btn btn-primary">Comprar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <h2>Products Not Found</h2>
        <?php endif; ?>
    </div>
</main>