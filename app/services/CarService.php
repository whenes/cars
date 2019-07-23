<?php

namespace App\Services;

use App\Repositories\CarRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use App\Models\ValidationCar;

class CarService
{
    private $carRepository;

    public function __construct(CarRepositoryInterface $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function getAll()
    {
        $cars = $this->carRepository->getAll();

        try
        {
            if(count($cars) > 0)
            {
                return response()->json($cars, Response::HTTP_OK);
            }
            else
            {
                return response()->json([], Response::HTTP_OK);
            }
        }
        catch(QueryException $ex)
        {
            return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        
    }

    public function get($id)
    {        
        $car = $this->carRepository->get($id);
        
        try
        {
            if($car != null)
            {
                return response()->json($car, Response::HTTP_OK);
            }
            else
            {
                return response()->json(null, Response::HTTP_OK);
            }        
        }
        catch(QueryException $ex)
        {
            return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),            
            ValidationCar::RULLE_CAR            
        );

        if($validator->fails())
        {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        else
        {
            try
            {
                $car = $this->carRepository->store($request); 
                
                return response()->json($car, Response::HTTP_CREATED);
            }
            catch(QueryException $ex)
            {
                return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        
        
        
    }

    public function update ($id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),            
            ValidationCar::RULLE_CAR            
        );

        if($validator->fails())
        {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        else
        {
            try
            {
                $car = $this->carRepository->update($id, $request);  

                return response()->json($car, Response::HTTP_OK);
            }
            catch(QueryException $ex)
            {
                return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        
    }

    public function destroy($id)
    {
        try
        {
            $car = $this->carRepository->destroy($id);

            return response()->json(null, Response::HTTP_OK);
        }
        catch(QueryException $ex)
        {
            return response()->json(['error' => 'Erro de conexão com o banco de dados.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}