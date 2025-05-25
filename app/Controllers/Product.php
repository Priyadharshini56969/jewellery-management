<?php namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;

class Product extends Controller
{
    public function index()
    {
        return view('product/index');  // View will load DataTables, which calls ajax endpoint
    }
    

    public function create()
    {
        helper(['form']);
        return view('product/create');
    }
    public function datatable()
{
    $request = service('request');
    $draw = $request->getPost('draw');
    $start = $request->getPost('start');
    $length = $request->getPost('length');
    $search = $request->getPost('search')['value'];
    $order = $request->getPost('order');
    $columns = $request->getPost('columns');

    $model = new ProductModel();
    $builder = $model->builder();

    // Total records without filtering
    $totalRecords = $builder->countAllResults(false);

    // Apply search filter if needed
    if (!empty($search)) {
        $builder->groupStart();
        $builder->like('name', $search);
        $builder->orLike('description', $search);
        $builder->orLike('category', $search);
        $builder->groupEnd();
    }

    // Count filtered records
    $totalFiltered = $builder->countAllResults(false);

    // Order by requested column
    if (!empty($order)) {
        $colIndex = $order[0]['column'];
        $colName = $columns[$colIndex]['data'];
        $dir = $order[0]['dir'];
        $builder->orderBy($colName, $dir);
    }

    // Limit for pagination
    $builder->limit($length, $start);

    $data = $builder->get()->getResultArray();

    // Format data if needed (like image html)

    return $this->response->setJSON([
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data,
    ]);
}


    public function store()
    {
        helper(['form']);
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required',
            'price' => 'required|decimal',
            'category' => 'required',
            'image' => 'uploaded[image]|max_size[image,1024]|is_image[image]'
        ];

        if (! $this->validate($rules)) {
            return view('product/create', ['validation' => $this->validator]);
        }

        $img = $this->request->getFile('image');
        $newName = null;

        if ($img->isValid() && ! $img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads', $newName);

            \Config\Services::image()
                ->withFile(FCPATH . 'uploads/' . $newName)
                ->resize(500, 500, true, 'auto')
                ->save(FCPATH . 'uploads/' . $newName);
        }

        $model = new ProductModel();
        $model->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'category' => $this->request->getPost('category'),
            'image' => $newName
        ]);

        return redirect()->to('/product');
    }

    public function edit($id)
    {
        helper(['form']);
        $model = new ProductModel();
        $data['product'] = $model->find($id);

        if (!$data['product']) {
            return redirect()->to('/product');
        }

        return view('product/edit', $data);
    }

    public function update($id)
    {
        helper(['form']);
        $model = new ProductModel();
        $product = $model->find($id);

        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required',
            'price' => 'required|decimal',
            'category' => 'required',
        ];

        if (! $this->validate($rules)) {
            return view('product/edit', [
                'validation' => $this->validator,
                'product' => $product
            ]);
        }

        $newName = $product['image'];
        $img = $this->request->getFile('image');

        if ($img && $img->isValid() && ! $img->hasMoved()) {
            // Delete old image
            if ($product['image'] && file_exists(FCPATH . 'uploads/' . $product['image'])) {
                unlink(FCPATH . 'uploads/' . $product['image']);
            }

            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads', $newName);

            \Config\Services::image()
                ->withFile(FCPATH . 'uploads/' . $newName)
                ->resize(500, 500, true, 'auto')
                ->save(FCPATH . 'uploads/' . $newName);
        }

        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'category' => $this->request->getPost('category'),
            'image' => $newName
        ]);

        return redirect()->to('/product');
    }

    public function delete($id)
    {
        $model = new ProductModel();
        $product = $model->find($id);

        if ($product && $product['image'] && file_exists(FCPATH . 'uploads/' . $product['image'])) {
            unlink(FCPATH . 'uploads/' . $product['image']);
        }

        $model->delete($id);

        return redirect()->to('/product');
    }
}
