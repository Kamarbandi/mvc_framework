<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorLogger;
use App\Helpers\ImageHelper;
use App\Models\Medication;
use App\Request;
use App\Models\Pager;

class MedicationController extends Controller
{
    public function index()
    {
        $medications = new Medication();

        $limit = 5;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $medications->limit = $limit;
        $medications->offset = $offset;

        $medications = $medications->findAll();

        $dataWithoutImages = array_map(function ($medications) {
            unset($medications->image);
            return $medications;
        }, $medications);

        return $this->response()->json(
            [
                'status' => 'success',
                'message' => 'Article created successfully',
                'data' => [
                    'medications' => $dataWithoutImages,
                    'pagination' => $pager,
                ]
            ], 200
        );
    }

    /**
     * @throws \Exception
     */
    public function store()
    {
        try {
            $req = new Request();
            $data = $req->all();

            if ($file = $req->files('image')) {
                $data['image'] = ImageHelper::upload($file);
                $data['image_type'] = $file['type'];
            }

            $medication = new Medication();
            $store = $medication->create($data);

            if (empty($store['error'])) {
                if (!empty($data['image'])) {
                    unset($data['image_type']);
                    unset($data['image']);
                }
            } else {
                $data = $store;
            }

            return $this->response()->json([
                'status' => 'success',
                'message' => 'Article created successfully',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            ErrorLogger::logException($e);
            return $this->response()->json(["error" => $e->getMessage()], 400);
        }
    }

    public function update($id)
    {
        $req = new Request();
        $data = $req->all();

        $medication = new Medication();
        $store = $medication->edit($id, $data);

        if (empty($store['error'])) {
            $data = $medication->first(['id' => intval($id)]);
            $data = get_object_vars($data);

            if (!empty($data['image'])) {
                unset($data['image_type']);
                unset($data['image']);
            }
        } else {
            return $this->response()->json($store, 400);
        }

        return $this->response()->json($data, 200);
    }

    public function destroy($id)
    {
        $medication = new Medication();

        if ($medication->first(['id' => intval($id)])) {
            $medication->delete(intval($id));
            $message = 'Article deleted successfully';
            $code = 200;
        } else {
            $message = 'Article not found';
            $code = 404;
        }

        return $this->response()->json([
            'status' => 'success',
            'message' => $message,
        ], $code);
    }

    public function getByUserId($id)
    {
        $medication = new Medication();
        $medications = $medication->where(['user_id' => intval($id)]);

        $dataWithoutImages = array_map(function ($medications) {
            unset($medications->image);
            return $medications;
        }, $medications);

        return $this->response()->json([
            'status' => 'success',
            'message' => 'Article updated successfully',
            'data' => $dataWithoutImages
        ], 200);
    }
}
