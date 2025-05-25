<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Jewellery Product</h2>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <form action="<?= base_url('product/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">

        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" value="<?= esc($product['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?= esc($product['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= esc($product['price']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <select name="category" class="form-control" required>
                <option value="">Select Category</option>
                <option value="Necklace" <?= $product['category'] === 'Necklace' ? 'selected' : '' ?>>Necklace</option>
                <option value="Ring" <?= $product['category'] === 'Ring' ? 'selected' : '' ?>>Ring</option>
                <option value="Bracelet" <?= $product['category'] === 'Bracelet' ? 'selected' : '' ?>>Bracelet</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Current Image</label><br>
            <?php if ($product['image']): ?>
                <img src="<?= base_url('uploads/' . $product['image']) ?>" width="120">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Change Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Product</button>
        <a href="<?= base_url('product') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
