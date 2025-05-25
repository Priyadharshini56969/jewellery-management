<!-- Include CSS -->
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" />

<!-- Include JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Jewellery Products</h2>
        <div>
            <a href="<?= base_url('product/create') ?>" class="btn btn-primary me-2">Add Product</a>
            <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- DataTable -->
    <table id="productsTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

<!-- DataTable Script -->
<script>
$(document).ready(function() {
    $('#productsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('product/datatable') ?>",
            type: "POST",
            error: function(xhr) {
                console.error("AJAX Error:", xhr.responseText);
                alert("Failed to load product table.");
            }
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'description' },
            { data: 'price' },
            { data: 'category' },
            {
                data: 'image',
                render: function(data) {
                    return '<img src="<?= base_url('uploads') ?>/' + data + '" width="60">';
                }
            },
            {
                data: 'id',
                render: function(data) {
                    return `
                        <a href="<?= base_url('product/edit/') ?>${data}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= base_url('product/delete/') ?>${data}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    `;
                }
            }
        ]
    });
});
</script>
