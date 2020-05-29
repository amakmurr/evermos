<?php

namespace App\Http\Controllers\Api;

use App\Entities\Container;
use App\Exceptions\VerifiedContainerIsPresents;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContainerCollection;
use Illuminate\Http\Request;

class ContainerController extends Controller
{

    public function index()
    {
        $containers = Container::paginate();
        return new ContainerCollection($containers);
    }

    /**
     * @param Illuminate\Http\Request $request
     */
    public function put(Request $request)
    {
        try {
            $verifiedContainer = Container::where('verified', true)->first();
            if ($verifiedContainer) {
                throw new VerifiedContainerIsPresents("{$verifiedContainer->name}'s container present as verified container");
            }

            $container = Container::inRandomOrder()->first();
            $container->increment('value', 1, [
                'verified' => ($container->value + 1) >= $container->capacity
            ]);

            return response()->json(['message' => "ball stored to {$container->name}'s container"], 200);
        } catch (VerifiedContainerIsPresents $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
