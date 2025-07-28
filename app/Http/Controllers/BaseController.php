<?php

namespace App\Http\Controllers;

use App\Service\BaseService;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    protected $service;

    public function __construct(BaseService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function show($id): JsonResponse
    {
        $data = $this->service->find($id);

        if (! $data) {
            return response()->json(['message' => 'Kayıt bulunamadı'], 404);
        }

        return response()->json($data);
    }

    public function destroy($id)
    {

        $deleted = $this->service->delete($id);

        if (! $deleted) {
            return response()->json(['message' => 'Silinecek kayıt bulunamadı'], 404);
        }

        return response()->json(['message' => 'Kayıt başarıyla silindi']);
    }

}
